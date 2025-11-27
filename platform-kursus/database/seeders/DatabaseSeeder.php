<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Content;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'admin',
        ]);

        $teacher1 = User::create([
            'name'      => 'teacher1',
            'email'     => 'teacher1@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'teacher',
        ]);

        $teacher2 = User::create([
            'name'      => 'teacher2',
            'email'     => 'teacher2@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'teacher',
        ]);

        $student1 = User::create([
            'name'      => 'student1',
            'email'     => 'student1@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'student',
        ]);

        $student2 = User::create([
            'name'      => 'student2',
            'email'     => 'student2@gmail.com',
            'password'  => Hash::make('12345678'),
            'role'      => 'student',
        ]);

        $categories = [];

        $categories['web'] = Category::create([
            'name' => 'Web Development',
        ]);

        $categories['uiux'] = Category::create([
            'name' => 'UI/UX Design',
        ]);

        $categories['tanah'] = Category::create([
            'name' => 'Ilmu Tanah',
        ]);

        $categories['datasci'] = Category::create([
            'name' => 'Data Sains',
        ]);

        $categories['math'] = Category::create([
            'name' => 'Matematika',
        ]);

        $categories['hut'] = Category::create([
            'name' => 'Pengantar Kehutanan',
        ]);

        $coursesData = [
            'web' => [
                [
                    'title'       => 'Laravel Dasar untuk Pemula',
                    'description' => 'Belajar dasar-dasar Laravel untuk membuat aplikasi web.',
                    'teacher'     => $teacher1,
                    'status'      => 'active',
                    'slug'        => 'laravel-dasar',
                ],
                [
                    'title'       => 'Fundamental HTML & CSS',
                    'description' => 'Mengenal struktur HTML dan styling dasar dengan CSS.',
                    'teacher'     => $teacher1,
                    'status'      => 'active',
                    'slug'        => 'html-css-fundamental',
                ],
            ],

            'uiux' => [
                [
                    'title'       => 'Desain UI/UX untuk Aplikasi Mobile',
                    'description' => 'Membahas prinsip dasar desain UI/UX yang baik untuk mobile.',
                    'teacher'     => $teacher2,
                    'status'      => 'active',
                    'slug'        => 'uiux-mobile',
                ],
                [
                    'title'       => 'Wireframing & Prototyping',
                    'description' => 'Belajar membuat wireframe dan prototype interaktif.',
                    'teacher'     => $teacher2,
                    'status'      => 'active',
                    'slug'        => 'wireframing-prototyping',
                ],
            ],

            'tanah' => [
                [
                    'title'       => 'Pengantar Ilmu Tanah',
                    'description' => 'Dasar-dasar sifat fisik dan kimia tanah.',
                    'teacher'     => $teacher1,
                    'status'      => 'active',
                    'slug'        => 'pengantar-ilmu-tanah',
                ],
            ],

            'datasci' => [
                [
                    'title'       => 'Statistika Dasar untuk Data Science',
                    'description' => 'Materi dasar statistika yang sering dipakai di data science.',
                    'teacher'     => $teacher1,
                    'status'      => 'inactive',
                    'slug'        => 'statistika-data-science',
                ],
            ],

            'math' => [
                [
                    'title'       => 'Aljabar Linear Dasar',
                    'description' => 'Vektor, matriks, dan operasi dasar aljabar linear.',
                    'teacher'     => $teacher2,
                    'status'      => 'active',
                    'slug'        => 'aljabar-linear',
                ],
            ],

            'hut' => [
                [
                    'title'       => 'Pengantar Kehutanan',
                    'description' => 'Mengenal konsep dasar kehutanan dan ekosistem hutan.',
                    'teacher'     => $teacher2,
                    'status'      => 'active',
                    'slug'        => 'pengantar-kehutanan',
                ],
            ],
        ];

        foreach ($coursesData as $catKey => $courseList) {
            foreach ($courseList as $courseInfo) {

                $course = Course::create([
                    'title'       => $courseInfo['title'],
                    'description' => $courseInfo['description'],
                    'start_date'  => now(),
                    'end_date'    => now()->addWeeks(6),
                    'status'      => $courseInfo['status'],
                    'teacher_id'  => $courseInfo['teacher']->id,
                    'category_id' => $categories[$catKey]->id,
                ]);

                for ($i = 1; $i <= 2; $i++) {
                    Content::create([
                        'course_id'  => $course->id,
                        'title'      => "{$courseInfo['title']} - Lesson {$i}",
                        'body'       => "Materi untuk {$courseInfo['title']} - Lesson {$i}.",
                        'order'      => $i,
                        'video_path' => "videos/{$courseInfo['slug']}_lesson{$i}.mp4",
                    ]);
                }
            }
        }
    }
}
