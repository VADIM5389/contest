<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentController extends Controller
{
    public function upload(Request $request, Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);

        if ($submission->status !== 'draft') {
            return back()->withErrors(['status' => 'Файлы можно добавлять только в draft']);
        }

        if ($submission->attachments()->count() >= 3) {
            return back()->withErrors(['file' => 'Максимум 3 файла на одну подачу']);
        }

        $data = $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'mimetypes:application/pdf,application/zip,image/png,image/jpeg',
            ],
        ]);

        $file = $data['file'];

        $ext = strtolower($file->getClientOriginalExtension() ?: 'bin');
        $uuid = (string) Str::uuid();
        $storageKey = "submissions/{$submission->id}/" . auth()->id() . "/{$uuid}.{$ext}";

        // S3 upload (Laravel 8 / Flysystem v1)
        Storage::disk('s3')->put($storageKey, file_get_contents($file->getRealPath()), 'private');

        $attachment = Attachment::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType() ?: 'application/octet-stream',
            'size' => $file->getSize(),
            'storage_key' => $storageKey,
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        // если очереди включены — запускаем проверку
        \App\Jobs\ScanAttachmentJob::dispatch($attachment->id);

        return back()->with('ok', 'Файл загружен (S3)');
    }

    public function download(Attachment $attachment)
    {
        if ($attachment->user_id !== auth()->id()) abort(403);

        // Для Flysystem v1 temporaryUrl может быть недоступен в зависимости от версии.
        // Поэтому делаем максимально надежно: пробуем временную ссылку, иначе отдаём файл потоком.
        try {
            $url = Storage::disk('s3')->temporaryUrl($attachment->storage_key, now()->addMinutes(10));
            return redirect()->away($url);
        } catch (\Throwable $e) {
            // Фолбэк: скачать через сервер (надёжно всегда)
            $stream = Storage::disk('s3')->readStream($attachment->storage_key);
            if (!$stream) abort(404);

            return response()->streamDownload(function () use ($stream) {
                fpassthru($stream);
                if (is_resource($stream)) fclose($stream);
            }, $attachment->original_name, [
                'Content-Type' => $attachment->mime,
            ]);
        }
    }
}
