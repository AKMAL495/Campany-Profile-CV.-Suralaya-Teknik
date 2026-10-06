<?php
include 'koneksi.php';
$status = '';

// Cek apakah ada parameter sukses di URL (hasil dari redirect)
if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
    $status = "Pesan berhasil dikirim!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "INSERT INTO contact_messages (nama, email, telepon, pesan) VALUES ('$nama', '$email', '$telepon', '$pesan')";
    if (mysqli_query($conn, $query)) {
        // Redirect agar saat halaman direfresh data tidak terkirim ulang
        header("Location: kontak.php?status=sukses");
        exit;
    } else {
        $status = "Gagal mengirim pesan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Suralaya Teknik</title>
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

    <!-- Konten Kontak dengan Animasi Masuk -->
    <main class="max-w-5xl mx-auto px-6 py-16 animate-slide-up">
        <div class="text-center mb-12">
            <h3 class="text-2xl font-extrabold text-gray-900">Mari Terhubung</h3>
            <p class="text-gray-500 text-sm mt-1">Kami siap membantu menjawab pertanyaan Anda. Hubungi kami melalui saluran cepat di bawah ini atau kirimkan pesan.</p>
        </div>

        <?php if($status): ?>
            <div id="notifBox" class="mb-8 p-4 bg-emerald-50 text-emerald-700 rounded-xl text-center text-sm font-medium border border-emerald-100 shadow-sm transition-all duration-500">
                <?= $status; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 mb-16">
            <div class="space-y-6">
                <div>
                    <strong class="block text-gray-900 font-semibold mb-1 text-sm">Alamat Kantor</strong>
                    <p class="text-gray-600 text-xs leading-relaxed">
                        Jl. By Pass Ketaping No. 16B<br>
                        RT. 05/RW. 06, Kel. Pasar Ambacang<br>
                        Kec. Kuranji, Kota Padang
                    </p>
                </div>

                <div>
                    <strong class="block text-gray-900 font-semibold mb-1 text-sm">Jam Kerja</strong>
                    <p class="text-gray-600 text-xs">Senin - Sabtu: 09:00 - 17:00<br>Minggu: Tutup</p>
                </div>

                <!-- Tombol Cepat WhatsApp -->
                <div>
                    <strong class="block text-gray-900 font-semibold mb-1 text-sm">WhatsApp / Telepon</strong>
                    <p class="text-gray-600 text-xs mb-2">+62 822-8597-5488</p>
                    <a href="https://api.whatsapp.com/send?phone=6282285975488&text=Halo%20CV.%20Suralaya%20Teknik,%20saya%20ingin%20berkonsultasi%20mengenai..." 
                       target="_blank" 
                       class="inline-flex items-center space-x-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        <span>💬 Chat WhatsApp Langsung</span>
                    </a>
                </div>

                <!-- Tombol Cepat Email -->
                <div>
                    <strong class="block text-gray-900 font-semibold mb-1 text-sm">Email Resmi</strong>
                    <p class="text-gray-600 text-xs mb-2">cv.suralayateknik@yahoo.co.id</p>
                    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=cv.suralayateknik@yahoo.co.id&su=Konsultasi%20Layanan%20CV.%20Suralaya%20Teknik&body=Halo%20CV.%20Suralaya%20Teknik,%0D%0A%0D%0ASaya%20ingin%20berkonsultasi%20mengenai..." 
                       target="_blank" 
                       class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-xs font-semibold shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                        <span>✉️ Kirim Email Langsung</span>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-gray-900 text-lg mb-4">Kirim Pesan</h3>
                <form action="" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nama</label>
                        <input type="text" name="nama" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" name="telepon" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Pesan</label>
                        <textarea name="pesan" rows="4" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl font-semibold text-sm shadow hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // Jika URL mengandung ?status=sukses, bersihkan URL secara otomatis tanpa mereload halaman
        // sehingga jika halaman di-refresh lagi, notifikasinya sudah hilang kembali seperti semula.
        if (window.history.replaceState && window.location.search.includes('status=sukses')) {
            const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
            window.history.replaceState({path: cleanUrl}, '', cleanUrl);
        }
    </script>
</body>
</html>