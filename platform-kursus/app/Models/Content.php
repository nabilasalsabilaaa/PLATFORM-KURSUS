<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'body',
        'order',
        'content_type',
        'duration',
        'description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'content_user')
                    ->withPivot('is_done', 'done_at')
                    ->withTimestamps();
    }

    public function isVideo()
    {
        return $this->content_type === 'video';
    }

    public function isText()
    {
        return $this->content_type === 'text';
    }

    public function isQuiz()
    {
        return false;
    }

    public function getVideoUrl()
    {
        if ($this->isVideo()) {
            if (filter_var($this->body, FILTER_VALIDATE_URL)) {
                return $this->body; 
            }
            return asset('storage/' . $this->body); 
        }
        return null;
    }

    public function getQuizQuestions()
    {
        return [];
    }
}