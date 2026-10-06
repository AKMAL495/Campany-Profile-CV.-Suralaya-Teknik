<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

header('Content-Type: application/json');

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

// Ambil pesan terbaru yang belum dibaca
$query = mysqli_query($koneksi, "SELECT * FROM contact_messages WHERE status = 'belum_dibaca' ORDER BY id DESC LIMIT 1");
if ($query && mysqli_num_rows($query) > 0) {
    $data = mysqli_fetch_assoc($query);
    echo json_encode([
        'ada_pesan_baru' => true,
        'id' => $data['id'],
        'nama' => $data['nama'],
        'pesan' => $data['pesan']
    ]);
} else {
    echo json_encode(['ada_pesan_baru' => false]);
}
?>