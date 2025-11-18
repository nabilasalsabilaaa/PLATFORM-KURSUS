<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $this->authorizeTeacher($course);

        $contents = $course->contents;

        return view('contents.index', compact('course', 'contents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        $this->authorizeTeacher($course);

        return view('contents.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $this->authorizeTeacher($course);

        $validated = $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
        ]);

        $validated['order'] = $validated['order'] ?? $course->contents()->count() + 1;

        $course->contents()->create($validated);

        return redirect()->route('contents.index', $course->id)
            ->with('success', 'Content added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $this->authorizeTeacher($course);

        return view('contents.edit', compact('course', 'content'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Content $content)
    {
        $this->authorizeTeacher($course);

        $validated = $request->validate([
            'title' => ['required', 'string'],
            'body' => ['nullable', 'string'],
            'order' => ['required', 'integer'],
        ]);

        $content->update($validated);

        return redirect()->route('contents.index', $course->id)
            ->with('success', 'Content updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Content $content)
    {
        $this->authorizeTeacher($course);

        $content->delete();

        return redirect()->route('contents.index', $course->id)
            ->with('success', 'Content deleted.');
    }

    private function authorizeTeacher($course)
    {
        $user = Auth::user();

        if ($user->role === 'admin') return;

        if ($user->role === 'teacher' && $course->teacher_id == $user->id) return;

        abort(403);
    }
}
