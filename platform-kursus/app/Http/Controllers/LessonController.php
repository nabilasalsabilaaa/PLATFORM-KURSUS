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

        if ($content->course_id !== $course->id) {
            abort(404);
        }

        if ($user->role !== 'student') {
            abort(403, 'Only students can access lessons.');
        }

        $isEnrolled = $user->enrolledCourses()->where('course_id', $course->id)->exists();
        if (! $isEnrolled) {
            return redirect()->route('courses.catalog')
                ->with('error', 'You must enroll this course first.');
        }

        $lessons = $course->contents()->orderBy('id')->get();

        $currentIndex = $lessons->search(function ($item) use ($content) {
            return $item->id === $content->id;
        });

        $previousLesson = $currentIndex > 0
            ? $lessons[$currentIndex - 1]
            : null;

        $nextLesson = $currentIndex < $lessons->count() - 1
            ? $lessons[$currentIndex + 1]
            : null;

        $previousCompleted = true;
        if ($previousLesson) {
        $previousCompleted = $user->completedLessons()
            ->where('course_id', $course->id)
            ->where('content_id', $previousLesson->id)
            ->exists();
        }

        if ($previousLesson && ! $previousCompleted) {
            return redirect()
                ->route('lessons.show', [$course->id, $previousLesson->id])
                ->with('error', 'You must complete the previous lesson first.');
        }

        $isCompleted = $user->completedLessons()
            ->where('course_id', $course->id)
            ->where('content_id', $content->id)
            ->exists();

        return view('lessons.show', [
            'course'          => $course,
            'content'         => $content,
            'previousLesson'  => $previousLesson,
            'nextLesson'      => $nextLesson,
            'isCompleted'     => $isCompleted,
        ]);
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

        if ($user->role !== 'student') {
            abort(403, 'Only students can mark lessons as done.');
        }

        if ($content->course_id !== $course->id) {
            abort(404);
        }

        $user->completedLessons()->syncWithoutDetaching([
            $content->id => ['course_id' => $course->id],
        ]);

        return back()->with('success', 'Lesson marked as done.');
    }
}
