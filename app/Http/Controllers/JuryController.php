<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionComment;
use Illuminate\Http\Request;

class JuryController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $q = Submission::with('user')->latest();

        if ($status) {
            $q->where('status', $status);
        }

        $submissions = $q->paginate(15);

        return view('jury.index', compact('submissions', 'status'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['user','attachments','comments.user']);
        return view('jury.show', compact('submission'));
    }

    public function setStatus(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'status' => ['required','in:draft,submitted,needs_fix,accepted,rejected'],
        ]);

        $submission->update(['status' => $data['status']]);

        return back()->with('ok', 'Статус обновлён');
    }

    public function comment(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'body' => ['required','string','max:5000'],
        ]);

        SubmissionComment::create([
            'submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);

        return back()->with('ok', 'Комментарий добавлен');
    }
}
