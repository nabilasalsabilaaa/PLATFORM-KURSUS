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
        return $this->content_type === 'video'
        && (
            !empty($this->video_path) ||
            filter_var($this->body, FILTER_VALIDATE_URL)
        );
    }

    public function isText()
    {
        return $this->content_type === 'text';
    }

    public function isQuiz()
    {
        return $this->content_type === 'quiz';
    }

    public function getVideoUrl()
    {
        if (! $this->isVideo()) {
            return null;
        }

        $video = $this->video_path ?: $this->body;
        if (!$video) {
            return null;
        }

        if (filter_var($video, FILTER_VALIDATE_URL)) {

            if (str_contains($video, 'youtube.com/watch')) {
                $query = parse_url($video, PHP_URL_QUERY);
                parse_str($query, $params);
                if (!empty($params['v'])) {
                    return 'https://www.youtube.com/embed/' . $params['v'];
                }
            }

            if (str_contains($video, 'youtu.be') || str_contains($video, 'youtube.com/shorts')) {
                $parts = explode('/', rtrim($video, '/'));
                $id = end($parts);
                return 'https://www.youtube.com/embed/' . $id;
            }

            return $video;
        }

        return asset(ltrim($video, '/'));
    }

    public function getQuizQuestions()
    {
        return [];
    }
}