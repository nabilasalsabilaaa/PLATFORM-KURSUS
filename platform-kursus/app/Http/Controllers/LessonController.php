<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content, Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Only students can access lessons.');
        }

        if (!$user->enrolledCourses->contains($course->id)) {
            abort(403, 'You must enroll to access this course.');
        }

        if ($content->course_id !== $course->id) {
            abort(404);
        }

        $contents = $course->contents;

        return view('lessons.show', compact('course', 'content', 'contents', 'user'));
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

    public function markAsDone(Course $course, Content $content)
    {
        $user = Auth::user();
        if (!$user->enrolledCourses->contains($course->id)) {
            abort(403);
        }

        $user->learnedContents()->syncWithoutDetaching([
            $content->id => [
                'is_done' => true,
                'done_at' => now(),
            ]
        ]);

        return back()->with('success', 'Marked as done.');
    }
}
