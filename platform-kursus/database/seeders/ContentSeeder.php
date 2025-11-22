<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        foreach ($courses as $course) {
            for ($i = 1; $i <= 4; $i++) {
                Content::create([
                    'course_id' => $course->id,
                    'title'     => "Lesson $i for {$course->title}",
                    'body'      => "Ini adalah isi materi ke-$i.",
                    'order'     => $i,
                ]);
            }
        }
    }
}
