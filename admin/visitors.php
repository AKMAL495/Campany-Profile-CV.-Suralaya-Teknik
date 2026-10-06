<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: login.php");
    exit;
}

// Proses bersihkan log jika tombol ditekan
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    mysqli_query($koneksi, "DELETE FROM visitor_logs");
    header("Location: visitors.php");
    exit;
}

$visitors = mysqli_query($koneksi, "SELECT * FROM visitor_logs ORDER BY id DESC");
$total_visitors = mysqli_num_rows($visitors);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Pengunjung - Admin Suralaya Teknik</title>
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

    <!-- KONTEN UTAMA (Responsif Margin Kiri & Padding HP) -->
    <main class="flex-1 p-4 md:p-10 md:ml-64 overflow-y-auto">
        <div class="max-w-6xl mx-auto">
            
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
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">Riwayat Pengunjung Website</h1>
                        <p class="text-xs md:text-sm text-gray-500">Mencatat alamat IP, perangkat, dan waktu kunjungan.</p>
                    </div>
                </div>

                <!-- Tombol Bersihkan Log -->
                <div>
                    <a href="visitors.php?action=clear" onclick="return confirm('Yakin ingin menghapus seluruh riwayat log pengunjung?')" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-4 py-2.5 rounded-xl text-xs transition border border-red-200 inline-block">
                        🗑️ Bersihkan Log
                    </a>
                </div>
            </header>

            <!-- KARTU TOTAL PENGUNJUNG -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 max-w-sm">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-50 text-blue-600 p-4 rounded-2xl">
                        👥
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Pengunjung</p>
                        <h3 class="text-2xl font-extrabold text-gray-900"><?= $total_visitors; ?> <span class="text-xs font-normal text-gray-500">kali akses</span></h3>
                    </div>
                </div>
            </div>

            <!-- TABEL RIWAYAT (Dibungkus overflow-x-auto agar aman di HP) -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6 overflow-hidden">
                <h3 class="text-sm font-bold text-gray-900 mb-4">📋 Log Akses Pengunjung</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs min-w-[600px]">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400">
                                <th class="py-3 px-4">Waktu Kunjungan</th>
                                <th class="py-3 px-4">Alamat IP</th>
                                <th class="py-3 px-4">Halaman yang Diakses</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if ($visitors && mysqli_num_rows($visitors) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($visitors)): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-4 text-gray-500 whitespace-nowrap"><?= htmlspecialchars($row['visit_time'] ?? '-'); ?></td>
                                        <td class="py-4 px-4 font-mono text-blue-600 whitespace-nowrap"><?= htmlspecialchars($row['ip_address'] ?? '-'); ?></td>
                                        <td class="py-4 px-4 text-gray-700 truncate max-w-xs"><?= htmlspecialchars($row['page_url'] ?? '-'); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-400">Belum ada riwayat pengunjung tercatat.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>
</html>