<?php
// Pastikan session aktif agar bisa mengecek status login admin
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah yang membuka halaman adalah Admin yang sedang login
$is_admin = isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;

// Jika BUKAN admin, baru rekam kunjungannya ke database
if (!$is_admin) {
    if (isset($conn) || isset($koneksi)) {
        $db = isset($conn) ? $conn : $koneksi;
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $agent = mysqli_real_escape_string($db, $_SERVER['HTTP_USER_AGENT']);
        $page = mysqli_real_escape_string($db, $_SERVER['PHP_SELF']);

        // Simpan ke database
        mysqli_query($db, "INSERT INTO visitor_logs (ip_address, user_agent, halaman) VALUES ('$ip', '$agent', '$page')");
    }
}
?>