<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'order' => 'nullable|integer|min:1',
            'content_type' => 'required|in:text,video', 
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|string|max:20',
        ]);

        $validated['order'] = $validated['order'] ?? $course->contents()->count() + 1;

        $content = new Content();
        $content->title = $validated['title'];
        $content->description = $validated['description'] ?? '';
        $content->content_type = $validated['content_type'];
        $content->order = $validated['order'];
        $content->course_id = $course->id;

        switch ($validated['content_type']) {
            case 'video':
                if ($request->hasFile('video_file')) {
                    $videoPath = $request->file('video_file')->store('courses/videos', 'public');
                    $content->body = $videoPath; 
                } elseif ($request->filled('video_url')) {
                    $content->body = $validated['video_url']; 
                }
                $content->duration = $validated['duration'] ?? null;
                break;
            case 'text':
                $content->body = $validated['body'] ?? '';
                break;
        }
        $content->save();

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
    public function edit(Course $course, Content $content)
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'body' => 'nullable|string',
            'order' => 'nullable|integer|min:1',
            'content_type' => 'required|in:text,video', 
            'video_file' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|string|max:20',
        ]);

        $content->title = $validated['title'];
        $content->description = $validated['description'] ?? '';
        $content->content_type = $validated['content_type'];
        $content->order = $validated['order'];

        switch ($validated['content_type']) {
        case 'video':
            if ($request->hasFile('video_file')) {
                if ($content->body && Storage::disk('public')->exists($content->body)) {
                    Storage::disk('public')->delete($content->body);
                }
                $videoPath = $request->file('video_file')->store('courses/videos', 'public');
                $content->body = $videoPath;
            } elseif ($request->filled('video_url')) {
                $content->body = $validated['video_url'];
            }
            $content->duration = $validated['duration'] ?? null;
            break;
        case 'text':
            $content->body = $validated['body'] ?? '';
            break;
        }
        $content->save();

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

    public function showLesson(Course $course, Content $content)
    {
        $previousLesson = Content::where('course_id', $course->id)
            ->where('order', '<', $content->order)
            ->orderBy('order', 'desc')
            ->first();

        $nextLesson = Content::where('course_id', $course->id)
            ->where('order', '>', $content->order)
            ->orderBy('order', 'asc')
            ->first();

        return view('contents.show', compact('course', 'content', 'previousLesson', 'nextLesson'));
    }

    public function closeQuiz(Course $course, Content $content)
    {
        $nextLesson = Content::where('course_id', $course->id)
            ->where('order', '>', $content->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextLesson) {
            return redirect()->route('contents.show-lesson', [$course, $nextLesson]);
        }

        return redirect()->route('courses.show', $course)
            ->with('info', 'Quiz closed. Returning to course.');
    }

    private function authorizeTeacher($course)
    {
        $user = Auth::user();
        if ($user->role === 'admin') return;
        if ($user->role === 'teacher' && $course->teacher_id == $user->id) return;
        abort(403);
    }
}
