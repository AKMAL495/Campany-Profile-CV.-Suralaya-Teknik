<?php
include 'koneksi.php';
include 'track_visitor.php'; // Otomatis mencatat setiap pengunjung yang membuka beranda
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suralaya Teknik - Solusi MEP & HVAC Terpercaya</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Konsistensi 1 Jenis Font di Seluruh Elemen Halaman */
        body, button, input, select, textarea, th, td, h1, h2, h3, h4, h5, h6 {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif !important;
        }

        /* Definisi Keyframes Animasi Masuk (Load) */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Kelas Utility Animasi */
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }
        .animate-slide-up {
            animation: slideUp 0.8s ease-out forwards;
        }
        
        /* Penundaan (Delay) agar animasi muncul berurutan dengan rapi */
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 animate-fade-in">

    <!-- Navbar & Banner Otomatis -->
    <?php include 'header.php'; ?>

    <!-- Mengapa Memilih Kami -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-12 animate-slide-up">
            <span class="text-blue-600 text-xs font-semibold tracking-wider uppercase">Mengapa Memilih Kami</span>
            <h3 class="text-3xl font-extrabold text-gray-900 mt-1">Solusi MEP & HVAC Terintegrasi</h3>
            <p class="text-gray-500 text-sm mt-2 max-w-xl mx-auto">Kami menyediakan layanan komprehensif untuk sistem MEP & HVAC dengan standar kualitas tertinggi untuk berbagai kebutuhan gedung dan industri.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 animate-slide-up delay-100">
                <div class="text-blue-600 font-bold mb-2 text-sm">✓ Tim Ahli Berpengalaman</div>
                <p class="text-gray-500 text-xs leading-relaxed">Didukung oleh tenaga profesional berpengalaman di bidang MEP & HVAC.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 animate-slide-up delay-200">
                <div class="text-blue-600 font-bold mb-2 text-sm">✓ Layanan Terintegrasi</div>
                <p class="text-gray-500 text-xs leading-relaxed">Dari perencanaan, instalasi hingga pemeliharaan sistem yang komprehensif.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 animate-slide-up delay-300">
                <div class="text-blue-600 font-bold mb-2 text-sm">✓ Pengalaman Luas</div>
                <p class="text-gray-500 text-xs leading-relaxed">Telah menangani berbagai proyek MEP & HVAC sejak 2012.</p>
            </div>
        </div>

       <div class="rounded-3xl overflow-hidden shadow-md group animate-slide-up">
            <img src="in.jpeg" alt="Instalasi Suralaya Teknik" class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-700">
        </div>
    </section>

    <!-- Layanan Komprehensif -->
    <section class="max-w-7xl mx-auto px-6 py-12">
        <div class="text-center mb-12">
            <h3 class="text-3xl font-extrabold text-gray-900">Layanan MEP & HVAC Komprehensif</h3>
            <p class="text-gray-500 text-sm mt-2">Solusi sistem terintegrasi untuk berbagai kebutuhan industri</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <div class="text-blue-600 text-xl mb-3">❄️</div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm">HVAC</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Sistem pendingin udara, ventilasi, dan pengkondisian udara untuk kenyamanan optimal.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <div class="text-blue-600 text-xl mb-3">⚙️</div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm">Mekanikal</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Sistem mekanikal dan perpipaan untuk berbagai kebutuhan industri.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <div class="text-blue-600 text-xl mb-3">⚡</div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm">Elektrikal</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Sistem kelistrikan, instalasi daya, dan sistem pencahayaan.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <div class="text-blue-600 text-xl mb-3">🚰</div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm">Plumbing</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Sistem perpipaan, drainase, dan pengolahan air.</p>
            </div>
        </div>
    </section>

    <!-- Komitmen Pada Kualitas -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Keunggulan Kami</span>
            <h3 class="text-3xl font-extrabold text-gray-900 mt-1">Komitmen Pada Kualitas</h3>
            <p class="text-gray-500 text-sm mt-2">Menghadirkan solusi MEP & HVAC terbaik dengan standar kualitas tinggi</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <h4 class="font-bold text-gray-900 mb-1 text-sm">Keahlian</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Tim profesional dengan pengalaman luas di bidang MEP & HVAC.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <h4 class="font-bold text-gray-900 mb-1 text-sm">Kualitas</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Standar kerja tinggi dengan hasil yang terjamin.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <h4 class="font-bold text-gray-900 mb-1 text-sm">Pelayanan</h4>
                <p class="text-gray-500 text-xs leading-relaxed">Dukungan teknis dan pemeliharaan berkelanjutan.</p>
            </div>
        </div>
    </section>

    <!-- Proses Layanan -->
    <section class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Cara Kerja Kami</span>
            <h3 class="text-3xl font-extrabold text-gray-900 mt-1">Proses Layanan</h3>
            <p class="text-gray-500 text-sm mt-2">Pendekatan sistematis untuk setiap proyek MEP & HVAC</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <span class="text-blue-600 font-bold text-sm">01 .</span>
                <h4 class="font-bold text-gray-900 mt-2 mb-1 text-sm">Konsultasi</h4>
                <p class="text-gray-500 text-xs">Analisis kebutuhan dan perencanaan sistem.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <span class="text-blue-600 font-bold text-sm">02 .</span>
                <h4 class="font-bold text-gray-900 mt-2 mb-1 text-sm">Desain</h4>
                <p class="text-gray-500 text-xs">Perencanaan teknis dan engineering.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <span class="text-blue-600 font-bold text-sm">03 .</span>
                <h4 class="font-bold text-gray-900 mt-2 mb-1 text-sm">Instalasi</h4>
                <p class="text-gray-500 text-xs">Implementasi oleh tim ahli.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <span class="text-blue-600 font-bold text-sm">04 .</span>
                <h4 class="font-bold text-gray-900 mt-2 mb-1 text-sm">Maintenance</h4>
                <p class="text-gray-500 text-xs">Pemeliharaan dan dukungan sistem.</p>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>