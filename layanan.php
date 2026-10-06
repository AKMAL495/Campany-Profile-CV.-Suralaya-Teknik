<?php
include 'koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - Suralaya Teknik</title>
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

    <!-- Navbar -->
    <?php include 'header.php'; ?>

    <!-- Daftar Layanan Utama & Detail -->
    <section class="max-w-7xl mx-auto px-6 py-16 animate-slide-up">
        
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Layanan Profesional Kami</span>
            <h2 class="text-3xl font-extrabold text-gray-900 mt-1">Bidang Keahlian MEP & HVAC</h2>
            <p class="text-gray-500 text-sm mt-1">Solusi komprehensif dan terintegrasi untuk kebutuhan gedung dan industri Anda</p>
        </div>

        <!-- Grid Layanan Utama dengan Penjelasan Rinci & Tombol Interaktif -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            
            <!-- Mekanikal -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-xl mb-6 shadow-inner">⚙️</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Mekanikal</h3>
                    <p class="text-gray-500 text-xs mb-6 leading-relaxed">Layanan komprehensif untuk sistem mekanikal dengan standar kualitas tertinggi.</p>
                    
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan dan perawatan sistem pemadam kebakaran (hydrant & sprinkler):</strong> Penyiapan jaringan pipa, pompa, dan katup otomatis untuk mengalirkan air bertekanan tinggi saat terjadi kebakaran.</div>
                        </li>
                    </ul>

                    <!-- Konten yang disembunyikan awalnya -->
                    <div id="more-mekanikal" class="hidden mt-3 space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pengadaan dan instalasi generator set (genset):</strong> Penyediaan dan pemasangan mesin pendorong listrik cadangan agar pasokan daya tetap aman saat listrik utama mati.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan sistem pompa industri dan transfer air:</strong> Instalasi pompa khusus untuk mendistribusikan air atau cairan lain dalam skala besar sesuai kebutuhan operasional.</div>
                        </li>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="toggleDetails('mekanikal')" id="btn-mekanikal" class="text-blue-600 hover:text-blue-700 font-semibold text-xs flex items-center gap-1 focus:outline-none transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Elektrikal -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-xl mb-6 shadow-inner">⚡</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Elektrikal</h3>
                    <p class="text-gray-500 text-xs mb-6 leading-relaxed">Solusi sistem kelistrikan lengkap untuk berbagai kebutuhan gedung dan industri.</p>
                    
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan panel listrik utama (LVMDP/SDP):</strong> Perakitan dan instalasi kotak pusat distribusi arus listrik sebelum disalurkan ke seluruh area gedung.</div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Penarikan kabel distribusi daya (feeder):</strong> Pemasangan jalur kabel berkapasitas besar untuk menyalurkan energi listrik dari panel utama ke sub-panel.</div>
                        </li>
                    </ul>

                    <!-- Konten yang disembunyikan awalnya -->
                    <div id="more-elektrikal" class="hidden mt-3 space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Instalasi titik pencahayaan dan stop kontak:</strong> Pemasangan titik-titik lampu, sakelar, serta soket listrik untuk kebutuhan operasional harian.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan sistem penangkal petir dan pentanahan (grounding):</strong> Pemasangan jalur konduktor untuk mengalirkan lonjakan arus petir langsung ke dalam tanah demi keamanan.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Instalasi pasokan daya cadangan (UPS):</strong> Pemasangan baterai penyimpan daya untuk menjaga peralatan sensitif tetap menyala tanpa jeda saat terjadi mati listrik.</div>
                        </li>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="toggleDetails('elektrikal')" id="btn-elektrikal" class="text-blue-600 hover:text-blue-700 font-semibold text-xs flex items-center gap-1 focus:outline-none transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Plumbing -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-xl mb-6 shadow-inner">🚰</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Plumbing</h3>
                    <p class="text-gray-500 text-xs mb-6 leading-relaxed">Layanan sistem perpipaan dan sanitasi yang terintegrasi.</p>
                    
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan jaringan instalasi air bersih:</strong> Perancangan dan penyambungan jalur pipa untuk menyuplai air konsumsi dan kebutuhan harian gedung.</div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan saluran air kotor (greywater) dan limbah (blackwater):</strong> Pembuatan jalur pipa pembuangan terpisah untuk air sisa pakai dan limbah sanitasi.</div>
                        </li>
                    </ul>

                    <!-- Konten yang disembunyikan awalnya -->
                    <div id="more-plumbing" class="hidden mt-3 space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Instalasi peralatan sanitasi (wastafel, kloset, dan saluran drainage):</strong> Pemasangan perlengkapan kebersihan diri beserta saluran pembuangan air di area basah.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan sistem drainase air hujan:</strong> Pembuatan saluran pipa dan talang untuk mengalirkan air hujan dari atap ke area resapan atau saluran kota.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pembuatan dan perawatan sistem pengolahan limbah (STP/septic tank):</strong> Penyiapan unit pengolahan agar limbah cair aman dan memenuhi standar lingkungan sebelum dibuang.</div>
                        </li>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="toggleDetails('plumbing')" id="btn-plumbing" class="text-blue-600 hover:text-blue-700 font-semibold text-xs flex items-center gap-1 focus:outline-none transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- HVAC -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 text-xl mb-6 shadow-inner">❄️</div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">HVAC</h3>
                    <p class="text-gray-500 text-xs mb-6 leading-relaxed">Solusi pendingin udara dan pengkondisian udara untuk kenyamanan optimal.</p>
                    
                    <ul class="space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pemasangan sistem AC komersial dan industri (Chiller, VRV/VRF, AC Central):</strong> Pemasangan unit pendingin udara berskala besar untuk mendinginkan seluruh area gedung secara efisien.</div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pembuatan dan pemasangan saluran udara (ducting):</strong> Pembuatan jalur cerobong pipa plat metal untuk menyalurkan udara dingin ke tiap ruangan.</div>
                        </li>
                    </ul>

                    <!-- Konten yang disembunyikan awalnya -->
                    <div id="more-hvac" class="hidden mt-3 space-y-3 text-xs text-gray-600">
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Instalasi sistem ventilasi dan pengeluaran udara (exhaust fan):</strong> Pemasangan kipas penyedot untuk membuang udara kotor, bau, atau panas ke luar bangunan.</div>
                        </li>
                        <li class="flex items-start gap-2 list-none">
                            <span class="text-blue-600 font-bold">•</span>
                            <div><strong>Pengaturan dan kontrol kelembapan serta kualitas udara ruangan:</strong> Penyesuaian tingkat kelembapan dan penyaringan udara agar ruangan tetap sehat dan nyaman.</div>
                        </li>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="toggleDetails('hvac')" id="btn-hvac" class="text-blue-600 hover:text-blue-700 font-semibold text-xs flex items-center gap-1 focus:outline-none transition">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                </div>
            </div>

        </div>

        <!-- Proses Layanan dengan Penjelasan Rinci -->
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Cara Kami Bekerja</span>
            <h3 class="text-3xl font-extrabold text-gray-900 mt-1">Proses Layanan</h3>
            <p class="text-gray-500 text-sm mt-1">Pendekatan profesional dan terstruktur untuk setiap proyek MEP & HVAC</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
            
            <!-- Tahap 01: Konsultasi -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-blue-50 text-blue-600 font-extrabold rounded-xl flex items-center justify-center text-sm shadow-inner">01</span>
                    <h4 class="font-bold text-gray-900 text-base">Konsultasi</h4>
                </div>
                <p class="text-xs font-semibold text-blue-600 mb-2">Analisis kebutuhan dan perencanaan sistem.</p>
                <p class="text-xs text-gray-600 leading-relaxed">Tahap awal diskusi untuk memahami spesifikasi gedung, skala proyek, anggaran, serta kendala lapangan. Tim akan melakukan analisis awal guna merancang alur sistem yang paling tepat dan efisien.</p>
            </div>

            <!-- Tahap 02: Engineering -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-blue-50 text-blue-600 font-extrabold rounded-xl flex items-center justify-center text-sm shadow-inner">02</span>
                    <h4 class="font-bold text-gray-900 text-base">Engineering</h4>
                </div>
                <p class="text-xs font-semibold text-blue-600 mb-2">Perencanaan teknis dan desain.</p>
                <p class="text-xs text-gray-600 leading-relaxed">Pembuatan rancangan teknis secara mendalam, meliputi pembuatan gambar kerja (shop drawing), perhitungan kapasitas beban (listrik, pendingin, debit air), penetapan spesifikasi material, serta kalkulasi estimasi biaya (RAB).</p>
            </div>

            <!-- Tahap 03: Instalasi -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-blue-50 text-blue-600 font-extrabold rounded-xl flex items-center justify-center text-sm shadow-inner">03</span>
                    <h4 class="font-bold text-gray-900 text-base">Instalasi</h4>
                </div>
                <p class="text-xs font-semibold text-blue-600 mb-2">Implementasi oleh tim ahli.</p>
                <p class="text-xs text-gray-600 leading-relaxed">Eksekusi fisik di lapangan mulai dari pemasangan unit, perpipaan, pengkabelan, hingga perakitan sistem sesuai dengan desain engineering. Tahap ini diakhiri dengan proses pengujian fungsi (commissioning) untuk memastikan sistem beroperasi dengan aman.</p>
            </div>

            <!-- Tahap 04: Maintenance -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-10 h-10 bg-blue-50 text-blue-600 font-extrabold rounded-xl flex items-center justify-center text-sm shadow-inner">04</span>
                    <h4 class="font-bold text-gray-900 text-base">Maintenance</h4>
                </div>
                <p class="text-xs font-semibold text-blue-600 mb-2">Pemeliharaan dan dukungan sistem.</p>
                <p class="text-xs text-gray-600 leading-relaxed">Layanan purna jual yang mencakup perawatan berkala (preventive maintenance), perbaikan kerusakan, penggantian suku cadang, serta dukungan teknis darurat agar seluruh sistem tetap bekerja optimal dalam jangka panjang.</p>
            </div>

        </div>

        <!-- CTA Box -->
        <div class="bg-blue-600 rounded-3xl p-10 text-white text-center shadow-lg transition-transform duration-300 hover:scale-[1.01]">
            <h3 class="text-2xl font-bold mb-2">Butuh Solusi MEP & HVAC?</h3>
            <p class="text-blue-100 text-sm mb-6">Konsultasikan kebutuhan sistem MEP & HVAC Anda dengan tim ahli kami</p>
            <a href="kontak.php" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold text-sm shadow hover:bg-gray-100 transition inline-block">Hubungi Kami</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <!-- Skrip JavaScript untuk Tombol Baca Selengkapnya -->
    <script>
        function toggleDetails(type) {
            const moreContent = document.getElementById('more-' + type);
            const btn = document.getElementById('btn-' + type);
            const spanText = btn.querySelector('span');
            const iconSvg = btn.querySelector('svg');

            if (moreContent.classList.contains('hidden')) {
                moreContent.classList.remove('hidden');
                spanText.textContent = 'Tutup';
                iconSvg.style.transform = 'rotate(180deg)';
            } else {
                moreContent.classList.add('hidden');
                spanText.textContent = 'Baca Selengkapnya';
                iconSvg.style.transform = 'rotate(0deg)';
            }
        }
    </script>
</body>
</html>