<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

$pesan_sukses = "";
$pesan_error = "";

// Proses Upload Banyak Foto Sekaligus
if (isset($_POST['upload_foto'])) {
    $judul_input = trim($_POST['judul']);
    $judul_default = ($judul_input !== '') ? $judul_input : '';
    
    $folder_tujuan = "../uploads/";
    if (!is_dir($folder_tujuan)) {
        mkdir($folder_tujuan, 0777, true);
    }

    $total_file = count($_FILES['foto']['name']);
    $berhasil_upload = 0;

    for ($i = 0; $i < $total_file; $i++) {
        $nama_file = $_FILES['foto']['name'][$i];
        $tmp_file = $_FILES['foto']['tmp_name'][$i];
        $ukuran_file = $_FILES['foto']['size'][$i];

        if (!empty($nama_file)) {
            $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
            $valid_ext = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($ext, $valid_ext)) {
                $nama_file_unik = time() . '_' . rand(1000, 9999) . '_' . basename($nama_file);
                $target_path = $folder_tujuan . $nama_file_unik;

                if (move_uploaded_file($tmp_file, $target_path)) {
                    $judul_safe = mysqli_real_escape_string($koneksi, $judul_default);
                    
                    $query = "INSERT INTO galleries (gambar, judul) VALUES ('$nama_file_unik', '$judul_safe')";
                    $cek_query = mysqli_query($koneksi, $query);
                    if (!$cek_query) {
                        mysqli_query($koneksi, "INSERT INTO galeri (foto, judul) VALUES ('$nama_file_unik', '$judul_safe')");
                    }
                    
                    $berhasil_upload++;
                }
            }
        }
    }

    if ($berhasil_upload > 0) {
        header("Location: galeri.php?status=sukses&total=" . $berhasil_upload);
        exit;
    } else {
        $pesan_error = "Gagal meng-upload foto. Pastikan format file valid (JPG, PNG, WEBP).";
    }
}

// Notifikasi sukses dari redirect URL
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $total_uploaded = isset($_GET['total']) ? $_GET['total'] : '';
    $pesan_sukses = "Berhasil meng-upload " . ($total_uploaded ? $total_uploaded : '') . " foto ke galeri!";
}

// Proses Hapus Satuan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $res = mysqli_query($koneksi, "SELECT * FROM galleries WHERE id = '$id'");
    if (!$res || mysqli_num_rows($res) == 0) {
        $res = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id = '$id'");
    }
    
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $file_target = isset($row['gambar']) ? $row['gambar'] : $row['foto'];
        if (file_exists("../uploads/" . $file_target)) {
            unlink("../uploads/" . $file_target);
        }
    }
    
    mysqli_query($koneksi, "DELETE FROM galleries WHERE id = '$id'");
    mysqli_query($koneksi, "DELETE FROM galeri WHERE id = '$id'");
    
    header("Location: galeri.php");
    exit;
}

// Proses Hapus Banyak (Berdasarkan Checkbox yang Dipilih)
if (isset($_POST['hapus_pilihan']) && isset($_POST['id_foto'])) {
    foreach ($_POST['id_foto'] as $id) {
        $id = mysqli_real_escape_string($koneksi, $id);
        
        $res = mysqli_query($koneksi, "SELECT * FROM galleries WHERE id = '$id'");
        if (!$res || mysqli_num_rows($res) == 0) {
            $res = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id = '$id'");
        }
        
        if ($res && $row = mysqli_fetch_assoc($res)) {
            $file_target = isset($row['gambar']) ? $row['gambar'] : $row['foto'];
            if (file_exists("../uploads/" . $file_target)) {
                unlink("../uploads/" . $file_target);
            }
        }
        
        mysqli_query($koneksi, "DELETE FROM galleries WHERE id = '$id'");
        mysqli_query($koneksi, "DELETE FROM galeri WHERE id = '$id'");
    }
    header("Location: galeri.php");
    exit;
}

// Proses Hapus Semua Foto
if (isset($_GET['hapus_semua'])) {
    $res1 = mysqli_query($koneksi, "SELECT * FROM galleries");
    while ($r = mysqli_fetch_assoc($res1)) {
        if (!empty($r['gambar']) && file_exists("../uploads/" . $r['gambar'])) {
            unlink("../uploads/" . $r['gambar']);
        }
    }
    $res2 = mysqli_query($koneksi, "SELECT * FROM galeri");
    while ($r = mysqli_fetch_assoc($res2)) {
        if (!empty($r['foto']) && file_exists("../uploads/" . $r['foto'])) {
            unlink("../uploads/" . $r['foto']);
        }
    }

    mysqli_query($koneksi, "DELETE FROM galleries");
    mysqli_query($koneksi, "DELETE FROM galeri");

    header("Location: galeri.php");
    exit;
}

// Ambil daftar foto dari database
$galeri_list = mysqli_query($koneksi, "SELECT * FROM galleries ORDER BY id DESC");
if (!$galeri_list) {
    $galeri_list = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri - Admin Suralaya Teknik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, button, input, select, textarea, th, td {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">

    <!-- SIDEBAR -->
    <?php include 'sidebar.php'; ?>

    <!-- KONTEN UTAMA (Ditambahkan md:ml-64 agar tidak menabrak sidebar) -->
    <main class="flex-1 p-4 md:p-10 md:ml-64 overflow-y-auto">
        <div class="max-w-5xl mx-auto">
            
            <!-- HEADER DENGAN TOMBOL HAMBURGER -->
            <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <!-- Tombol Hamburger khusus HP -->
                    <button onclick="toggleSidebar()" class="md:hidden bg-white p-2.5 rounded-xl border border-gray-200 text-gray-700 shadow-sm focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Galeri Foto</h1>
                        <p class="text-xs md:text-sm text-gray-500">Tambah atau hapus dokumentasi proyek dan layanan Suralaya Teknik.</p>
                    </div>
                </div>
            </header>

            <?php if (!empty($pesan_sukses)): ?>
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-xs font-medium"><?= $pesan_sukses; ?></div>
            <?php endif; ?>
            <?php if (!empty($pesan_error)): ?>
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-2xl text-xs font-medium"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <!-- Form Upload Banyak Foto -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Upload Foto Baru ke Galeri (Bisa Banyak Sekaligus)</h2>
                <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">
                            Judul / Keterangan Bersama <span class="text-gray-400 font-normal">(Opsional, boleh dikosongkan)</span>
                        </label>
                        <input type="text" name="judul" placeholder="Contoh: Dokumentasi Proyek MEP Gedung A" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pilih File Foto (Bisa pilih lebih dari satu dengan tahan tombol Ctrl / Shift)</label>
                        <input type="file" name="foto[]" multiple required accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-600 hover:file:bg-blue-100">
                    </div>
                    <button type="submit" name="upload_foto" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs shadow transition">Upload Semua Foto</button>
                </form>
            </div>

            <!-- Daftar Foto Galeri dengan Fitur Hapus Pilihan & Hapus Semua -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6">
                <form action="" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto yang dipilih?')">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <h2 class="text-sm font-bold text-gray-900">Daftar Foto Galeri</h2>
                        
                        <div class="flex items-center gap-2">
                            <!-- Tombol Hapus yang Dipilih -->
                            <button type="submit" name="hapus_pilihan" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2 rounded-xl text-xs transition border border-red-100">
                                Hapus Terpilih
                            </button>
                            <!-- Tombol Hapus Semua -->
                            <a href="galeri.php?hapus_semua=true" onclick="return confirm('PERHATIAN: Semua foto di galeri akan dihapus permanen. Lanjutkan?')" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm inline-block">
                                Hapus Semua Foto
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <?php if ($galeri_list && mysqli_num_rows($galeri_list) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($galeri_list)): ?>
                                <?php 
                                    $nama_file = !empty($row['gambar']) ? $row['gambar'] : $row['foto'];
                                    $judul = isset($row['judul']) ? trim($row['judul']) : '';
                                ?>
                                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 p-4 flex flex-col justify-between relative shadow-sm">
                                    <!-- Checkbox Pilih Foto -->
                                    <div class="absolute top-6 left-6 z-10">
                                        <input type="checkbox" name="id_foto[]" value="<?= $row['id']; ?>" class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer shadow">
                                    </div>

                                    <div>
                                        <div class="aspect-video overflow-hidden rounded-xl bg-white mb-3 border border-gray-100">
                                            <img src="../uploads/<?= htmlspecialchars($nama_file); ?>" alt="Foto Galeri" class="w-full h-full object-cover">
                                        </div>
                                        <?php if (!empty($judul)): ?>
                                            <h3 class="font-bold text-xs text-gray-900 mb-1"><?= htmlspecialchars($judul); ?></h3>
                                        <?php endif; ?>
                                    </div>
                                    <div class="pt-3 border-t border-gray-200/60 mt-2">
                                        <a href="galeri.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus foto ini?')" class="block text-center bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2 rounded-xl text-xs transition">Hapus Foto</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-span-full text-center py-8 text-gray-400 text-xs">Belum ada foto di dalam galeri.</div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
    </main>
</body>
</html>