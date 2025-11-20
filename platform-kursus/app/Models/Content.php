<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
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

    
}