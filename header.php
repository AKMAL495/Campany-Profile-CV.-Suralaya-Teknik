<?php
// Mendapatkan nama file halaman yang sedang diakses saat ini
$current_page = basename($_SERVER['PHP_SELF']);
$is_home = ($current_page == 'index.php' || $current_page == '');

// Menentukan teks berdasarkan halaman yang aktif (badge dihapus)
$title_text   = "CV. Suralaya Teknik";
$desc_text    = "Mitra terpercaya dalam solusi MEP & HVAC sejak 2012";
$show_buttons = true;
$bg_image     = "bg.jpeg"; // Default background untuk Beranda

if ($current_page == 'tentang.php') {
    $title_text   = "Tentang Kami";
    $desc_text    = "Mitra terpercaya untuk solusi HVAC & MEP sejak 2012";
    $show_buttons = false;
    $bg_image     = "bg-tentang.png";
} elseif ($current_page == 'layanan.php') {
    $title_text   = "Solusi MEP & HVAC Terpercaya";
    $desc_text    = "Spesialis sistem MEP & HVAC untuk komersial dan industri";
    $show_buttons = false;
    $bg_image     = "bg-layanan.jpeg";
} elseif ($current_page == 'katalog.php') {
    $title_text   = "Produk & Layanan Berkualitas";
    $desc_text    = "Pilihan lengkap unit dan layanan HVAC & MEP dengan estimasi harga menyesuaikan kebutuhan Anda.";
    $show_buttons = false;
    $bg_image     = "bg.jpeg";
} elseif ($current_page == 'proyek.php') {
    $title_text   = "Rekam Jejak Proyek";
    $desc_text    = "Rekam jejak keberhasilan dalam menghadirkan solusi HVAC terbaik.";
    $show_buttons = false;
    $bg_image     = "bg-proyek.jpeg";
} elseif ($current_page == 'galeri.php') {
    $title_text   = "Aktivitas & Proyek Kami";
    $desc_text    = "Dokumentasi langsung pengerjaan lapangan oleh tim ahli.";
    $show_buttons = false;
    $bg_image     = "bg-galeri.jpg";
} elseif ($current_page == 'kontak.php') {
    $title_text   = "Mari Terhubung";
    $desc_text    = "Kami siap membantu menjawab pertanyaan Anda.";
    $show_buttons = false;
    $bg_image     = "bg-kontak.jpeg";
}

if (!file_exists($bg_image)) {
    $bg_image = "bg.jpeg";
}
?>
<!-- CSS Keyframes Animasi Masuk & Penyeragaman Satu Font (Sans-serif bersih) -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    .animate-slide-up { animation: slideUp 0.8s ease-out forwards; }
    .delay-100 { animation-delay: 0.15s; }
    .delay-200 { animation-delay: 0.3s; }

    /* Memastikan seluruh teks banner menggunakan 1 jenis font yang konsisten */
    .banner-font-system {
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
</style>

<!-- Header & Navbar Utama (Fixed di atas dengan latar belakang Putih Solid) -->
<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-sm animate-fade-in transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        
        <!-- Logo & Nama Brand -->
        <a href="index.php" class="flex items-center space-x-3 group">
            <img src="logo.png" alt="Logo Suralaya Teknik" class="h-10 w-10 object-contain rounded-xl shadow-sm border border-gray-100" onerror="this.src='https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=100&q=80'">
            <div>
                <span class="font-bold text-base text-gray-900 group-hover:text-blue-600 transition block leading-tight">Suralaya Teknik</span>
                <span class="text-[10px] text-gray-400 font-medium tracking-wide">HVAC & Mechanical Electrical</span>
            </div>
        </a>
        
        <!-- Navigasi Desktop -->
        <nav class="hidden md:flex space-x-6 text-sm font-medium text-gray-600">
            <a href="index.php" class="<?= ($current_page == 'index.php' || $current_page == '') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Beranda</a>
            <a href="tentang.php" class="<?= ($current_page == 'tentang.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Tentang Kami</a>
            <a href="layanan.php" class="<?= ($current_page == 'layanan.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Layanan</a>
            <a href="katalog.php" class="<?= ($current_page == 'katalog.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Katalog</a>
            <a href="proyek.php" class="<?= ($current_page == 'proyek.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Proyek</a>
            <a href="galeri.php" class="<?= ($current_page == 'galeri.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Galeri</a>
            <a href="kontak.php" class="<?= ($current_page == 'kontak.php') ? 'text-blue-600 font-bold' : 'hover:text-blue-600'; ?> py-1.5 transition">Kontak</a>
        </nav>

        <div class="hidden md:flex items-center space-x-4">
            <a href="admin/dashboard.php" class="text-gray-600 hover:text-gray-900 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-xs py-2 px-3 rounded-xl transition font-medium">Admin</a>
        </div>

        <!-- Tombol Menu Hamburger untuk HP -->
        <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Menu Dropdown untuk HP -->
    <div id="mobile-menu" class="hidden md:hidden bg-white text-gray-800 border-gray-100 border-t px-6 py-4 space-y-3 text-sm font-medium shadow-lg">
        <a href="index.php" class="block <?= ($current_page == 'index.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Beranda</a>
        <a href="tentang.php" class="block <?= ($current_page == 'tentang.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Tentang Kami</a>
        <a href="layanan.php" class="block <?= ($current_page == 'layanan.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Layanan</a>
        <a href="katalog.php" class="block <?= ($current_page == 'katalog.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Katalog</a>
        <a href="proyek.php" class="block <?= ($current_page == 'proyek.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Proyek</a>
        <a href="galeri.php" class="block <?= ($current_page == 'galeri.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Galeri</a>
        <a href="kontak.php" class="block <?= ($current_page == 'kontak.php') ? 'text-blue-600 font-bold' : ''; ?> py-1">Kontak</a>
        <div class="pt-2 border-t border-gray-100">
            <a href="admin/dashboard.php" class="block text-xs py-1 text-gray-600 font-semibold">Login Admin</a>
        </div>
    </div>
</header>

<!-- Banner Utama (Badge Dihapus, Font Diseragamkan) -->
<section class="bg-gray-900 text-white banner-font-system <?= $is_home ? 'min-h-[85vh] md:h-screen flex items-center justify-center pt-28' : 'py-28 pt-32'; ?> px-6 bg-cover bg-center text-center relative overflow-hidden" style="background-image: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)), url('<?= $bg_image; ?>');">
    <div class="max-w-3xl mx-auto">
        <!-- Judul Banner (Menggunakan 1 gaya font konsisten) -->
        <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-4 animate-slide-up">
            <?= $title_text; ?>
        </h1>

        <!-- Deskripsi Banner -->
        <p class="text-sm md:text-base text-gray-200 font-normal animate-slide-up delay-100 max-w-xl mx-auto leading-relaxed">
            <?= $desc_text; ?>
        </p>
        
        <?php if ($show_buttons): ?>
        <div class="mt-8 flex flex-wrap justify-center gap-4 animate-slide-up delay-200">
            <a href="kontak.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-7 py-3 rounded-xl text-xs transition shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5">Hubungi Kami →</a>
            <a href="proyek.php" class="bg-white/10 hover:bg-white/20 text-white font-medium px-7 py-3 rounded-xl text-xs transition border border-white/20 backdrop-blur-md hover:-translate-y-0.5">Lihat Proyek</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Skrip JavaScript untuk Tombol Menu HP -->
<script>
    const btn = document.getElementById('menu-btn');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>