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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
