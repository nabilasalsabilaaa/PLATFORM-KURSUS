<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Only students can access this page.');
        }

        $courses = $user->enrolledCourses()->with('contents')->get();
        $courseProgress = [];
        foreach ($courses as $course) {
            $totalLessons = $course->contents->count();
            $done = $user->completedLessons()
                        ->where('course_id', $course->id)
                        ->count();

            $progress = $totalLessons > 0
                        ? round(($done / $totalLessons) * 100)
                        : 0;

            $courseProgress[$course->id] = $progress;
        }
        return view('profile.student', compact('user', 'courses', 'courseProgress'));
    }
}
