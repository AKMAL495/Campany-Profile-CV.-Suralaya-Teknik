<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "suralaya_teknik"; // Sesuaikan nama database Anda

$koneksi = mysqli_connect($host, $user, $pass, $db);
$conn    = $koneksi; // Membuat alias agar kompatibel dengan semua file

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>