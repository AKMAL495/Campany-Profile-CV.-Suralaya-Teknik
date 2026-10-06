<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_tab = isset($_GET['tab']) ? $_GET['tab'] : '';

// Ambil jumlah pesan yang belum dibaca dari database
$jumlah_unread = 0;
if (isset($koneksi)) {
    $q_unread = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM contact_messages WHERE status = 'belum_dibaca'");
    if ($q_unread) {
        $d_unread = mysqli_fetch_assoc($q_unread);
        $jumlah_unread = $d_unread['total'] ?? 0;
    }
}
?>
<!-- SIDEBAR UTAMA (Responsif: tersembunyi di HP, muncul otomatis di layar besar) -->
<aside id="app-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-gray-900 text-white p-6 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-xl">
    <div>
        <!-- Bagian Logo & Judul Admin Panel -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="../logo.png" alt="Logo Suralaya Teknik" class="w-10 h-10 object-contain bg-white rounded-xl p-1 shadow-sm">
                <div>
                    <h1 class="text-base font-bold tracking-wider text-white leading-tight">Admin Panel</h1>
                    <p class="text-[11px] text-gray-400">Suralaya Teknik</p>
                </div>
            </div>
            <!-- Tombol Close untuk HP -->
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white p-1">
                ✕
            </button>
        </div>

        <nav class="space-y-2 text-sm font-medium">
            <!-- Pesan Masuk dengan Badge Notifikasi Angka Merah di Kanan -->
            <a href="dashboard.php?tab=pesan" class="flex items-center justify-between py-2.5 px-4 rounded-xl transition <?= ($current_page == 'dashboard.php' && ($current_tab == '' || $current_tab == 'pesan')) ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <span>Pesan Masuk</span>
                <?php if ($jumlah_unread > 0): ?>
                    <span class="bg-red-500 text-white text-[11px] font-bold px-2 py-0.5 rounded-full animate-pulse shadow-sm"><?= $jumlah_unread; ?></span>
                <?php endif; ?>
            </a>
            
            <a href="dashboard.php?tab=katalog" class="flex items-center py-2.5 px-4 rounded-xl transition <?= ($current_page == 'dashboard.php' && $current_tab == 'katalog') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <span>Kelola Katalog</span>
            </a>

            <a href="proyek.php" class="flex items-center py-2.5 px-4 rounded-xl transition <?= ($current_page == 'proyek.php') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <span>Kelola Proyek</span>
            </a>
            
            <a href="galeri.php" class="flex items-center py-2.5 px-4 rounded-xl transition <?= ($current_page == 'galeri.php') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <span>Kelola Galeri</span>
            </a>

            <a href="visitors.php" class="flex items-center py-2.5 px-4 rounded-xl transition <?= ($current_page == 'visitors.php') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-400 hover:bg-gray-800 hover:text-white'; ?>">
                <span>Log Pengunjung</span>
            </a>
            
            <a href="../index.php" target="_blank" class="flex items-center py-2.5 px-4 rounded-xl text-gray-400 hover:bg-gray-800 hover:text-white transition">
                <span>Lihat Website</span>
            </a>
            
            <a href="logout.php" class="flex items-center py-2.5 px-4 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 mt-8 transition border border-red-500/20">
                <span>Keluar</span>
            </a>
        </nav>
    </div>
</aside>

<!-- Overlay Hitam untuk HP saat Sidebar Terbuka -->
<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 hidden md:hidden"></div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>