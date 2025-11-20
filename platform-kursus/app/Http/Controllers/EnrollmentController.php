<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, Course $course) 
    {
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
    public function destroy(Course $course)
    {
        $user = Auth::user();
        if ($user->role !== 'student') {
            abort(403, 'Only students can unenroll courses.');
        }

        $user->enrolledCourses()->detach($course->id);
        return back()->with('success', 'You have unenrolled from this course.');
    }
}
