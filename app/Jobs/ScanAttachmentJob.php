<?php

namespace App\Jobs;

use App\Models\Attachment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ScanAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $attachmentId;

    public function __construct(int $attachmentId)
    {
        $this->attachmentId = $attachmentId;
    }

    public function handle(): void
    {
        $attachment = Attachment::find($this->attachmentId);
        if (!$attachment) return;

        // имитация проверки
        sleep(2);

        // Проверяем файл в S3
        if (!Storage::disk('s3')->exists($attachment->storage_key)) {
            $attachment->update([
                'status' => 'rejected',
                'rejection_reason' => 'Файл не найден в S3',
            ]);
            return;
        }

        $name = mb_strtolower($attachment->original_name);

        if (str_contains($name, 'virus') || str_contains($name, 'вирус')) {
            $attachment->update([
                'status' => 'rejected',
                'rejection_reason' => 'Файл не прошёл проверку',
            ]);
            return;
        }

        $attachment->update([
            'status' => 'scanned',
            'rejection_reason' => null,
        ]);
    }
}
