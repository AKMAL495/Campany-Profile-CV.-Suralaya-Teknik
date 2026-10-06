<?php
include 'koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

// Ambil data langsung dari database, diurutkan dari tahun terbaru
$query = "SELECT * FROM projects ORDER BY tahun DESC, id DESC";
$result = mysqli_query($koneksi, $query);

$proyek_per_tahun = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $proyek_per_tahun[$row['tahun']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyek Kami - Suralaya Teknik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Animasi Masuk Halaman */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
        .animate-slide-up { animation: slideUp 0.8s ease-out forwards; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 animate-fade-in">

    <!-- Header / Navbar -->
    <?php include 'header.php'; ?>

    <!-- Konten Berdasarkan Database dengan Animasi Masuk -->
    <div class="max-w-6xl mx-auto px-6 py-16 space-y-12 animate-slide-up">
        <?php if (!empty($proyek_per_tahun)): ?>
            <?php foreach ($proyek_per_tahun as $tahun => $daftar_proyek): ?>
                <div>
                    <!-- Judul Tahun -->
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-blue-100 text-blue-600 p-2.5 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($tahun); ?></h2>
                    </div>

                    <!-- Kartu Proyek (Ukuran Pendek dan Seragam dengan Efek Hover) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <?php foreach ($daftar_proyek as $row): ?>
                            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex items-start space-x-4 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                                <div class="bg-blue-50 text-blue-600 p-3 rounded-2xl flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-base text-gray-900 mb-1"><?= htmlspecialchars($row['nama_perusahaan']); ?></h3>
                                    <p class="text-xs text-gray-500 leading-relaxed flex items-start space-x-1.5">
                                        <span class="text-blue-500 mt-0.5">✔</span>
                                        <span><?= htmlspecialchars($row['deskripsi_proyek']); ?></span>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-16 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <p class="text-sm text-gray-400">Belum ada data proyek di dalam database.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>
</html>