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
        'description',
        'body',
        'content_type',
        'video_path',
        'duration',
        'order',
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
        if (! $this->isVideo()) {
            return null;
        }

        $video = $this->body;

        if (str_contains($video, 'youtube.com/watch')) {
            $videoId = parse_url($video, PHP_URL_QUERY);
            parse_str($videoId, $params);
            if (isset($params['v'])) {
                return "https://www.youtube.com/embed/" . $params['v'];
            }
        }

        if (str_contains($video, 'youtu.be')) {
            $parts = explode('/', $video);
            $id = end($parts);
            return "https://www.youtube.com/embed/" . $id;
        }

        if (str_contains($video, 'youtube.com/shorts')) {
            $parts = explode('/', $video);
            $id = end($parts);
            return "https://www.youtube.com/embed/" . $id;
        }

        if (!filter_var($video, FILTER_VALIDATE_URL)) {
            return asset('storage/' . ltrim($video, '/'));
        }

        return $video;
    }

    public function getQuizQuestions()
    {
        return [];
    }
}