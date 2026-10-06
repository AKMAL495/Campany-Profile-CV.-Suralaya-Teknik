<?php
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

$username_baru = "cv. suralaya teknik";
$password_mentah = "Suralaya01@";

// Generate hash resmi yang cocok dengan sistem server Anda
$password_hash = password_hash($password_mentah, PASSWORD_DEFAULT);

// Update ke database tabel admins (ID 5)
$update = mysqli_query($conn, "UPDATE admins SET username = '$username_baru', password = '$password_hash' WHERE id = 5");

if ($update) {
    echo "<h3 style='color:green; text-align:center; margin-top:50px;'>Berhasil! Akun Admin sudah di-reset.</h3>";
    echo "<p style='text-align:center;'>Username: <b>cv. suralaya teknik</b><br>Password: <b>Suralaya01@</b></p>";
    echo "<p style='text-align:center;'><a href='login.php'>Klik di sini untuk Login</a></p>";
} else {
    echo "<h3 style='color:red; text-align:center; margin-top:50px;'>Gagal mereset: " . mysqli_error($conn) . "</h3>";
}
?>