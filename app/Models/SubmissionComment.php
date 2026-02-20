<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionComment extends Model
{
    protected $table = 'submission_comments';

    protected $fillable = [
        'submission_id',
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
