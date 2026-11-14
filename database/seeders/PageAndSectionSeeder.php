<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Database\Seeder;

class PageAndSectionSeeder extends Seeder
{
    public function run(): void
    {
        $homePage = Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'title' => 'Beranda RSU Medika Nusantara',
                'meta_description' => 'RSU Medika Nusantara — Rumah sakit modern dengan layanan IGD 24 jam, poliklinik spesialis lengkap, dan reservasi janji temu dokter online.',
                'is_active' => true,
            ]
        );

        $sections = [
            [
                'key' => 'hero_slider',
                'title' => 'Banner Slider Utama',
                'order' => 1,
                'content' => [
                    'slides' => [
                        [
                            'badge' => 'Terakreditasi Paripurna KARS',
                            'headline' => 'Kesehatan Anda adalah Prioritas Utama Kami',
                            'subheadline' => 'Didukung oleh lebih dari 45 dokter spesialis, fasilitas diagnostik terkini, dan layanan gawat darurat 24 jam yang responsif.',
                            'image' => '/images/hospital/hero/hospital-exterior.jpg',
                            'cta_text' => 'Buat Janji Temu',
                            'cta_url' => '/janji-temu',
                            'secondary_text' => 'Cari Jadwal Dokter',
                            'secondary_url' => '/dokter',
                        ],
                        [
                            'badge' => 'Pusat Layanan Terpadu',
                            'headline' => 'Teknologi Medis Modern & Penuh Empati',
                            'subheadline' => 'Dari konsultasi poliklinik hingga tindakan bedah minimal invasif, kami mengutamakan keselamatan dan kenyamanan pasien.',
                            'image' => '/images/hospital/hero/medical-team.jpg',
                            'cta_text' => 'Lihat Unit & Poli',
                            'cta_url' => '/dokter',
                            'secondary_text' => 'Hubungi IGD 24 Jam',
                            'secondary_url' => '#igd-darurat',
                        ],
                        [
                            'badge' => 'Medical Check Up & Preventif',
                            'headline' => 'Deteksi Dini untuk Hidup Lebih Berkualitas',
                            'subheadline' => 'Paket pemeriksaan kesehatan menyeluruh dengan hasil cepat, akurat, dan konsultasi langsung bersama dokter ahli.',
                            'image' => '/images/hospital/hero/hospital-corridor.jpg',
                            'cta_text' => 'Jadwalkan MCU',
                            'cta_url' => '/janji-temu',
                            'secondary_text' => 'Baca Tips Kesehatan',
                            'secondary_url' => '/artikel',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'management_welcome',
                'title' => 'Sambutan Manajemen',
                'order' => 2,
                'content' => [
                    'badge' => 'Sambutan Direktur Utama',
                    'title' => 'Melayani dengan Hati, Berinovasi untuk Kesembuhan',
                    'director_name' => 'dr. Rahmat Hidayat, MARS',
                    'director_role' => 'Direktur Utama RSU Medika Nusantara',
                    'image' => '/images/hospital/director.jpg',
                    'quote' => 'Setiap pasien berhak mendapatkan pelayanan medis berstandar tinggi yang aman, transparan, dan manusiawi.',
                    'description' => 'Selamat datang di RSU Medika Nusantara. Sejak berdiri, kami berkomitmen menghadirkan ekosistem layanan kesehatan terpadu yang memadukan keahlian klinis dokter spesialis, peralatan medis generasi terbaru, serta sistem pendaftaran digital yang memudahkan pasien dan keluarga.',
                    'stats' => [
                        ['value' => '45+', 'label' => 'Dokter Spesialis'],
                        ['value' => '24/7', 'label' => 'Layanan IGD & Farmasi'],
                        ['value' => '180+', 'label' => 'Kapasitas Tempat Tidur'],
                        ['value' => '98%', 'label' => 'Kepuasan Pasien'],
                    ],
                ],
            ],
            [
                'key' => 'featured_services',
                'title' => 'Layanan Unggulan',
                'order' => 3,
                'content' => [
                    'badge' => 'Center of Excellence',
                    'title' => 'Layanan Unggulan Kami',
                    'subtitle' => 'Fasilitas klinis komprehensif dengan standar keselamatan pasien internasional.',
                    'items' => [
                        [
                            'icon' => 'Ambulance',
                            'title' => 'IGD 24 Jam & Trauma Center',
                            'description' => 'Penanganan kegawatdaruratan medis dan trauma secara cepat dengan tim dokter jaga & ambulans siap siaga 24 jam.',
                        ],
                        [
                            'icon' => 'HeartPulse',
                            'title' => 'Pusat Jantung & Pembuluh Darah',
                            'description' => 'Layanan kardiologi terpadu mulai dari EKG, Ekokardiografi, Treadmill Test, hingga kateterisasi jantung.',
                        ],
                        [
                            'icon' => 'Activity',
                            'title' => 'ICU, NICU & PICU Modern',
                            'description' => 'Ruang perawatan intensif dewasa, anak, dan bayi baru lahir dengan monitoring sentral dan ventilator mutakhir.',
                        ],
                        [
                            'icon' => 'Microscope',
                            'title' => 'Laboratorium & Radiologi Digital',
                            'description' => 'Pemeriksaan darah lengkap, CT-Scan 128 Slice, USG 4D, dan Rontgen digital dengan hasil terintegrasi.',
                        ],
                        [
                            'icon' => 'ShieldCheck',
                            'title' => 'Medical Check Up (MCU)',
                            'description' => 'Paket deteksi dini kesehatan individu maupun korporasi yang nyaman, privat, dan selesai dalam satu hari.',
                        ],
                        [
                            'icon' => 'Pill',
                            'title' => 'Instalasi Farmasi 24 Jam',
                            'description' => 'Penyediaan obat-obatan resmi terjamin keasliannya serta layanan konseling apoteker klinis.',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'departments_preview',
                'title' => 'Unit & Poliklinik Spesialis',
                'order' => 4,
                'content' => [
                    'badge' => 'Poliklinik & Unit Medis',
                    'title' => 'Unit Layanan & Poliklinik',
                    'subtitle' => 'Pilih unit spesialis sesuai kebutuhan kesehatan Anda dan keluarga.',
                ],
            ],
            [
                'key' => 'doctors_preview',
                'title' => 'Tim Dokter Spesialis',
                'order' => 5,
                'content' => [
                    'badge' => 'Tenaga Medis Profesional',
                    'title' => 'Dokter Spesialis Kami',
                    'subtitle' => 'Konsultasikan keluhan Anda bersama dokter ahli yang berpengalaman dan ramah.',
                ],
            ],
            [
                'key' => 'testimonials',
                'title' => 'Testimoni Pasien',
                'order' => 6,
                'content' => [
                    'badge' => 'Cerita Pasien & Keluarga',
                    'title' => 'Kepercayaan Pasien Adalah Kebanggaan Kami',
                    'items' => [
                        [
                            'name' => 'Hj. Ratna Kusuma',
                            'role' => 'Pasien Poli Jantung',
                            'comment' => 'Pelayanan dari pendaftaran online sampai konsultasi dengan dr. Hendra sangat cepat dan rapi. Perawatnya ramah dan menjelaskan kondisi dengan sangat menenangkan.',
                        ],
                        [
                            'name' => 'Andi Prasetyo',
                            'role' => 'Orang Tua Pasien Poli Anak',
                            'comment' => 'Ruang tunggu poli anak sangat bersih dan nyaman untuk balita. Booking jadwal lewat website langsung dapat kode antrean tanpa perlu menunggu lama.',
                        ],
                        [
                            'name' => 'Dewi Lestari',
                            'role' => 'Peserta Medical Check Up Korporat',
                            'comment' => 'Proses MCU tahunan perusahaan kami berjalan sangat efisien. Hasil lab keluar tepat waktu dan langsung dijelaskan oleh dokter.',
                        ],
                    ],
                ],
            ],
            [
                'key' => 'cta_banner',
                'title' => 'Call to Action Cepat',
                'order' => 7,
                'content' => [
                    'title' => 'Butuh Konsultasi Dokter atau Bantuan Darurat?',
                    'subtitle' => 'Jadwalkan kunjungan poliklinik Anda secara online dalam hitungan detik atau hubungi IGD 24 jam kami.',
                    'primary_text' => 'Buat Janji Temu Online',
                    'primary_url' => '/janji-temu',
                    'secondary_text' => 'Hubungi WhatsApp RS',
                ],
            ],
        ];

        foreach ($sections as $sec) {
            Section::updateOrCreate(
                [
                    'page_id' => $homePage->id,
                    'key' => $sec['key'],
                ],
                [
                    'title' => $sec['title'],
                    'order' => $sec['order'],
                    'content' => $sec['content'],
                    'is_active' => true,
                ]
            );
        }
    }
}
