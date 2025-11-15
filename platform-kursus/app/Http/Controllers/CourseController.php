<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // admin lihat semua course
            $courses = Course::with('teacher')->latest()->paginate(10);
        } elseif ($user->role === 'teacher') {
            // teacher cuma lihat course yang dia ajar
            $courses = Course::with('teacher')
                ->where('teacher_id', $user->id)
                ->latest()
                ->paginate(10);
        } else {
            // student (atau role lain) lihat cuma course yang active
            $courses = Course::with('teacher')
                ->where('status', 'active')
                ->latest()
                ->paginate(10);
        }

        return view('courses.index', compact('courses', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // hanya admin & teacher yang boleh bikin course
        if (!in_array($user->role, ['admin', 'teacher'])) {
            abort(403, 'You are not allowed to create courses.');
        }

        // kalau admin, boleh pilih teacher dari dropdown
        // kalau teacher biasa, dia hanya pakai dirinya sendiri
        $teachers = [];

        if ($user->role === 'admin') {
            $teachers = User::where('role', 'teacher')->orderBy('name')->get();
        }

        return view('courses.create', compact('user', 'teachers'));
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

        // Validasi
        $rules = [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date'  => ['nullable', 'date'],
            'end_date'    => ['nullable', 'date', 'after_or_equal:start_date'],
            'status'      => ['required', 'in:active,inactive'],
        ];

        // kalau admin, dia bisa pilih teacher_id dari form
        if ($user->role === 'admin') {
            $rules['teacher_id'] = ['required', 'exists:users,id'];
        }

        $validated = $request->validate($rules);

        // jika role = teacher, pakai id diri sendiri sebagai teacher_id
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
