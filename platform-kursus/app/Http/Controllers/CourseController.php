<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Course::with(['teacher'])
            ->withCount(['students', 'contents'])
            ->latest();
        $context   = 'default';
        $backRoute = null;

        if ($user->role === 'admin') {
            $courses  = $query->paginate(10);
            $context  = 'admin-all';
            $backRoute = 'dashboard';
        } elseif ($user->role === 'teacher') {
            $courses  = $query->where('teacher_id', $user->id)->paginate(10);
            $context  = 'teacher-own';
            $backRoute = 'courses.catalog'; 
        } else {
            $courses  = $query->where('status', 'active')->paginate(10);
            $context  = 'student-active';
            $backRoute = 'courses.catalog'; 
        }
        return view('courses.index', compact('courses', 'user', 'context', 'backRoute'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'teacher'])) {
            abort(403, 'You are not allowed to create courses.');
        }

        $teachers = [];
        if ($user->role === 'admin') {
            $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        }

        $categories = Category::orderBy('name')->get();
        return view('courses.create', compact('user', 'teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin', 'teacher'])) {
            abort(403, 'You are not allowed to create courses.');
        }

        $rules = [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail' => 'nullable|image|max:2048',
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', 'in:active,inactive'],
        ];

        if ($user->role === 'admin') {
            $rules['teacher_id'] = ['required', 'exists:users,id'];
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        if ($user->role === 'teacher') {
            $validated['teacher_id'] = $user->id;
        }

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Course $course)
    {
        $user = Auth::user();
        $referer = $request->headers->get('referer');
        $backRoute = 'courses.catalog';

        if ($referer && str_contains($referer, '/dashboard/courses')) {
            $backRoute = 'courses.index';
        }

        $course->load(['teacher', 'category', 'contents', 'students']);

        $totalLessons   = $course->contents->count();
        $isStudent      = $user && $user->role === 'student';
        $isEnrolled     = false;
        $completedCount = 0;
        $progress       = 0;

        return view('courses.show', compact(
            'course',
            'backRoute',
            'totalLessons',
            'isStudent',
            'isEnrolled',
            'completedCount',
            'progress'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $user = Auth::user();

        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403, 'You are not allowed to edit this course.');
        }

        $categories = Category::orderBy('name')->get();

        $teachers = [];
        if ($user->role === 'admin') {
            $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        }

        return view('courses.edit', compact('course', 'user', 'categories', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin','teacher'])) {
            abort(403);
        }

        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403, 'You cannot update this course.');
        }

        $rules = [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'thumbnail' => 'nullable|image|max:2048',
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', 'in:active,inactive'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];

        if ($user->role === 'admin') {
            $rules['teacher_id'] = ['required', 'exists:users,id'];
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $validated['thumbnail'] = $thumbnailPath;
        }

        if ($user->role === 'teacher') {
            $validated['teacher_id'] = $user->id;
        }

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $user = Auth::user();

        if (!in_array($user->role, ['admin','teacher'])) {
            abort(403);
        }

        if ($user->role === 'teacher' && $course->teacher_id !== $user->id) {
            abort(403, 'You cannot delete a course you do not own.');
        }

        $course->delete();

        return redirect()->route('courses.index')
        ->with('success', 'Course deleted successfully.');
    }
}