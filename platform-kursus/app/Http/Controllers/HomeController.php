<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search     = trim($request->input('search'));
        $categoryId = $request->input('category');
        $type       = $request->input('type');  
        $topic      = $request->input('topic'); 

        $popularCourses = Course::with(['teacher', 'category'])
            ->where('status', 'active')
            ->withCount('students')
            ->orderByDesc('students_count')
            ->take(5)
            ->get();

        $query = Course::with(['teacher', 'category'])
            ->where('status', 'active')
            ->withCount('students'); 

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($type)) {
            $query->where('type', $type);
        }

        if (!empty($topic)) {
            $query->where('topic', 'like', '%' . $topic . '%');
        }

        $courses = $query
            ->orderByDesc('students_count')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('home', [
            'popularCourses' => $popularCourses,
            'courses'        => $courses,
            'categories'     => $categories,
            'search'         => $search,
            'categoryId'     => $categoryId,
            'type'           => $type,
            'topic'          => $topic,
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
