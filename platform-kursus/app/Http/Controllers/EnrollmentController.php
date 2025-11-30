<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course) 
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Only students can enroll courses.');
        }

        if ($course->status !== 'active') {
            return back()->with('error', 'This course is not active.');
        }
        $user->enrolledCourses()->syncWithoutDetaching([$course->id]);

        return back()->with('success', 'You have enrolled in this course.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role !== 'student') {
            abort(403, 'Only students can unenroll courses.');
        }

        $user->enrolledCourses()->detach($course->id);
        return back()->with('success', 'You have unenrolled from this course.');
    }
}
