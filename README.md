<div align="center">

<h1 style="font-weight:800; font-size:42px; margin-bottom:0;">
🎓 Chills Kursus 🎓
</h1>
<p style="font-size:18px; color:#777; margin-top:5px;">
Laravel Online Courses Platform
</p>
</div>

---

<h2>🌟 Overview</h2>

<p><strong>Chills Kursus</strong> adalah platform kursus online berbasis Laravel yang mendukung proses belajar mengajar digital dengan fitur lengkap seperti manajemen kursus, video pembelajaran, progress tracking, dan review bintang ⭐.</p>

---

<h2>🚀 Features</h2>

<ul>
  <li><strong>Role-based System</strong>   — Admin, Teacher, Student, Guest</li>
  <li><strong>Course Management</strong>   — CRUD + Assign teacher + Status</li>
  <li><strong>Lesson Management</strong>   — Text, Video YouTube, Video Lokal</li>
  <li><strong>Enrollment System</strong>   — Enroll, unenroll, progress</li>
  <li><strong>Locked Lessons</strong>      — Harus lengkap untuk lanjut</li>
  <li><strong>Review & Rating</strong>     — Student bisa review masing-masing course</li>
  <li><strong>Public Catalog</strong>      — Searching, filtering</li>
  <li><strong>Dashboards</strong>          — Admin, Teacher, Student</li>
</ul>

---

<h2>🧱 Tech Stack</h2>

<table>
<tr><th>Tech</th><th>Description</th></tr>
<tr><td>Laravel 12</td><td>Backend Framework</td></tr>
<tr><td>Blade</td><td>Template Engine</td></tr>
<tr><td>TailwindCSS</td><td>Main Styling</td></tr>
<tr><td>FontAwesome 6</td><td>Icons</td></tr>
<tr><td>MySQL</td><td>Database</td></tr>
<tr><td>Local Storage</td><td>Support for MP4 videos</td></tr>
<tr><td>YouTube iframe</td><td>Online video support</td></tr>
</table>

---

<h2>📌 Requirements</h2>

<ul>
  <li><strong>PHP:</strong> 8.2.12</li>
  <li><strong>Composer:</strong> 2.8.12</li>
  <li><strong>Laravel:</strong> 12.38.1</li>
  <li><strong>Node.js:</strong> v22.20.0</li>
  <li><strong>NPM:</strong> 10.9.3</li>
  <li><strong>XAMPP:</strong> PHP 8.2.12 + MySQL 10.4.32</li>
  <li><strong>Database:</strong> MySQL 10.4.32</li>
</ul>

---

<h2>⚙ Installation</h2>

<ol>
  <li>
    <strong>Clone Repository</strong>
    <pre><code>
git clone https://github.com/nabilasalsabilaa/PLATFORM-KURSUS.git
cd PLATFORM-KURSUS/platform-kursus
    </code></pre>
  </li>

  <li>
    <strong>Install PHP & Frontend Dependencies</strong>
    <pre><code>
composer install
npm install
npm run build
    </code></pre>
  </li>

  <li>
    <strong>Copy Environment File</strong>
    <p>Duplikat file <code>.env.example</code> menjadi <code>.env</code>:</p>
    <pre><code>cp .env.example .env</code></pre>
  </li>
  
  <li>
    <strong>Sesuaikan konfigurasi database:</strong>
    <pre><code>
DB_CONNECTION=mysql
DB_DATABASE=chillskursus
DB_USERNAME=root
DB_PASSWORD=
    </code></pre>
  </li>

  <li>
    <strong>Generate Application Key</strong>
    <pre><code>
php artisan key:generate
    </code></pre>
  </li>

  <li>
    <strong>Buat Storage Symlink (wajib untuk video lokal)</strong>
    <pre><code>
php artisan storage:link
    </code></pre>
  </li>

  <li>
    <strong>Jalankan Migrasi & Seeder</strong>
    <pre><code>
php artisan migrate:fresh --seed
    </code></pre>
    <p>Seeder akan membuat data awal untuk:</p>
    <ul>
      <li>Users</li>
      <li>Categories</li>
      <li>Courses</li>
      <li>Contents (setiap course mendapatkan lessons + video)</li>
    </ul>
  </li>
<br>

  <li>
    <strong>Jalankan Development Server</strong>
    <pre><code>
php artisan serve
    </code></pre>
    <p>Akses aplikasi: <code>http://localhost:8000</code></p>
  </li>
</ol>

---

<h2>🎥 Video Setup</h2>

<h3>📌 Video Lokal</h3>
<p>Simpan file MP4 ke:</p>

<pre><code>storage/app/public/videos/</code></pre>

<p>Contoh nama file:</p>

<pre><code>laravel-dasar_lesson1.mp4
uiux-dasar_lesson2.mp4</code></pre>

<h3>📌 Video YouTube</h3>
<p>Isi <code>body</code> dengan link YouTube:</p>

<pre><code>https://youtu.be/xxxx
https://www.youtube.com/watch?v=xxxx</code></pre>

Auto embed ✔️

---

<h2>🔐 Default Login Accounts</h2>

<table>
<tr><th>Role</th><th>Email</th><th>Password</th></tr>
<tr><td>Admin</td><td>admin@gmail.com</td><td>12345678</td></tr>
<tr><td>Teacher</td><td>teacher1@gmail.com</td><td>12345678</td></tr>
<tr><td>Teacher</td><td>teacher2@gmail.com</td><td>12345678</td></tr>
<tr><td>Student</td><td>student1@gmail.com</td><td>12345678</td></tr>
<tr><td>Student</td><td>student2@gmail.com</td><td>12345678</td></tr>
</table>

---
<h2 align="center">🧑‍💻 Developed By</h2>

<p align="center">
  <a href="https://github.com/nabilasalsabilaaa" target="_blank">
    <img 
      src="https://github.com/nabilasalsabilaaa.png" 
      width="100" 
      style="
        border-radius: 50%;
        border: 3px solid #a5b4fc;
        padding: 3px;
      "
    />
  </a>
</p>

<p align="center">
  <b>✨ Nabila Salsabila ✨</b><br>
  <sub>Manusia biasa yang tak luput dari salah dan dosa</sub>
</p>

<p align="center">
  <img src="https://img.shields.io/github/contributors/nabilasalsabilaaa/PLATFORM-KURSUS?color=%23a78bfa&style=for-the-badge">
</p>

