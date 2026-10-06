# Company Profile - CV Suralaya Teknik

Website *company profile* resmi untuk **CV Suralaya Teknik** yang dikembangkan menggunakan **PHP Native** dan **MySQL**. Website ini menyajikan informasi profil perusahaan, katalog layanan/jasa, galeri proyek, serta integrasi kontak.

---

## 🛠️ Tech Stack & Alat
* **Backend:** PHP (Native)
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
* **Layanan Tambahan:** AI Widget Integration (`ai_widget.php`), Visitor Tracking System (`track_visitor.php`)

---

## ✨ Fitur Utama
1. **Halaman Utama & Profil Perusahaan:** Menampilkan informasi seputar CV Suralaya Teknik.
2. **Katalog Layanan & Jasa:** Daftar produk/jasa teknis yang ditawarkan.
3. **Galeri Proyek:** Portofolio dokumentasi pengerjaan proyek.
4. **Halaman Kontak:** Akses cepat komunikasi dengan pihak perusahaan.
5. **Pencatat Pengunjung (*Visitor Tracker*):** Fitur untuk mencatat/memantau pengunjung web.

---

## 🚀 Cara Menjalankan di Localhost

1. **Unduh Proyek:**
   * Clone repositori ini atau klik **Code > Download ZIP**, lalu ekstrak file ke folder server kamu (`htdocs` untuk XAMPP).

2. **Persiapan Database:**
   * Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
   * Buat database baru dengan nama `suralaya_teknik` (atau sesuaikan dengan konfigurasi kamu).
   * Import file `suralaya_teknik.sql` yang berada di direktori utama proyek ke dalam database tersebut.

3. **Konfigurasi Koneksi:**
   * Buka file `koneksi.php`.
   * Sesuaikan *host*, *username*, *password*, dan nama database dengan pengaturan lokal kamu:
     ```php
     $host = "localhost";
     $user = "root";
     $pass = "";
     $db   = "suralaya_teknik";
     ```

4. **Jalankan Aplikasi:**
   * Buka browser dan akses `http://localhost/nama-folder-proyek`.
