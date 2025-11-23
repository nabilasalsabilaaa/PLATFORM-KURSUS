<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PublicCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $categoryId = $request->input('category');

        $query = Course::with(['teacher', 'category'])
            ->where('status', 'active')
            ->withCount('students')
            ->withCount('contents'); 

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $courses = $query->paginate(10);
        $categories = Category::orderBy('name')->get();

        $enrolledCourseIds = [];
        $courseProgress = [];

        if (Auth::check() && Auth::user()->role === 'student') {
            $student = Auth::user();

            $enrolledCourseIds = $student->enrolledCourses()
                ->pluck('courses.id')
                ->toArray();

            foreach ($courses as $course) {
                $totalLessons = $course->contents_count; 
                if ($totalLessons == 0) {
                    $courseProgress[$course->id] = 0;
                    continue;
                }

                $completedCount = $student->completedLessons()
                    ->where('course_id', $course->id)
                    ->count();

                $courseProgress[$course->id] = round($completedCount / $totalLessons * 100);
            }
        }

        return view('courses.catalog', [
            'courses'           => $courses,
            'categories'        => $categories,
            'search'            => $search,
            'categoryId'        => $categoryId,
            'enrolledCourseIds' => $enrolledCourseIds,
            'courseProgress'    => $courseProgress,
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
    public function show(Course $course)
    {
        $user = Auth::user();

        if ($course->status !== 'active') {
            if (! $user || ! in_array($user->role, ['admin', 'teacher'])) {
                abort(404);
            }
            if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
                abort(404);
            }
        }

        $course->load([
            'teacher',
            'category',
            'contents' => function ($q) {
                $q->orderBy('order')->orderBy('id');
            },
        ]);

        $totalLessons = $course->contents->count();

        $isStudent      = $user && $user->role === 'student';
        $isEnrolled     = false;
        $completedCount = 0;
        $progress       = 0;

        if ($isStudent) {
            $isEnrolled = $user->enrolledCourses()
            ->where('course_id', $course->id)
            ->exists();

            if ($isEnrolled && $totalLessons > 0) {
                $completedCount = $user->completedLessons()
                    ->where('course_id', $course->id)
                    ->count();
                $progress = round($completedCount / $totalLessons * 100);
            }
        }

        return view('courses.show', [
            'course'         => $course,
            'totalLessons'   => $totalLessons,
            'isStudent'      => $isStudent,
            'isEnrolled'     => $isEnrolled,
            'completedCount' => $completedCount,
            'progress'       => $progress,
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
}
