<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Otomatis ubah status menjadi 'sudah_dibaca' saat dibuka
mysqli_query($koneksi, "UPDATE contact_messages SET status = 'sudah_dibaca' WHERE id = '$id'");

$result = mysqli_query($koneksi, "SELECT * FROM contact_messages WHERE id = '$id'");
if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: dashboard.php?tab=pesan");
    exit;
}
$data = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan - Admin Suralaya Teknik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, button, input, select, textarea, th, td {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">

    <!-- Sidebar Admin -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col justify-between hidden md:flex">
        <div>
            <div class="p-6 border-b border-slate-800">
                <h2 class="font-bold text-base tracking-wider">Admin Panel</h2>
                <p class="text-[10px] text-slate-400">Suralaya Teknik</p>
            </div>
            <nav class="p-4 space-y-1 text-xs">
                <a href="dashboard.php?tab=pesan" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-semibold bg-blue-600 text-white shadow-md shadow-blue-600/20">
                    📥 Pesan Masuk
                </a>
                <a href="dashboard.php?tab=katalog" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-semibold text-slate-400 hover:bg-slate-800 hover:text-white">
                    📦 Kelola Katalog
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-800">
            <a href="logout.php" class="flex items-center gap-3 px-4 py-3 rounded-2xl font-semibold text-red-400 hover:bg-red-500/10 transition text-xs">
                🚪 Keluar
            </a>
        </div>
    </aside>

    <main class="flex-1 p-4 md:p-10 md:ml-64 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            
            <header class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">Detail Pesan Pelanggan</h1>
                    <p class="text-xs md:text-sm text-gray-500">Informasi lengkap pesan konsultasi dari pengunjung website.</p>
                </div>
                <a href="dashboard.php?tab=pesan" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm">
                    &larr; Kembali
                </a>
            </header>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block mb-1">Nama Pengirim</span>
                        <h3 class="font-bold text-base text-gray-900"><?= htmlspecialchars($data['nama']); ?></h3>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block mb-1">Waktu Kirim</span>
                        <p class="text-xs font-semibold text-gray-700"><?= $data['created_at']; ?></p>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block mb-1">Email</span>
                        <p class="text-xs font-semibold text-blue-600"><?= htmlspecialchars($data['email']); ?></p>
                    </div>
                    <div>
                        <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block mb-1">Nomor Telepon / WhatsApp</span>
                        <p class="text-xs font-semibold text-emerald-600"><?= htmlspecialchars($data['telepon']); ?></p>
                    </div>
                </div>

                <div>
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-wider block mb-2">Isi Pesan / Konsultasi</span>
                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 text-xs text-gray-700 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($data['pesan']); ?></div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $data['telepon']); ?>?text=Halo%20<?= urlencode($data['nama']); ?>,%20terima%20kasih%20telah%20menghubungi%20CV.%20Suralaya%20Teknik." target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <span>💬 Balas via WhatsApp</span>
                    </a>
                    <a href="dashboard.php?hapus=<?= $data['id']; ?>" onclick="return confirm('Hapus pesan ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-4 py-2.5 rounded-xl text-xs transition">
                        Hapus Pesan
                    </a>
                </div>
            </div>

        </div>
    </main>

</body>
</html>