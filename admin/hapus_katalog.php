<?php
session_start();
include '../koneksi.php';
if (!isset($conn) && isset($koneksi)) { $conn = $koneksi; }

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = $conn->real_escape_string($_POST['kategori']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $deskripsi = $conn->real_escape_string($_POST['deskripsi']);
    
    $kategori_elektronik = ($kategori == 'Barang / Unit') ? $conn->real_escape_string($_POST['kategori_elektronik']) : null;
    $merek = ($kategori == 'Barang / Unit') ? $conn->real_escape_string($_POST['merek']) : null;
    $jenis_ac = ($kategori == 'Barang / Unit' && isset($_POST['jenis_ac'])) ? $conn->real_escape_string($_POST['jenis_ac']) : null;
    $tipe_ac = ($kategori == 'Barang / Unit') ? $conn->real_escape_string($_POST['tipe_ac']) : null;
    
    $nama_file_gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'webp');
        $nama_file = $_FILES['gambar']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar']['tmp_name'];

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $nama_file_gambar = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $nama_file);
            
            if (!is_dir('../assets/uploads/katalog')) {
                mkdir('../assets/uploads/katalog', 0777, true);
            }
            
            move_uploaded_file($file_tmp, '../assets/uploads/katalog/' . $nama_file_gambar);
        }
    }

    $stmt = $conn->prepare("INSERT INTO katalog (kategori, nama, deskripsi, gambar, kategori_elektronik, merek, jenis_ac, tipe_ac) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $kategori, $nama, $deskripsi, $nama_file_gambar, $kategori_elektronik, $merek, $jenis_ac, $tipe_ac);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?tab=katalog&pesan=berhasil_tambah_katalog");
    } else {
        header("Location: dashboard.php?tab=katalog&pesan=gagal_tambah_katalog");
    }
    exit;
}
?>