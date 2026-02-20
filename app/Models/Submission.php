<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['user_id','title','description','status'];

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function comments()
    {
        return $this->hasMany(SubmissionComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
