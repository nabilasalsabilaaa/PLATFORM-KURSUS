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
            'name'      => 'Web Development',
        ]);
        $categories['uiux'] = Category::create([
            'name'      => 'UI/UX Design',
        ]);
        $categories['tanah'] = Category::create([
            'name'      => 'Ilmu Tanah',
        ]);
        $categories['datasci'] = Category::create([
            'name'      => 'Data Sains',
        ]);
        $categories['math'] = Category::create([
            'name'      => 'Matematika',
        ]);
        $categories['hut'] = Category::create([
            'name'      => 'Pengantar Kehutanan',
        ]);

        $course1 = Course::create([
            'title'       => 'Laravel Dasar untuk Pemula',
            'description' => 'Belajar dasar-dasar Laravel untuk membuat web',
            'start_date'  => now(),
            'end_date'    => now()->addMonth(),
            'status'      => 'active',
            'teacher_id'  => $teacher1->id,
            'category_id' => $categories['web']->id,
        ]);
        $course2 = Course::create([
            'title'       => 'Desain UI/UX untuk Aplikasi Mobile',
            'description' => 'Membahas prinsip dasar desain UI/UX yang baik.',
            'start_date'  => now(),
            'end_date'    => now()->addWeeks(6),
            'status'      => 'active',
            'teacher_id'  => $teacher2->id,
            'category_id' => $categories['uiux']->id,
        ]);
        $course3 = Course::create([
            'title'       => 'Statistika Dasar untuk Data Science',
            'description' => 'Materi dasar statistika yang sering dipakai di data science.',
            'start_date'  => now(),
            'end_date'    => now()->addWeeks(8),
            'status'      => 'inactive',
            'teacher_id'  => $teacher1->id,
            'category_id' => $categories['datasci']->id,
        ]);

        Content::create([
            'course_id' => $course1->id,
            'title'     => 'Pengenalan Laravel',
            'body'      => 'Apa itu Laravel, kenapa digunakan, dan overview ekosistemnya.',
            'order'     => 1,
        ]);

        Content::create([
            'course_id' => $course1->id,
            'title'     => 'Instalasi Laravel',
            'body'      => 'Cara install Laravel menggunakan Composer, setting .env, dll.',
            'order'     => 2,
        ]);

        Content::create([
            'course_id' => $course1->id,
            'title'     => 'Routing Dasar',
            'body'      => 'Belajar membuat route sederhana dan menghubungkannya ke controller.',
            'order'     => 3,
        ]);

        Content::create([
            'course_id' => $course2->id,
            'title'     => 'Dasar UI/UX',
            'body'      => 'Konsep dasar user interface dan user experience.',
            'order'     => 1,
        ]);

        Content::create([
            'course_id' => $course2->id,
            'title'     => 'Wireframing',
            'body'      => 'Membuat wireframe sederhana sebagai kerangka desain.',
            'order'     => 2,
        ]);

        Content::create([
            'course_id' => $course3->id,
            'title'     => 'Apa itu Data Science?',
            'body'      => 'Pengantar konsep data science dan perannya.',
            'order'     => 1,
        ]);

        Content::create([
            'course_id' => $course3->id,
            'title'     => 'Statistika Deskriptif',
            'body'      => 'Rata-rata, median, modus, dan ukuran pemusatan lainnya.',
            'order'     => 2,
        ]);
    }
}
