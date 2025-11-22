<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\Category;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = user::where('role', 'tecaher')->get();
        $categories = Category::all();

        foreach ($teachers as $teacher) {
            Course::create([
                'title'       => 'Course by ' . $teacher->name,
                'description' => 'Deskripsi kursus contoh.',
                'start_date'  => now(),
                'end_date'    => now()->addMonth(),
                'status'      => 'active',
                'teacher_id'  => $teacher->id,
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
