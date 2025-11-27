<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = $request->user(); 

        if (! $course->students()->where('users.id', $user->id)->exists()) {
            return back()->withErrors([
                'review' => 'You must be enrolled in this course to leave a review.',
            ]);
        }

        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::updateOrCreate(
            [
                'user_id'   => $user->id,
                'course_id' => $course->id,
            ],
            $data
        );

        return back()->with('success', 'Thanks for your review!');
    }
}