<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Career;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class HospitalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Departments (Unit / Poli)
        $departmentsData = [
            [
                'name' => 'Poli Jantung & Pembuluh Darah',
                'slug' => 'poli-jantung',
                'code' => 'KRD',
                'icon' => 'HeartPulse',
                'image' => '/images/hospital/departments/cardiology.jpg',
                'short_description' => 'Diagnostik dan tata laksana penyakit jantung koroner, hipertensi, dan aritmia.',
                'description' => 'Poliklinik Jantung & Pembuluh Darah melayani pemeriksaan kardiovaskular komprehensif didukung EKG, Ekokardiografi, Treadmill Test, dan Holter Monitoring.',
                'facilities' => ['Ekokardiografi 4D', 'Treadmill Stress Test', 'EKG 12-Lead', 'Holter Monitoring'],
                'location' => 'Gedung Utama Lt. 2, Sayap Timur',
                'phone_ext' => 'Ext. 201',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'name' => 'Poli Anak & Tumbuh Kembang',
                'slug' => 'poli-anak',
                'code' => 'ANK',
                'icon' => 'Baby',
                'image' => '/images/hospital/departments/pediatrics.jpg',
                'short_description' => 'Layanan kesehatan bayi, anak, imunisasi lengkap, serta pemantauan tumbuh kembang.',
                'description' => 'Menghadirkan ruang tunggu ramah anak dengan dokter spesialis anak berpengalaman untuk konsultasi kesehatan umum, imunisasi, alergi anak, dan laktasi.',
                'facilities' => ['Klinik Imunisasi', 'Ruang Laktasi Nyaman', 'Nebulizer Anak', 'Klinik Tumbuh Kembang'],
                'location' => 'Gedung Utama Lt. 1, Zona Ceria',
                'phone_ext' => 'Ext. 105',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'name' => 'Poli Bedah & Minimal Invasif',
                'slug' => 'poli-bedah',
                'code' => 'BDH',
                'icon' => 'Stethoscope',
                'image' => '/images/hospital/departments/surgery.jpg',
                'short_description' => 'Konsultasi bedah umum, laparoskopi modern, dan perawatan luka pasca operasi.',
                'description' => 'Ditangani oleh tim dokter spesialis bedah dengan teknologi laparoskopi minimal invasif untuk pemulihan pasien yang lebih cepat dan nyeri minimal.',
                'facilities' => ['Kamar Operasi Modular', 'Laparoskopi HD', 'Klinik Perawatan Luka'],
                'location' => 'Gedung Utama Lt. 3',
                'phone_ext' => 'Ext. 302',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'name' => 'Poli Gigi & Bedah Mulut',
                'slug' => 'poli-gigi',
                'code' => 'GIG',
                'icon' => 'Smile',
                'image' => '/images/hospital/departments/dental.jpg',
                'short_description' => 'Perawatan kesehatan gigi keluarga, konservasi gigi, ortodonti, dan bedah mulut.',
                'description' => 'Dilengkapi dental unit modern, sterilisasi autoklaf berstandar tinggi, dan rontgen panoramik digital untuk kenyamanan perawatan gigi Anda.',
                'facilities' => ['Dental Unit Digital', 'Rontgen Panoramik', 'Sterilisasi Autoklaf'],
                'location' => 'Gedung Poliklinik Lt. 1',
                'phone_ext' => 'Ext. 112',
                'is_featured' => true,
                'order' => 4,
            ],
            [
                'name' => 'Instalasi Gawat Darurat & ICU',
                'slug' => 'igd-icu',
                'code' => 'IGD',
                'icon' => 'Ambulance',
                'image' => '/images/hospital/departments/icu-room.jpg',
                'short_description' => 'Penanganan kegawatdaruratan 24 jam, ruang resusitasi, serta unit perawatan intensif.',
                'description' => 'Siaga 24 jam penuh dengan sistem triase cepat, dokter jaga bersertifikat ACLS/ATLS, dan armada ambulans berfasilitas lengkap.',
                'facilities' => ['Ruang Triase & Resusitasi', 'Ambulans 24 Jam', 'ICU / NICU / PICU'],
                'location' => 'Gedung Utama Lt. 1 (Akses Depan)',
                'phone_ext' => 'Ext. 911',
                'is_featured' => true,
                'order' => 5,
            ],
            [
                'name' => 'Laboratorium & Medical Check Up',
                'slug' => 'laboratorium-mcu',
                'code' => 'LAB',
                'icon' => 'Microscope',
                'image' => '/images/hospital/departments/lab.jpg',
                'short_description' => 'Pemeriksaan patologi klinik 24 jam, mikrobiologi, dan paket Medical Check Up.',
                'description' => 'Menyediakan layanan pemeriksaan laboratorium terotomatisasi dengan akurasi tinggi untuk pasien rawat jalan, rawat inap, maupun peserta MCU.',
                'facilities' => ['Hematologi Otomatis', 'Kimia Klinik', 'Lounge MCU Eksekutif'],
                'location' => 'Gedung Utama Lt. 1, Sayap Barat',
                'phone_ext' => 'Ext. 120',
                'is_featured' => true,
                'order' => 6,
            ],
        ];

        $departments = [];
        foreach ($departmentsData as $dept) {
            $departments[$dept['slug']] = Department::updateOrCreate(['slug' => $dept['slug']], $dept);
        }

        // 2. Seed Doctors & Schedules
        $doctorsData = [
            [
                'department_slug' => 'poli-jantung',
                'name' => 'dr. Hendra Wijaya, Sp.JP(K)',
                'slug' => 'dr-hendra-wijaya-sp-jp',
                'specialization' => 'Spesialis Jantung & Pembuluh Darah',
                'sub_specialization' => 'Konsultan Kardiologi Intervensi',
                'sip_number' => 'SIP.440/1029/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-2.jpg',
                'education' => 'Fakultas Kedokteran Universitas Indonesia (FKUI)',
                'experience_years' => 14,
                'bio' => 'Berpengalaman menangani kasus jantung koroner, gagal jantung, hipertensi resisten, serta tindakan kateterisasi jantung.',
                'consultation_fee' => 'Rp 350.000',
                'is_featured' => true,
                'schedules' => [
                    ['day_of_week' => 'Senin', 'day_order' => 1, 'start_time' => '08:00', 'end_time' => '12:00', 'room' => 'Poli Jantung R.201'],
                    ['day_of_week' => 'Rabu', 'day_order' => 3, 'start_time' => '08:00', 'end_time' => '12:00', 'room' => 'Poli Jantung R.201'],
                    ['day_of_week' => 'Jumat', 'day_order' => 5, 'start_time' => '14:00', 'end_time' => '18:00', 'room' => 'Poli Jantung R.201'],
                ],
            ],
            [
                'department_slug' => 'poli-anak',
                'name' => 'dr. Nadia Larasati, Sp.A, M.Kes',
                'slug' => 'dr-nadia-larasati-sp-a',
                'specialization' => 'Spesialis Anak',
                'sub_specialization' => 'Tumbuh Kembang & Imunisasi',
                'sip_number' => 'SIP.440/2145/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-1.jpg',
                'education' => 'Fakultas Kedokteran Universitas Gadjah Mada (FK-KMK UGM)',
                'experience_years' => 10,
                'bio' => 'Fokus pada kesehatan anak, pemantauan tumbuh kembang balita, konsultasi MPASI, serta imunisasi lengkap.',
                'consultation_fee' => 'Rp 275.000',
                'is_featured' => true,
                'schedules' => [
                    ['day_of_week' => 'Senin', 'day_order' => 1, 'start_time' => '09:00', 'end_time' => '13:00', 'room' => 'Poli Anak R.102'],
                    ['day_of_week' => 'Selasa', 'day_order' => 2, 'start_time' => '09:00', 'end_time' => '13:00', 'room' => 'Poli Anak R.102'],
                    ['day_of_week' => 'Sabtu', 'day_order' => 6, 'start_time' => '08:00', 'end_time' => '12:00', 'room' => 'Poli Anak R.102'],
                ],
            ],
            [
                'department_slug' => 'poli-bedah',
                'name' => 'dr. Bagus Prakoso, Sp.B, FINACS',
                'slug' => 'dr-bagus-prakoso-sp-b',
                'specialization' => 'Spesialis Bedah Umum',
                'sub_specialization' => 'Bedah Minimal Invasif (Laparoskopi)',
                'sip_number' => 'SIP.440/3088/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-4.jpg',
                'education' => 'Fakultas Kedokteran Universitas Airlangga (UNAIR)',
                'experience_years' => 12,
                'bio' => 'Ahli dalam prosedur bedah digestif, hernia, apendisitis, serta bedah laparoskopi dengan sayatan minimal.',
                'consultation_fee' => 'Rp 300.000',
                'is_featured' => true,
                'schedules' => [
                    ['day_of_week' => 'Selasa', 'day_order' => 2, 'start_time' => '13:00', 'end_time' => '17:00', 'room' => 'Poli Bedah R.301'],
                    ['day_of_week' => 'Kamis', 'day_order' => 4, 'start_time' => '13:00', 'end_time' => '17:00', 'room' => 'Poli Bedah R.301'],
                    ['day_of_week' => 'Sabtu', 'day_order' => 6, 'start_time' => '09:00', 'end_time' => '12:00', 'room' => 'Poli Bedah R.301'],
                ],
            ],
            [
                'department_slug' => 'poli-gigi',
                'name' => 'drg. Clarissa Putri, Sp.KG',
                'slug' => 'drg-clarissa-putri-sp-kg',
                'specialization' => 'Spesialis Konservasi Gigi',
                'sub_specialization' => 'Estetika & Perawatan Saluran Akar',
                'sip_number' => 'SIP.440/4412/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-3.jpg',
                'education' => 'Fakultas Kedokteran Gigi Universitas Padjadjaran (UNPAD)',
                'experience_years' => 8,
                'bio' => 'Menangani perawatan saluran akar (endodontik), tambalan estetik, veneer, serta restorasi gigi menyeluruh.',
                'consultation_fee' => 'Rp 250.000',
                'is_featured' => true,
                'schedules' => [
                    ['day_of_week' => 'Senin', 'day_order' => 1, 'start_time' => '14:00', 'end_time' => '19:00', 'room' => 'Poli Gigi R.110'],
                    ['day_of_week' => 'Rabu', 'day_order' => 3, 'start_time' => '14:00', 'end_time' => '19:00', 'room' => 'Poli Gigi R.110'],
                    ['day_of_week' => 'Jumat', 'day_order' => 5, 'start_time' => '09:00', 'end_time' => '14:00', 'room' => 'Poli Gigi R.110'],
                ],
            ],
            [
                'department_slug' => 'igd-icu',
                'name' => 'dr. Reza Mahendra, Sp.An-TI',
                'slug' => 'dr-reza-mahendra-sp-an',
                'specialization' => 'Spesialis Anestesi & Terapi Intensif',
                'sub_specialization' => 'Kepala Unit ICU & Gawat Darurat',
                'sip_number' => 'SIP.440/5102/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-6.jpg',
                'education' => 'Fakultas Kedokteran Universitas Diponegoro (UNDIP)',
                'experience_years' => 11,
                'bio' => 'Memimpin tim perawatan intensif ICU/NICU serta manajemen nyeri akut dan kronis berbasis teknologi terkini.',
                'consultation_fee' => 'Rp 300.000',
                'is_featured' => false,
                'schedules' => [
                    ['day_of_week' => 'Selasa', 'day_order' => 2, 'start_time' => '08:00', 'end_time' => '14:00', 'room' => 'Unit ICU & Konsultasi'],
                    ['day_of_week' => 'Kamis', 'day_order' => 4, 'start_time' => '08:00', 'end_time' => '14:00', 'room' => 'Unit ICU & Konsultasi'],
                ],
            ],
            [
                'department_slug' => 'laboratorium-mcu',
                'name' => 'dr. Amelia Santoso, Sp.PK',
                'slug' => 'dr-amelia-santoso-sp-pk',
                'specialization' => 'Spesialis Patologi Klinik',
                'sub_specialization' => 'Koordinator Medical Check Up',
                'sip_number' => 'SIP.440/6230/DINKES/2024',
                'photo' => '/images/hospital/doctors/doctor-5.jpg',
                'education' => 'Fakultas Kedokteran Universitas Indonesia (FKUI)',
                'experience_years' => 9,
                'bio' => 'Bertanggung jawab atas akurasi pemeriksaan laboratorium klinis dan konsultasi hasil Medical Check Up komprehensif.',
                'consultation_fee' => 'Rp 250.000',
                'is_featured' => false,
                'schedules' => [
                    ['day_of_week' => 'Senin', 'day_order' => 1, 'start_time' => '07:30', 'end_time' => '12:00', 'room' => 'Lounge MCU Lt.1'],
                    ['day_of_week' => 'Kamis', 'day_order' => 4, 'start_time' => '07:30', 'end_time' => '12:00', 'room' => 'Lounge MCU Lt.1'],
                ],
            ],
        ];

        $doctors = [];
        foreach ($doctorsData as $doc) {
            $dept = $departments[$doc['department_slug']];
            $schedules = $doc['schedules'];
            unset($doc['department_slug'], $doc['schedules']);

            $doctor = Doctor::updateOrCreate(
                ['slug' => $doc['slug']],
                array_merge($doc, ['department_id' => $dept->id, 'is_active' => true])
            );
            $doctors[$doc['slug']] = $doctor;

            // Replace schedules cleanly
            $doctor->schedules()->delete();
            foreach ($schedules as $sch) {
                DoctorSchedule::create(array_merge($sch, ['doctor_id' => $doctor->id, 'quota' => 20, 'is_active' => true]));
            }
        }

        // 3. Seed Careers
        $careersData = [
            [
                'title' => 'Dokter Umum IGD (24 Jam Shift)',
                'slug' => 'dokter-umum-igd',
                'category' => 'Medis',
                'employment_type' => 'Full-Time',
                'location' => 'RSU Medika Nusantara — Jakarta Selatan',
                'department_name' => 'Instalasi Gawat Darurat',
                'description' => 'Membuka kesempatan bagi Dokter Umum yang berdedikasi tinggi untuk bergabung bersama tim Instalasi Gawat Darurat 24 jam kami.',
                'requirements' => [
                    'Pendidikan Profesi Dokter dengan STR aktif',
                    'Memiliki sertifikat ACLS & ATLS yang masih berlaku',
                    'Mampu bekerja dalam sistem shift dan tim multidisiplin',
                    'Komunikatif, empatik, dan sigap dalam kondisi darurat',
                ],
                'benefits' => [
                    'Gaji kompetitif & jasa medis transparan',
                    'BPJS Kesehatan & Ketenagakerjaan',
                    'Fasilitas pelatihan & seminar medis berkala',
                ],
                'deadline' => now()->addMonths(2)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'title' => 'Perawat Pelaksana ICU / NICU',
                'slug' => 'perawat-pelaksana-icu-nicu',
                'category' => 'Keperawatan',
                'employment_type' => 'Full-Time',
                'location' => 'RSU Medika Nusantara — Jakarta Selatan',
                'department_name' => 'Unit Perawatan Intensif',
                'description' => 'Dibutuhkan perawat profesional untuk memberikan asuhan keperawatan intensif berstandar tinggi di unit ICU & NICU.',
                'requirements' => [
                    'Minimal D3 / S1 Keperawatan (Ners) dengan STR aktif',
                    'Memiliki sertifikat pelatihan ICU Dasar / NICU / BTCLS',
                    'Pengalaman minimal 1 tahun di ruang intensif menjadi nilai tambah',
                ],
                'benefits' => [
                    'Tunjangan khusus unit intensif',
                    'Jenjang karir keperawatan yang jelas',
                    'Asuransi kesehatan keluarga',
                ],
                'deadline' => now()->addMonths(2)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'title' => 'Apoteker Klinis & Farmasi',
                'slug' => 'apoteker-klinis-farmasi',
                'category' => 'Penunjang Medis',
                'employment_type' => 'Full-Time',
                'location' => 'RSU Medika Nusantara — Jakarta Selatan',
                'department_name' => 'Instalasi Farmasi',
                'description' => 'Mengelola pelayanan kefarmasian klinis, verifikasi resep elektronik, serta edukasi penggunaan obat kepada pasien rawat jalan dan rawat inap.',
                'requirements' => [
                    'Profesi Apoteker dengan STRA aktif',
                    'Memahami sistem manajemen farmasi rumah sakit (SIMRS)',
                    'Teliti, jujur, dan berorientasi pada keselamatan pasien',
                ],
                'benefits' => [
                    'Kompensasi menarik & tunjangan profesi',
                    'Lingkungan kerja modern & suportif',
                ],
                'deadline' => now()->addMonths(1)->format('Y-m-d'),
                'is_active' => true,
            ],
            [
                'title' => 'IT Full-Stack & SIMRS Developer',
                'slug' => 'it-full-stack-simrs-developer',
                'category' => 'Non-Medis & IT',
                'employment_type' => 'Full-Time',
                'location' => 'RSU Medika Nusantara — Jakarta Selatan',
                'department_name' => 'Unit Teknologi Informasi (SIMRS)',
                'description' => 'Mengembangkan dan memelihara integrasi sistem informasi rumah sakit, portal pasien, bridging BPJS / SatuSehat Kemenkes, dan modul telemedicine.',
                'requirements' => [
                    'S1 Teknik Informatika / Sistem Informasi',
                    'Menguasai PHP (Laravel), Vue.js / JavaScript, dan MySQL',
                    'Memahami REST API dan integrasi HL7/FHIR menjadi nilai tambah',
                ],
                'benefits' => [
                    'Gaji kompetitif & fleksibilitas pengembangan teknologi',
                    'Tunjangan kesehatan & makan siang',
                ],
                'deadline' => now()->addMonths(2)->format('Y-m-d'),
                'is_active' => true,
            ],
        ];

        foreach ($careersData as $car) {
            Career::updateOrCreate(['slug' => $car['slug']], $car);
        }

        // 4. Seed Sample Appointments
        $doc1 = $doctors['dr-hendra-wijaya-sp-jp'];
        $doc2 = $doctors['dr-nadia-larasati-sp-a'];

        Appointment::updateOrCreate(
            ['booking_code' => 'APT-20261114-0001'],
            [
                'department_id' => $doc1->department_id,
                'doctor_id' => $doc1->id,
                'appointment_date' => now()->addDays(2)->format('Y-m-d'),
                'appointment_time' => '08:00 - 12:00',
                'patient_name' => 'Bapak Suryanto',
                'patient_phone' => '081298765432',
                'patient_email' => 'suryanto@example.com',
                'payment_type' => 'BPJS Kesehatan',
                'complaint' => 'Kontrol rutin tekanan darah dan pemeriksaan EKG berkala.',
                'status' => 'confirmed',
            ]
        );

        Appointment::updateOrCreate(
            ['booking_code' => 'APT-20261114-0002'],
            [
                'department_id' => $doc2->department_id,
                'doctor_id' => $doc2->id,
                'appointment_date' => now()->addDays(3)->format('Y-m-d'),
                'appointment_time' => '09:00 - 13:00',
                'patient_name' => 'Ananda Kirana (Ibu Sari)',
                'patient_phone' => '081345678901',
                'patient_email' => 'sari.ibu@example.com',
                'payment_type' => 'Umum',
                'complaint' => 'Konsultasi imunisasi lanjutan dan pemantauan berat badan anak.',
                'status' => 'pending',
            ]
        );
    }
}
