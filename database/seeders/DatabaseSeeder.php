<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Roles and Permissions
        $this->call(RoleAndPermissionSeeder::class);

        // 2. Seed Default Users and Assign Roles
        $admin = User::updateOrCreate(
            ['email' => 'admin@rsmedika.id'],
            [
                'name' => 'Super Admin RS',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('admin');

        $editor = User::updateOrCreate(
            ['email' => 'editor@rsmedika.id'],
            [
                'name' => 'Tim Humas & Konten RS',
                'password' => bcrypt('password'),
            ]
        );
        $editor->assignRole('editor');

        // 3. Seed Settings, Pages/Sections & Hospital Data
        $this->call([
            SettingSeeder::class,
            PageAndSectionSeeder::class,
            HospitalSeeder::class,
        ]);

        // 4. Seed Categories & Health/Hospital Articles
        $tips = Category::updateOrCreate(
            ['slug' => 'tips-kesehatan'],
            ['name' => 'Tips Kesehatan']
        );

        $news = Category::updateOrCreate(
            ['slug' => 'berita-rumah-sakit'],
            ['name' => 'Berita Rumah Sakit']
        );

        $announcement = Category::updateOrCreate(
            ['slug' => 'pengumuman'],
            ['name' => 'Pengumuman']
        );

        Post::updateOrCreate(
            ['slug' => 'pentingnya-medical-check-up-rutin-setiap-tahun'],
            [
                'category_id' => $tips->id,
                'title' => 'Pentingnya Medical Check Up Rutin Setiap Tahun untuk Deteksi Dini',
                'content' => "Medical Check Up (MCU) bukan sekadar pemeriksaan saat tubuh terasa sakit, melainkan langkah preventif paling efektif untuk mendeteksi risiko penyakit metabolik seperti diabetes, hipertensi, hingga gangguan jantung sejak dini.\n\nMelalui pemeriksaan darah lengkap, profil lipid, fungsi hati dan ginjal, serta rekam jantung (EKG), dokter dapat memberikan panduan gaya hidup dan penanganan medis sebelum gejala berkembang menjadi komplikasi serius.\n\nRSU Medika Nusantara menyediakan berbagai paket MCU yang dirancang khusus untuk individu, lansia, hingga karyawan korporasi dengan hasil cepat dan konsultasi langsung bersama dokter spesialis.",
                'image' => '/images/hospital/articles/health-checkup.jpg',
                'status' => 'published',
                'is_featured' => true,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'mengenali-gejala-awal-penyakit-jantung-dan-pencegahannya'],
            [
                'category_id' => $tips->id,
                'title' => 'Mengenali Gejala Awal Penyakit Jantung dan Langkah Pencegahannya',
                'content' => "Penyakit kardiovaskular masih menjadi salah satu penyebab utama gangguan kesehatan di usia produktif. Gejala awal sering kali terasa samar, seperti mudah lelah saat beraktivitas ringan, nyeri dada menjalar ke lengan kiri, atau sesak napas saat berbaring.\n\nMenjaga pola makan rendah garam dan lemak jenuh, berolahraga teratur 150 menit per minggu, mengelola stres, serta berhenti merokok merupakan kunci utama menjaga kesehatan pembuluh darah.\n\nApabila Anda memiliki riwayat keluarga dengan penyakit jantung atau hipertensi, segera konsultasikan dengan dokter spesialis jantung di Poli Jantung RSU Medika Nusantara.",
                'image' => '/images/hospital/articles/heart-care.jpg',
                'status' => 'published',
                'is_featured' => true,
            ]
        );

        Post::updateOrCreate(
            ['slug' => 'layanan-vaksinasi-anak-dan-dewasa-kini-tersedia-online'],
            [
                'category_id' => $news->id,
                'title' => 'Layanan Vaksinasi Anak & Dewasa Kini Dapat Dijadwalkan Secara Online',
                'content' => "Dalam rangka meningkatkan kemudahan akses layanan kesehatan preventif, RSU Medika Nusantara kini menghadirkan fitur reservasi janji temu online untuk layanan imunisasi anak serta vaksinasi dewasa (Influenza, Pneumonia, HPV, dan Meningitis).\n\nPasien cukup memilih Poli Anak atau Lounge MCU pada menu Janji Temu, menentukan tanggal serta jam kunjungan, dan mendapatkan kode booking instan yang dapat dikonfirmasi melalui WhatsApp resmi rumah sakit.",
                'image' => '/images/hospital/articles/vaccination.jpg',
                'status' => 'published',
                'is_featured' => false,
            ]
        );
    }
}
