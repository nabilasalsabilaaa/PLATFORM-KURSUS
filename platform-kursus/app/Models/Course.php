<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

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
        // 'category_id',
    ];

    public function teacher()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }
}
