<?php
include 'koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Suralaya Teknik</title>
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

    <!-- Navbar & Banner Otomatis -->
    <?php include 'header.php'; ?>

    <!-- Profil Perusahaan dengan Animasi Masuk -->
    <section class="max-w-4xl mx-auto px-6 py-16 animate-slide-up">
        <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Profil Perusahaan</span>
        <h3 class="text-3xl font-extrabold text-gray-900 mt-1 mb-6">Solusi MEP & HVAC Terpercaya</h3>
        
        <p class="text-gray-600 text-sm leading-relaxed mb-4">
            Kami adalah perusahaan terpercaya dalam solusi teknik Mekanikal, Elektrikal, Plumbing, dan HVAC. Kami menawarkan layanan konsultan yang komprehensif untuk membantu klien merancang, mengintegrasikan, dan memelihara sistem MEP dan HVAC yang efisien.
        </p>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            Dibekali dengan tenaga ahli yang berpengalaman dan pengetahuan mendalam mengenai industri, kami siap membantu perusahaan Anda mencapai tujuan operasional yang optimal dan menjaga kualitas lingkungan yang berkelanjutan.
        </p>

        <!-- Lokasi Kantor -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-10 space-y-2">
            <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wider text-blue-600">Lokasi Kantor</h4>
            <p class="text-gray-600 text-xs leading-relaxed flex items-start space-x-2">
                <span>📍</span> 
                <span>CV. Suralaya Teknik berkedudukan di Kota Padang, beralamat di Jl. By Pass Ketaping No. 16B, RT. 05/RW. 06, Kelurahan Pasar Ambacang, Kecamatan Kuranji</span>
            </p>
        </div>

        <!-- Visi Misi -->
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 space-y-8 mb-16">
            <div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Visi</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Menjadi perusahaan jasa pelaksana Instalasi Mekanikal, Elektrikal, Plumbing, dan HVAC yang berkualitas dan terpercaya yang menjamin kepuasan pengguna jasa, serta tanpa mengabaikan kemanfaatan bagi lingkungan sekitar.</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-base mb-4">Misi</h4>
                <div class="grid grid-cols-1 gap-3 text-xs md:text-sm">
                    <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl flex items-start space-x-3">
                        <span class="bg-blue-600 text-white font-bold w-6 h-6 rounded-xl flex items-center justify-center flex-shrink-0 text-xs">1</span>
                        <div>
                            <strong class="block text-gray-900 font-semibold mb-0.5">Kualitas & Keandalan Kerja</strong>
                            <p class="text-gray-600">Melaksanakan pekerjaan instalasi Mekanikal, Elektrikal, Plumbing, dan HVAC dengan standar mutu profesional yang teruji.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl flex items-start space-x-3">
                        <span class="bg-blue-600 text-white font-bold w-6 h-6 rounded-xl flex items-center justify-center flex-shrink-0 text-xs">2</span>
                        <div>
                            <strong class="block text-gray-900 font-semibold mb-0.5">Kepuasan Pengguna Jasa</strong>
                            <p class="text-gray-600">Mengutamakan ketepatan waktu dan komitmen penuh untuk menjamin kepuasan serta kepercayaan setiap klien.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl flex items-start space-x-3">
                        <span class="bg-blue-600 text-white font-bold w-6 h-6 rounded-xl flex items-center justify-center flex-shrink-0 text-xs">3</span>
                        <div>
                            <strong class="block text-gray-900 font-semibold mb-0.5">Kemitraan Strategis</strong>
                            <p class="text-gray-600">Menjalin hubungan kolaboratif dan berkelanjutan bersama pelanggan, pemasok, serta mitra bisnis.</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl flex items-start space-x-3">
                        <span class="bg-blue-600 text-white font-bold w-6 h-6 rounded-xl flex items-center justify-center flex-shrink-0 text-xs">4</span>
                        <div>
                            <strong class="block text-gray-900 font-semibold mb-0.5">Kepedulian Lingkungan</strong>
                            <p class="text-gray-600">Menghadirkan solusi teknik yang selaras dengan upaya menjaga kemanfaatan dan kelestarian lingkungan sekitar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi Sangat Responsif (1 Kolom di HP, 3 Kolom di Desktop) -->
        <div class="text-center mb-12">
            <span class="text-blue-600 text-xs font-semibold uppercase tracking-wider">Tim Kami</span>
            <h3 class="text-3xl font-extrabold text-gray-900 mt-1">Struktur Organisasi Perusahaan</h3>
            <p class="text-gray-500 text-sm mt-1">Tim profesional yang berdedikasi</p>
        </div>

        <div class="flex flex-col items-center py-6 w-full">
            
            <!-- LEVEL 1: Director -->
            <div class="bg-blue-600 text-white p-4 rounded-xl shadow w-72 text-center z-10">
                <div class="text-xs text-blue-200">Director</div>
                <div class="font-bold text-sm">SUROTO</div>
            </div>

            <!-- Garis Turun dari Director -->
            <div class="w-0.5 h-8 bg-blue-500"></div>

            <!-- LEVEL 2 CONTAINER -->
            <div class="relative w-full max-w-3xl pt-2 pb-2 flex flex-col items-center">
                <!-- Garis Horizontal Khusus Desktop -->
                <div class="absolute top-0 left-[23%] right-[23%] h-0.5 bg-blue-500 hidden md:block"></div>
                
                <div class="absolute top-0 left-[23%] w-0.5 h-6 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-0.5 h-6 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 right-[23%] w-0.5 h-6 bg-blue-500 hidden md:block"></div>

                <!-- Kotak Level 2 (1 Kolom di HP, 3 Kolom di Desktop) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 w-full pt-2 md:pt-4">
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 w-72 md:w-full mx-auto">
                        <div class="text-xs text-blue-200">Accountant</div>
                        <div class="font-bold text-xs">Reyhan Elparez, S.E</div>
                    </div>
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 relative w-72 md:w-full mx-auto">
                        <div class="text-xs text-blue-200">Site Manager</div>
                        <div class="font-bold text-xs">Samaun Akbar, S.T</div>
                        <!-- Garis Turun Desktop -->
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-0.5 h-12 bg-blue-500 hidden md:block"></div>
                    </div>
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 w-72 md:w-full mx-auto">
                        <div class="text-xs text-blue-200">Administration</div>
                        <div class="font-bold text-xs">Wahyu Chloriana, S.Pd</div>
                    </div>
                </div>
            </div>

            <!-- Garis Penghubung Khusus Mobile -->
            <div class="w-0.5 h-8 bg-blue-500 md:hidden my-2"></div>

            <!-- LEVEL 3 CONTAINER -->
            <div class="relative w-full max-w-3xl bg-blue-50/60 p-6 rounded-3xl border border-blue-100 mt-4 md:mt-12 flex flex-col items-center">
                <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-0.5 h-12 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 left-[23%] right-[23%] h-0.5 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 left-[23%] w-0.5 h-6 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-0.5 h-6 bg-blue-500 hidden md:block"></div>
                <div class="absolute top-0 right-[23%] w-0.5 h-6 bg-blue-500 hidden md:block"></div>

                <!-- Kotak Level 3 (1 Kolom di HP, 3 Kolom di Desktop) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 w-full pt-2 md:pt-4">
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 w-full mx-auto">
                        <div class="text-xs text-blue-200">Design Engineer</div>
                        <div class="font-bold text-xs">Galih Ramadhan, S.T</div>
                    </div>
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 relative w-full mx-auto">
                        <div class="text-xs text-blue-200">Engineering Administration</div>
                        <div class="font-bold text-xs">Maffiratul Ramadhan, A. Md. T</div>
                        <!-- Garis Turun Desktop ke Logistics -->
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-0.5 h-12 bg-blue-500 hidden md:block"></div>
                    </div>
                    <div class="bg-blue-600 text-white p-4 rounded-xl shadow text-center z-10 w-full mx-auto">
                        <div class="text-xs text-blue-200">Technical Person in Charge</div>
                        <div class="font-bold text-xs">Irfansyah, S.T</div>
                    </div>
                </div>
            </div>

            <!-- Garis Penghubung Khusus Mobile ke Logistics -->
            <div class="w-0.5 h-8 bg-blue-500 md:hidden my-2"></div>

            <!-- LEVEL 4: Logistics -->
            <div class="flex flex-col items-center mt-4 md:mt-12">
                <div class="bg-blue-600 text-white p-4 rounded-xl shadow w-72 text-center z-10">
                    <div class="text-xs text-blue-200">Logistics</div>
                    <div class="font-bold text-sm">Willy Arby, S.T</div>
                </div>
            </div>

        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>
</html>