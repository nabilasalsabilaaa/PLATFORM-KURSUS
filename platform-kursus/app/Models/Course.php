<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Category;
use App\Models\Enrollment;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'teacher_id',
        'category_id',
        'thumbnail',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class)->orderBy('order');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user')
                    ->withTimestamps();
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getThumbnailUrlAttribute()
    {
        if (!$this->thumbnail) {
            return null;
        }
        
        if (filter_var($this->thumbnail, FILTER_VALIDATE_URL)) {
            return $this->thumbnail;
        }
        
        return asset('storage/' . $this->thumbnail);
    }

    public function videoLessons()
    {
        return $this->contents()->where('content_type', 'video');
    }

    public function quizzes()
    {
        return $this->contents()->where('content_type', 'quiz');
    }
}