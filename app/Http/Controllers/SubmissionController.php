<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('submissions.index', compact('submissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $submission = Submission::create([
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'draft',
        ]);

        return redirect()->route('submissions.show', $submission)->with('ok', 'Подача создана');
    }

    public function show(Submission $submission)
    {
        // безопасность: участник видит только свои
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }

        $submission->load('attachments');

        return view('submissions.show', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);
        if (!in_array($submission->status, ['draft'], true)) {
            return back()->withErrors(['status' => 'Редактировать можно только в draft']);
        }

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $submission->update($data);

        return back()->with('ok', 'Сохранено');
    }

    public function submit(Submission $submission)
    {
        if ($submission->user_id !== auth()->id()) abort(403);

        if ($submission->status !== 'draft') {
            return back()->withErrors(['status' => 'Отправить можно только из draft']);
        }

        // минимум 1 файл со статусом scanned
        $hasScanned = $submission->attachments()->where('status', 'scanned')->exists();
        if (!$hasScanned) {
            return back()->withErrors(['attachments' => 'Нужен минимум 1 файл со статусом scanned']);
        }

        $submission->update(['status' => 'submitted']);

        return back()->with('ok', 'Подача отправлена (submitted)');
    }
}
