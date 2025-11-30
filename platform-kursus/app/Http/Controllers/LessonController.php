<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Course $course, Content $content)
    {
        /** @var \App\Models\User $user */
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

        $contents = $course->contents()->orderBy('order')->get();

        $currentIndex = $contents->search(function ($item) use ($content) {
            return $item->id === $content->id;
        });

        $previousLesson = $currentIndex > 0
            ? $contents[$currentIndex - 1]
            : null;

        $nextLesson = $currentIndex < $contents->count() - 1
            ? $contents[$currentIndex + 1]
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
            'contents'        => $contents,
            'previousLesson'  => $previousLesson,
            'nextLesson'      => $nextLesson,
            'isCompleted'     => $isCompleted,
        ]);
    }

    public function markAsDone(Course $course, Content $content)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role !== 'student') {
            abort(403, 'Only students can mark lessons as done.');
        }

        if ($content->course_id !== $course->id) {
            abort(404);
        }

        $user->completedLessons()->syncWithoutDetaching([
            $content->id => [
                'is_done' => true,
                'done_at' => now(),
            ],
        ]);

        $nextLesson = $course->contents()
            ->where('order', '>', $content->order)
            ->orderBy('order', 'asc')
            ->first();
        
        if ($nextLesson) {
            return redirect()->route('lessons.show', [$course, $nextLesson])
                ->with('success', 'Lesson marked as done. Moving to next lesson.');
        }

        return back()->with('success', 'Lesson marked as done. Course completed!');
    }
}