<?php
include 'koneksi.php';

// Menangkap input pencarian dan filter kategori dari URL (GET)
$cari = isset($_GET['cari']) ? trim($_GET['cari']) : '';
$filter_kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';

// Menyusun query SQL dengan prioritas urutan: AC duluan, lalu perangkat lain, baru berdasarkan ID terbaru
$query = "SELECT * FROM katalog WHERE 1=1";

if (!empty($cari)) {
    $cari_safe = $conn->real_escape_string($cari);
    $query .= " AND (nama LIKE '%$cari_safe%' OR deskripsi LIKE '%$cari_safe%' OR merek LIKE '%$cari_safe%' OR kategori_elektronik LIKE '%$cari_safe%')";
}

if (!empty($filter_kategori) && $filter_kategori !== 'Semua') {
    $kat_safe = $conn->real_escape_string($filter_kategori);
    $query .= " AND kategori_elektronik = '$kat_safe'";
}

$query .= " ORDER BY FIELD(kategori_elektronik, 'AC', 'Kipas', 'Kulkas', 'Mesin Cuci') ASC, id DESC";
$result_katalog = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang & Jasa - CV. Suralaya Teknik</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, button, input, select, textarea, th, td, h1, h2, h3, h4, h5, h6, span, p, a {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-800">

    <!-- Memanggil Header -->
    <?php include 'header.php'; ?>

    <main class="max-w-7xl mx-auto px-6 py-12">
        
        <!-- BAGIAN PENCARIAN & FILTER KATEGORI -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-10">
            <form action="katalog.php" method="GET" class="flex flex-col md:flex-row items-center gap-4">
                
                <!-- Input Search -->
                <div class="w-full md:flex-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                        🔍
                    </span>
                    <input type="text" name="cari" value="<?= htmlspecialchars($cari); ?>" placeholder="Cari nama produk, merek, atau deskripsi..." class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
                </div>

                <!-- Pilihan Filter Kategori -->
                <div class="w-full md:w-64">
                    <select name="kategori" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-xs focus:outline-none focus:ring-2 focus:ring-blue-600 transition">
                        <option value="Semua" <?= ($filter_kategori == 'Semua' || $filter_kategori == '') ? 'selected' : ''; ?>>Semua Kategori</option>
                        <option value="AC" <?= ($filter_kategori == 'AC') ? 'selected' : ''; ?>>AC</option>
                        <option value="Kipas" <?= ($filter_kategori == 'Kipas') ? 'selected' : ''; ?>>Kipas Angin</option>
                        <option value="Kulkas" <?= ($filter_kategori == 'Kulkas') ? 'selected' : ''; ?>>Kulkas</option>
                        <option value="Mesin Cuci" <?= ($filter_kategori == 'Mesin Cuci') ? 'selected' : ''; ?>>Mesin Cuci</option>
                    </select>
                </div>

                <!-- Tombol Cari & Reset -->
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-blue-500/20">
                        Cari Produk
                    </button>
                    <?php if (!empty($cari) || (!empty($filter_kategori) && $filter_kategori !== 'Semua')): ?>
                        <a href="katalog.php" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-4 py-3 rounded-2xl text-xs transition text-center">
                            Reset
                        </a>
                    <?php endif; ?>
                </div>

            </form>
        </div>

        <?php 
        // Nomor WhatsApp Perusahaan 
        $no_wa = "6282285975488"; 
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            if ($result_katalog && $result_katalog->num_rows > 0):
                while($item = $result_katalog->fetch_assoc()): 
                    // Format pesan WhatsApp yang membedakan antara Barang/Unit dan Jasa
                    if ($item['kategori'] == 'Barang / Unit' && !empty($item['merek'])) {
                        $info_produk = $item['nama'] . " (Merek: " . $item['merek'] . (!empty($item['tipe_ac']) ? " - " . $item['tipe_ac'] : "") . ")";
                    } else {
                        $info_produk = $item['nama'];
                    }

                    $pesan_wa = urlencode("Halo CV. Suralaya Teknik, saya ingin menanyakan informasi dan estimasi harga untuk produk/jasa: *" . $info_produk . "*. Mohon bantuannya, terima kasih.");
                    $link_wa = "https://wa.me/{$no_wa}?text={$pesan_wa}";
                    
                    $foto_url = !empty($item['gambar']) ? "assets/uploads/katalog/" . $item['gambar'] : "https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80";
            ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between transition hover:-translate-y-1 hover:shadow-md">
                <div>
                    <div class="relative h-48 overflow-hidden bg-gray-100">
                        <img src="<?= $foto_url; ?>" alt="<?= htmlspecialchars($item['nama']); ?>" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-blue-600 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow">
                            <?= htmlspecialchars($item['kategori']); ?>
                        </span>
                    </div>
                    <div class="p-6">
                        <?php if (!empty($item['merek'])): ?>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-wide block mb-1">
                                <?= htmlspecialchars($item['tipe_ac'] ?? ''); ?> • <?= htmlspecialchars($item['merek']); ?>
                            </span>
                        <?php endif; ?>
                        <h3 class="font-bold text-lg text-gray-900 mb-2"><?= htmlspecialchars($item['nama']); ?></h3>
                        <p class="text-xs text-gray-600 leading-relaxed mb-4"><?= nl2br(htmlspecialchars($item['deskripsi'])); ?></p>
                    </div>
                </div>
                
                <div class="p-6 pt-0">
                    <a href="<?= $link_wa; ?>" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-sm">
                        <span>💬 Tanya Harga / Pesan via WA</span>
                    </a>
                </div>
            </div>
            <?php 
                endwhile; 
            else:
            ?>
                <div class="col-span-3 text-center py-16 bg-white rounded-3xl border border-gray-100">
                    <p class="text-gray-400 text-sm mb-2">🔍 Produk atau kategori yang Anda cari tidak ditemukan.</p>
                    <a href="katalog.php" class="text-xs text-blue-600 font-bold hover:underline">Tampilkan Semua Produk</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Memanggil Footer & Widget AI Otomatis -->
    <?php include 'footer.php'; ?>

</body>
</html>