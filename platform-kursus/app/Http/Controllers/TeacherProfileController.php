<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class TeacherProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user -> role !== 'teacher') {
            abort(403, 'only teacher can access this page');
        }

        $courses = $user->taughtCourses()
            ->withCount('students')
            ->withCount('contents')
            ->get();

        return view('profile.teacher', compact('user', 'courses'));
    }

    public function courseStudents(Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher' || $course->teacher_id !== $user->id) {
            abort(403, 'You are not allowed to see this course.');
        }

        $totalLessons = $course->contents()->count();

        $studentProgress = [];

        foreach ($course->students as $student) {
            $completedCount = $student->completedLessons()
                ->where('course_id', $course->id)
                ->count();

            $progress = $totalLessons > 0
                ? round($completedCount / $totalLessons * 100)
                : 0;

            $studentProgress[] = [
                'student'       => $student,
                'completed'     => $completedCount,
                'total_lessons' => $totalLessons,
                'progress'      => $progress,
            ];
        }

        return view('teacher.course_students', [
            'course'          => $course,
            'studentProgress' => $studentProgress,
            'totalLessons'    => $totalLessons,
        ]);
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
