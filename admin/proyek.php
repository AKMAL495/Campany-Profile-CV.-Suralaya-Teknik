<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

$pesan_sukses = "";
$pesan_error = "";

// Variabel untuk mode Edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $result_edit = mysqli_query($koneksi, "SELECT * FROM projects WHERE id = '$id_edit'");
    if ($result_edit && mysqli_num_rows($result_edit) > 0) {
        $edit_data = mysqli_fetch_assoc($result_edit);
    }
}

// Proses Tambah Proyek Baru
if (isset($_POST['tambah_proyek'])) {
    $tahun = trim($_POST['tahun']);
    $nama_perusahaan = trim($_POST['nama_perusahaan']);
    $deskripsi_proyek = trim($_POST['deskripsi_proyek']);
    
    $query = "INSERT INTO projects (tahun, nama_perusahaan, deskripsi_proyek) VALUES ('$tahun', '$nama_perusahaan', '$deskripsi_proyek')";
    if (mysqli_query($koneksi, $query)) {
        $pesan_sukses = "Proyek berhasil ditambahkan!";
    } else {
        $pesan_error = "Gagal menyimpan: " . mysqli_error($koneksi);
    }
}

// Proses Update / Edit Proyek
if (isset($_POST['update_proyek'])) {
    $id = $_POST['id'];
    $tahun = trim($_POST['tahun']);
    $nama_perusahaan = trim($_POST['nama_perusahaan']);
    $deskripsi_proyek = trim($_POST['deskripsi_proyek']);
    
    $query = "UPDATE projects SET tahun = '$tahun', nama_perusahaan = '$nama_perusahaan', deskripsi_proyek = '$deskripsi_proyek' WHERE id = '$id'";
    if (mysqli_query($koneksi, $query)) {
        $pesan_sukses = "Proyek berhasil diperbarui!";
        $edit_data = null;
        header("Refresh: 1; URL=proyek.php");
    } else {
        $pesan_error = "Gagal memperbarui: " . mysqli_error($koneksi);
    }
}

// Proses Hapus Proyek
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM projects WHERE id = '$id'");
    header("Location: proyek.php");
    exit;
}

$proyek_list = mysqli_query($koneksi, "SELECT * FROM projects ORDER BY tahun DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Proyek - Admin Suralaya Teknik</title>
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
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Kelola Proyek</h1>
                        <p class="text-xs md:text-sm text-gray-500">Tambah, edit, atau hapus data portofolio perusahaan.</p>
                    </div>
                </div>
            </header>

            <?php if (!empty($pesan_sukses)): ?>
                <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-xs font-medium"><?= $pesan_sukses; ?></div>
            <?php endif; ?>
            <?php if (!empty($pesan_error)): ?>
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-2xl text-xs font-medium"><?= $pesan_error; ?></div>
            <?php endif; ?>

            <!-- Form Tambah / Edit Proyek -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6 mb-8">
                <h2 class="text-sm font-bold text-gray-900 mb-4">
                    <?= $edit_data ? 'Edit Data Proyek' : 'Tambah Proyek Baru'; ?>
                </h2>
                <form action="" method="POST" class="space-y-4">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id']; ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Tahun</label>
                            <input type="text" name="tahun" required value="<?= $edit_data ? $edit_data['tahun'] : ''; ?>" placeholder="Contoh: 2026" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Perusahaan / Pemberi Kerja</label>
                            <input type="text" name="nama_perusahaan" required value="<?= $edit_data ? htmlspecialchars($edit_data['nama_perusahaan']) : ''; ?>" placeholder="Contoh: PT. Semen Padang" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi Proyek</label>
                        <textarea name="deskripsi_proyek" rows="3" required placeholder="Detail pekerjaan..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-blue-600 focus:outline-none bg-white"><?= $edit_data ? htmlspecialchars($edit_data['deskripsi_proyek']) : ''; ?></textarea>
                    </div>

                    <div class="flex items-center space-x-3">
                        <?php if ($edit_data): ?>
                            <button type="submit" name="update_proyek" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs shadow transition">Simpan Perubahan</button>
                            <a href="proyek.php" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-6 py-2.5 rounded-xl text-xs transition">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="tambah_proyek" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs shadow transition">Simpan Proyek</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar Proyek -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6">
                <h2 class="text-sm font-bold text-gray-900 mb-4">Daftar Proyek di Database</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs min-w-[600px]">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400">
                                <th class="py-3 px-4">Tahun</th>
                                <th class="py-3 px-4">Perusahaan</th>
                                <th class="py-3 px-4">Deskripsi</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if ($proyek_list && mysqli_num_rows($proyek_list) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($proyek_list)): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 font-semibold whitespace-nowrap"><?= $row['tahun']; ?></td>
                                        <td class="py-3 px-4 font-medium text-gray-900 whitespace-nowrap"><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                                        <td class="py-3 px-4 text-gray-600 max-w-xs truncate"><?= htmlspecialchars($row['deskripsi_proyek']); ?></td>
                                        <td class="py-3 px-4 text-center whitespace-nowrap">
                                            <div class="inline-flex items-center space-x-1.5">
                                                <a href="proyek.php?edit=<?= $row['id']; ?>" class="bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold px-3 py-1.5 rounded-xl transition">Edit</a>
                                                <a href="proyek.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus proyek ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-3 py-1.5 rounded-xl transition">Hapus</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="py-4 text-center text-gray-400">Belum ada data proyek.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</body>
</html>