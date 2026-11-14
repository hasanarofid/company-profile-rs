---
title: "MANUAL BOOK & PANDUAN PENGGUNAAN"
subtitle: "Website Company Profile Rumah Sakit & Sistem Reservasi Janji Temu"
author: "Disiapkan untuk: aannisafirlyy@gmail.com | Hasan Arofid (hasanarofid.site)"
date: "November 2026"
---

# Informasi Dokumen

| Keterangan | Detail |
| :--- | :--- |
| **Nama Sistem** | Website Company Profile Rumah Sakit (RSU Medika Nusantara) |
| **URL Demo** | https://demo.hasanarofid.site/ |
| **Ditujukan Kepada** | Calon Klien (`aannisafirlyy@gmail.com`) |
| **Disusun Oleh / Developer** | Hasan Arofid — https://hasanarofid.site |
| **Kontak WhatsApp** | https://wa.me/628814959247 (+62 881-4959-247) |
| **Akses Panel Admin** | `/login` atau `/admin/dashboard` |
| **Akun Demo Super Admin** | Email: `admin@rsmedika.id` \| Password: `password` |

> **Catatan Keamanan:** Untuk penggunaan produksi rumah sakit, harap segera mengganti email dan password default setelah proses serah terima sistem.

---

# BAB 1. PENDAHULUAN & GAMBARAN UMUM

Website Company Profile Rumah Sakit ini dirancang dengan pendekatan modern, responsif (nyaman diakses melalui desktop, tablet, maupun smartphone), cepat, dan ramah mesin pencari (SEO-friendly). Sistem terbagi menjadi dua bagian utama:

1. **Halaman Publik (Frontend Pasien & Pengunjung):** Menampilkan profil rumah sakit, layanan unggulan, unit/poliklinik, direktori & jadwal dokter, formulir reservasi janji temu online, artikel kesehatan, serta portal karir.
2. **Panel Super Admin (CMS & Customizer):** Memungkinkan tim IT atau manajemen konten rumah sakit mengelola seluruh data pasien (janji temu), pelamar kerja, jadwal dokter, artikel, tata letak halaman, hingga skema warna tema tanpa harus mengubah kode program.

---

# BAB 2. PANDUAN HALAMAN PUBLIK (PENGUNJUNG & PASIEN)

## 2.1 Halaman Utama (Homepage)

Halaman utama (`/`) merupakan wajah digital rumah sakit yang menyajikan informasi kunci secara terstruktur:

1. **Bar Darurat & Navigasi Atas:** Menampilkan nomor hotline IGD 24 Jam, jam operasional, menu navigasi, serta tombol cepat **Buat Janji Temu**.
2. **Banner Slider Interaktif:** Menampilkan informasi layanan unggulan atau program promo MCU dengan tombol navigasi panah dan indikator slide.
3. **Sambutan Manajemen:** Menampilkan foto dan sambutan Direktur Utama beserta statistik kapasitas rumah sakit.
4. **Layanan Unggulan (Center of Excellence):** Menampilkan 6 fasilitas inti (IGD 24 Jam, Pusat Jantung, ICU/NICU, Lab & Radiologi, Medical Check Up, Farmasi 24 Jam).
5. **Unit Layanan & Poliklinik:** Menampilkan daftar poli beserta jumlah dokter dan tombol cepat **Daftar Poli**.
6. **Tim Dokter Spesialis & Testimoni Pasien:** Menampilkan dokter unggulan, jadwal ringkas, dan ulasan pasien.
7. **Artikel Kesehatan Terbaru & Tombol WhatsApp Mengambang:** Memudahkan pasien membaca edukasi medis atau menghubungi Customer Service secara langsung.

![Tampilan Halaman Utama (Homepage) RSU Medika Nusantara](images/Pasted%20image.png)

---

## 2.2 Direktori & Jadwal Dokter (`/dokter`)

Pasien dapat mencari dokter spesialis yang sesuai dengan kebutuhan melalui menu **Dokter & Poli**:

1. Gunakan **kolom pencarian** untuk mengetik nama dokter atau spesialisasi.
2. Pilih **Unit / Poliklinik** pada dropdown filter untuk menyaring dokter berdasarkan poli tertentu.
3. Klik tombol **Filter Hari** (Senin – Minggu) untuk melihat dokter yang praktik pada hari yang diinginkan.
4. Klik **Detail** untuk melihat profil lengkap dokter (pendidikan, pengalaman klinis, nomor SIP, dan tabel jadwal mingguan), atau klik **Buat Janji Temu** untuk langsung memesan jadwal dengan dokter tersebut.

![Direktori & Jadwal Praktik Dokter](images/Pasted%20image%20(2).png)

---

## 2.3 Fitur Appointment / Janji Temu Dokter (`/janji-temu`)

Sistem reservasi janji temu terintegrasi memudahkan pasien mendaftar poliklinik tanpa harus antre lama di loket:

1. **Pilih Poliklinik & Dokter:** Saat poliklinik dipilih, daftar dokter otomatis tersaring sesuai poli tersebut.
2. **Pilih Tanggal & Sesi Jam Praktik:** Sistem menampilkan jadwal praktik dokter yang tersedia.
3. **Isi Data Pasien:** Masukkan nama lengkap, nomor HP/WhatsApp aktif, email (opsional), metode penjamin (**Umum**, **BPJS Kesehatan**, atau **Asuransi Swasta**), serta keluhan singkat.
4. **Konfirmasi Instan:** Setelah menekan tombol **Kirim Reservasi Janji Temu**, sistem menghasilkan **Kode Booking** (contoh: `APT-20261114-XXXX`) dan menyediakan tombol **Konfirmasi via WhatsApp RS** yang otomatis mengisi detail reservasi ke chat WhatsApp pendaftaran rumah sakit.

![Formulir Reservasi Janji Temu Dokter Online](images/Pasted%20image%20(3).png)

---

## 2.4 Artikel Kesehatan & Berita RS (`/artikel`)

Halaman ini berisi edukasi kesehatan dari tim medis, berita kegiatan rumah sakit, dan pengumuman layanan:

- Pengunjung dapat memfilter artikel berdasarkan kategori (**Tips Kesehatan**, **Berita Rumah Sakit**, **Pengumuman**) atau menggunakan kolom pencarian.
- Setiap halaman detail artikel dilengkapi tombol CTA cepat menuju halaman **Buat Janji Temu**.

![Halaman Artikel Kesehatan & Berita Rumah Sakit](images/Pasted%20image%20(4).png)

---

## 2.5 Portal Karir & Rekrutmen (`/karir`)

Rumah sakit dapat membuka lowongan kerja bagi tenaga medis maupun non-medis:

1. Pelamar memilih kategori bidang (**Medis**, **Keperawatan**, **Penunjang Medis**, atau **Non-Medis & IT**).
2. Klik **Lihat & Lamar** untuk membaca deskripsi pekerjaan, persyaratan, dan benefit.
3. Isi formulir lamaran di sisi kanan halaman dan unggah berkas **CV / Portofolio (PDF/DOCX, maksimal 5 MB)**, lalu klik **Kirim Berkas Lamaran**.

![Halaman Portal Karir & Rekrutmen Rumah Sakit](images/Pasted%20image%20(5).png)

---

# BAB 3. PANDUAN PANEL SUPER ADMIN (CMS)

Seluruh pengelolaan konten, data pasien, pelamar, dan tampilan dilakukan melalui Panel Admin.

## 3.1 Login & Dashboard Ringkasan

1. Buka alamat `/login` (atau klik **Portal Admin** pada bagian atas kanan/footer website).
2. Masukkan email dan password Super Admin.

![Halaman Login Portal Admin Rumah Sakit](images/Pasted%20image%20(6).png)

3. Halaman **Dashboard** menampilkan ringkasan statistik: total janji temu & status pending, jumlah dokter & poli aktif, jumlah pelamar kerja, artikel terbit, serta daftar janji temu dan pelamar terbaru.

![Dashboard Manajemen Rumah Sakit](images/Pasted%20image%20(7).png)

---

## 3.2 Mengelola Data Janji Temu Pasien (`/admin/appointments`)

1. Buka menu **Janji Temu Pasien** di sidebar kiri.
2. Gunakan kolom pencarian atau filter status (**Pending**, **Confirmed**, **Completed**, **Cancelled**).
3. Untuk memperbarui status reservasi pasien, cukup ubah pilihan pada kolom **Status** (tersimpan otomatis).
4. Klik ikon **WhatsApp** di kolom Aksi untuk langsung menghubungi nomor WhatsApp pasien terkait konfirmasi jadwal.

![Manajemen Janji Temu Pasien di Panel Admin](images/Pasted%20image%20(8).png)

---

## 3.3 Mengelola Unit / Poliklinik (`/admin/departments`)

1. Buka menu **Unit & Poliklinik** di sidebar kiri untuk melihat daftar poliklinik dan jumlah dokternya.

![Daftar Unit Layanan & Poliklinik di Panel Admin](images/Pasted%20image%20(9).png)

2. Klik **Tambah Poli / Unit** (atau ikon edit) untuk menambah atau memperbarui nama poli, kode unit, lokasi ruangan, urutan tampil, deskripsi singkat, dan foto unit.

![Modal Tambah & Edit Unit / Poli](images/Pasted%20image%20(10).png)

---

## 3.4 Mengelola Dokter & Jadwal Praktik (`/admin/doctors`)

1. Buka menu **Dokter & Jadwal** untuk melihat seluruh profil dokter beserta ringkasan jadwal praktiknya.
2. Klik **Tambah Dokter** atau ikon edit pada kartu dokter untuk memperbarui foto dokter, spesialisasi, pendidikan, nomor SIP, serta menambah/menghapus baris **Jadwal Praktik** per hari (Hari, Jam Mulai, Jam Selesai, Ruang).

![Direktori Dokter & Jadwal Praktik di Panel Admin](images/Pasted%20image%20(11).png)

---

## 3.5 Mengelola Lowongan Kerja & Pelamar (`/admin/careers`)

1. Pada tab **Daftar Lowongan**, admin dapat membuka lowongan baru, mengedit kualifikasi, atau menutup lowongan yang sudah terpenuhi.
2. Pada tab **Pelamar Masuk**, admin dapat melihat data pelamar, mengklik tombol **Unduh CV** untuk memeriksa berkas PDF/DOCX pelamar, dan memperbarui status seleksi (**Submitted**, **Reviewed**, **Interview**, **Accepted**, **Rejected**).

![Portal Karir & Data Pelamar di Panel Admin](images/Pasted%20image%20(12).png)

---

## 3.6 Mengelola Artikel & Berita (`/admin/posts`)

1. Buka menu **Artikel & Berita** untuk membuat artikel tips kesehatan, berita kegiatan RS, atau pengumuman baru.
2. Admin dapat menambahkan kategori baru, mengunggah gambar sampul artikel, menentukan status (**Draft** atau **Published**), serta menandai artikel sebagai unggulan (*Featured*).

---

# BAB 4. CUSTOMIZER & LAYOUT BUILDER (TANPA CODING)

## 4.1 Layout & Content Builder (`/admin/pages`)

Menu **Layout Builder** memungkinkan pihak rumah sakit mengatur struktur halaman depan tanpa menyentuh kode:

1. Klik **Edit** pada halaman **Beranda**.
2. Di panel kiri (**Urutan Komponen Halaman**), gunakan tombol panah **Naik / Turun** untuk mengubah urutan posisi section di homepage.
3. Centang atau hapus centang **Tampilkan di Website** untuk mengaktifkan atau menyembunyikan bagian tertentu.
4. Di panel kanan, edit teks judul, subjudul, slide banner, foto direktur, daftar layanan unggulan, atau testimoni pasien secara langsung, lalu klik **Simpan Perubahan Komponen**.

---

## 4.2 Pengaturan Identitas RS & Theme Color Customizer (`/admin/settings`)

Menu **Pengaturan & Tema** menyediakan kendali penuh atas branding visual rumah sakit:

1. **Tab Identitas & Kontak RS:** Ubah nama rumah sakit, tagline, deskripsi SEO, nomor WhatsApp, hotline IGD 24 Jam, telepon, email, jam operasional, dan alamat.
2. **Tab Customizer Warna & Tampilan:** Pilih salah satu **Preset Palet Warna** (Medical Teal, Clinical Royal Blue, Emerald Healthcare, Slate Indigo) atau pilih warna secara manual menggunakan *Color Picker* untuk Warna Utama, Heading, Header/Footer, Background Halaman, Surface Card, dan Aksen. Anda juga dapat mengaktifkan/menonaktifkan Bar Darurat IGD.
3. **Tab Logo Resmi RS:** Unggah logo rumah sakit (PNG/JPG/SVG) yang otomatis tampil di Navbar, Footer, dan Panel Admin.

---

# BAB 5. ARSITEKTUR & SKALABILITAS MASA DEPAN

Sistem dibangun menggunakan arsitektur modular (**Laravel + Inertia.js + Vue 3 + Tailwind CSS**) dengan pemisahan yang jelas antara lapisan data (*Models*), logika bisnis (*Controllers*), dan antarmuka (*Pages/Components*). Struktur ini siap dikembangkan oleh tim IT internal rumah sakit untuk integrasi lanjutan di masa depan, antara lain:

- Integrasi **SIMRS** internal rumah sakit & bridging **BPJS Kesehatan / SatuSehat Kemenkes**.
- Modul **Rekam Medis Elektronik (RME)** & portal hasil laboratorium pasien.
- Integrasi **Payment Gateway** untuk pembayaran konsultasi atau paket Medical Check Up online.
- Layanan **Telemedicine / Konsultasi Video** mandiri.

---

# KONTAK PENGEMBANG & DUKUNGAN TEKNIS

Apabila terdapat pertanyaan, kebutuhan kustomisasi fitur lanjutan, atau jadwal demo langsung, silakan hubungi:

- **Website:** https://hasanarofid.site
- **WhatsApp:** https://wa.me/628814959247
- **Demo Sistem:** https://demo.hasanarofid.site/
