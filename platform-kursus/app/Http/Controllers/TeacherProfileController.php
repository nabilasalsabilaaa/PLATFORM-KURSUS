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
        return redirect()->route('courses.index');
    }

    public function courseStudents(Course $course)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && ($user->role !== 'teacher' || $course->teacher_id !== $user->id)) {
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
}
