<?php
include 'koneksi.php';
include 'track_visitor.php'; // Pencatat pengunjung otomatis

// Ambil data foto dari database
$galeri_list = mysqli_query($conn, "SELECT * FROM galleries ORDER BY id DESC");
if (!$galeri_list) {
    $galeri_list = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Proyek - Suralaya Teknik</title>
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

    <!-- HEADER / NAVBAR UTAMA -->
    <?php include 'header.php'; ?>

    <!-- KONTEN GALERI PUBLIK DENGAN ANIMASI MASUK -->
    <section class="max-w-7xl mx-auto px-6 py-16 animate-slide-up">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Dokumentasi & Portofolio</span>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-1">Galeri Proyek Suralaya Teknik</h1>
            <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">Berikut adalah beberapa dokumentasi pekerjaan instalasi, perawatan, dan proyek MEP & HVAC yang telah kami tangani.</p>
        </div>

        <!-- Grid Foto Galeri -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php if ($galeri_list && mysqli_num_rows($galeri_list) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($galeri_list)): ?>
                    <?php 
                        $nama_file = !empty($row['gambar']) ? $row['gambar'] : $row['foto'];
                        $judul = isset($row['judul']) ? trim($row['judul']) : '';
                    ?>
                    <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col group">
                        <div class="h-64 overflow-hidden bg-gray-100">
                            <img src="uploads/<?= htmlspecialchars($nama_file); ?>" alt="Galeri Suralaya Teknik" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        </div>
                        <?php if (!empty($judul)): ?>
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 text-sm"><?= htmlspecialchars($judul); ?></h3>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-3 py-16 text-center text-gray-400 text-sm bg-white rounded-3xl border border-gray-100 shadow-sm">
                    Belum ada dokumentasi galeri yang diunggah.
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FOOTER -->
    <?php include 'footer.php'; ?>
</body>
</html>