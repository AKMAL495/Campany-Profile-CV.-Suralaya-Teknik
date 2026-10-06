<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: login.php");
    exit;
}

// Proses Hapus Pesan
if (isset($_GET['hapus'])) {
    $id_pesan = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM contact_messages WHERE id = '$id_pesan'");
    header("Location: dashboard.php?tab=pesan");
    exit;
}

// Proses Otomatis Tandai Sudah Dibaca saat baris diklik / dipanggil via AJAX
if (isset($_GET['baca_id'])) {
    $id_baca = mysqli_real_escape_string($koneksi, $_GET['baca_id']);
    mysqli_query($koneksi, "UPDATE contact_messages SET status = 'sudah_dibaca' WHERE id = '$id_baca'");
    header("Location: dashboard.php?tab=pesan");
    exit;
}

if (isset($_GET['hapus_katalog'])) {
    $id_kat = mysqli_real_escape_string($koneksi, $_GET['hapus_katalog']);
    $q_img = mysqli_query($koneksi, "SELECT gambar FROM katalog WHERE id = '$id_kat'");
    if ($q_img && mysqli_num_rows($q_img) > 0) {
        $d_img = mysqli_fetch_assoc($q_img);
        if (!empty($d_img['gambar']) && file_exists('../assets/uploads/katalog/' . $d_img['gambar'])) {
            unlink('../assets/uploads/katalog/' . $d_img['gambar']);
        }
    }
    mysqli_query($koneksi, "DELETE FROM katalog WHERE id = '$id_kat'");
    header("Location: dashboard.php?tab=katalog");
    exit;
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'pesan';

// Hitung jumlah pesan yang belum dibaca untuk badge notifikasi
$q_unread = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM contact_messages WHERE status = 'belum_dibaca'");
$d_unread = mysqli_fetch_assoc($q_unread);
$jumlah_unread = $d_unread['total'] ?? 0;

// URUTAN PESAN: Yang belum dibaca di atas, lalu diikuti ID terbaru
$pesan_list = mysqli_query($koneksi, "SELECT * FROM contact_messages ORDER BY (status = 'belum_dibaca') DESC, id DESC");
$katalog_list = mysqli_query($koneksi, "SELECT * FROM katalog ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Suralaya Teknik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, button, input, select, textarea, th, td {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-4 md:p-10 md:ml-64 overflow-y-auto">
        <div class="max-w-6xl mx-auto">
            
            <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="md:hidden bg-white p-2.5 rounded-xl border border-gray-200 text-gray-700 shadow-sm focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl md:text-2xl font-bold text-gray-900">
                            <?= ($active_tab == 'katalog') ? 'Kelola Katalog Barang & Jasa' : 'Pesan Masuk Pelanggan'; ?>
                        </h1>
                        <p class="text-xs md:text-sm text-gray-500">
                            <?= ($active_tab == 'katalog') ? 'Tambah, edit, atau hapus produk dan layanan website.' : 'Klik pada baris pesan untuk melihat detail pesan.'; ?>
                        </p>
                    </div>
                </div>
                
                <div class="bg-white border border-gray-100 shadow-sm px-4 py-3 rounded-2xl flex items-center space-x-3 self-start md:self-auto">
                    <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Sesi Aktif</p>
                        <p class="text-xs font-bold text-gray-800 uppercase">
                            <?= htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?>
                        </p>
                    </div>
                </div>
            </header>

            <!-- NOTIFIKASI -->
            <?php if (isset($_GET['pesan'])): ?>
                <?php if ($_GET['pesan'] == 'berhasil_tambah_katalog'): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-xs font-semibold">✅ Item katalog baru berhasil ditambahkan!</div>
                <?php elseif ($_GET['pesan'] == 'berhasil_edit_katalog'): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-xs font-semibold">✅ Item katalog berhasil diperbarui!</div>
                <?php elseif ($_GET['pesan'] == 'gagal_tambah_katalog' || $_GET['pesan'] == 'gagal_edit_katalog'): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 text-xs font-semibold">❌ Terjadi kesalahan pada proses data katalog.</div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($active_tab == 'katalog'): ?>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-2">Tambah Item Katalog Baru</h2>
                    <p class="text-xs text-gray-500 mb-6">Barang atau Jasa yang ditambahkan akan langsung tampil di halaman katalog website.</p>
                    
                    <form action="tambah_katalog.php" method="POST" enctype="multipart/form-data" class="bg-gray-50 p-4 md:p-6 rounded-2xl border border-gray-200 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            
                            <!-- Kategori Utama -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Utama</label>
                                <select name="kategori" id="kategoriSelect" onchange="toggleKatalogOptions()" required class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    <option value="Barang / Unit">Barang / Unit</option>
                                    <option value="Jasa">Jasa</option>
                                </select>
                            </div>

                            <!-- Nama Produk / Layanan -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">Nama Produk / Layanan</label>
                                <input type="text" name="nama" placeholder="Contoh: AC Standard 1 PK / Jasa Servis" required autocomplete="off" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                            </div>

                            <!-- Opsi Khusus Barang / Unit -->
                            <div id="unitOptionsContainer" class="md:col-span-2 grid grid-cols-1 md:grid-cols-4 gap-4 hidden bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                                <!-- Pilih Perangkat -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Perangkat</label>
                                    <select name="kategori_elektronik" id="kategoriElektronikSelect" onchange="updatePerangkatOptions()" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                        <option value="" disabled selected>-- Pilih Perangkat --</option>
                                        <option value="AC">AC (Air Conditioner)</option>
                                        <option value="Kipas">Kipas Angin</option>
                                        <option value="Kulkas">Kulkas / Refrigerator</option>
                                        <option value="Mesin Cuci">Mesin Cuci</option>
                                    </select>
                                </div>

                                <!-- Merek -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Merek</label>
                                    <select name="merek" id="merekSelect" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                        <option value="" disabled selected>-- Pilih Perangkat Dulu --</option>
                                    </select>
                                </div>

                                <!-- Sub-Jenis / Kategori Khusus AC -->
                                <div id="acJenisContainer">
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Sistem AC</label>
                                    <select name="jenis_ac" id="jenisAcSelect" onchange="updateTipeAcOptions()" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                        <option value="" disabled selected>-- Pilih Sistem --</option>
                                        <option value="AC Single">AC Single</option>
                                        <option value="AC VRV / VRF">AC VRV / VRF</option>
                                    </select>
                                </div>

                                <!-- Tipe / Model -->
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 mb-1">Tipe / Model</label>
                                    <select name="tipe_ac" id="tipeAcSelect" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                        <option value="" disabled selected>-- Pilih Perangkat Dulu --</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                                <textarea name="deskripsi" rows="3" placeholder="Jelaskan spesifikasi unit atau ruang lingkup layanan..." required class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs"></textarea>
                            </div>

                            <!-- Foto -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 mb-1">Foto Produk / Layanan</label>
                                <input type="file" name="gambar" accept="image/*" required class="w-full p-2 border border-gray-300 rounded-xl bg-white text-xs">
                            </div>
                        </div>

                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm">Tambah ke Katalog ➕</button>
                    </form>

                    <h3 class="text-sm font-bold text-gray-900 mb-4">📋 Daftar Katalog Saat Ini</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs min-w-[700px]">
                            <thead>
                                <tr class="border-b border-gray-100 text-gray-400">
                                    <th class="py-3 px-4 w-12">No</th>
                                    <th class="py-3 px-4 w-20">Foto</th>
                                    <th class="py-3 px-4 w-40">Kategori & Detail</th>
                                    <th class="py-3 px-4">Nama</th>
                                    <th class="py-3 px-4">Deskripsi</th>
                                    <th class="py-3 px-4 text-center w-36">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if ($katalog_list && mysqli_num_rows($katalog_list) > 0): ?>
                                    <?php $no_k = 1; while($kat = mysqli_fetch_assoc($katalog_list)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-4 px-4 text-gray-400"><?= $no_k++; ?></td>
                                            <td class="py-4 px-4">
                                                <?php if(!empty($kat['gambar']) && file_exists('../assets/uploads/katalog/' . $kat['gambar'])): ?>
                                                    <img src="../assets/uploads/katalog/<?= $kat['gambar']; ?>" class="w-12 h-12 object-cover rounded-xl border border-gray-200" alt="Foto">
                                                <?php else: ?>
                                                    <span class="text-gray-400 italic text-[10px]">Tanpa Foto</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4">
                                                <span class="font-bold text-blue-600 block"><?= htmlspecialchars($kat['kategori']); ?></span>
                                                <?php if(!empty($kat['kategori_elektronik'])): ?>
                                                    <span class="text-[11px] text-gray-700 font-semibold block">Perangkat: <?= htmlspecialchars($kat['kategori_elektronik']); ?></span>
                                                    <span class="text-[11px] text-gray-500 block">Merek: <b><?= htmlspecialchars($kat['merek']); ?></b></span>
                                                    <?php if(!empty($kat['tipe_ac'])): ?>
                                                        <span class="text-[10px] text-gray-400 block"><?= htmlspecialchars($kat['tipe_ac']); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-4 px-4 font-bold text-gray-900"><?= htmlspecialchars($kat['nama']); ?></td>
                                            <td class="py-4 px-4 text-gray-600 max-w-xs truncate"><?= htmlspecialchars($kat['deskripsi']); ?></td>
                                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                                <div class="inline-flex items-center space-x-1.5">
                                                    <a href="edit_katalog.php?id=<?= $kat['id']; ?>" class="bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold px-3 py-1.5 rounded-xl transition">Edit</a>
                                                    <a href="dashboard.php?hapus_katalog=<?= $kat['id']; ?>&tab=katalog" onclick="return confirm('Yakin ingin menghapus item ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-3 py-1.5 rounded-xl transition">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada item katalog.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6 overflow-x-auto">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-gray-900">Daftar Pesan Masuk dari Kontak Website</h2>
                        <?php if ($jumlah_unread > 0): ?>
                            <span class="bg-blue-50 text-blue-600 font-semibold px-3 py-1 rounded-xl text-xs">
                                Ada <b><?= $jumlah_unread; ?></b> pesan baru belum dibaca
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <table class="w-full text-left border-collapse text-xs min-w-[700px]">
                        <thead>
                            <tr class="border-b border-gray-100 text-gray-400">
                                <th class="py-3 px-4 w-16 text-center">Status</th>
                                <th class="py-3 px-4">Waktu</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Kontak</th>
                                <th class="py-3 px-4">Pesan Singkat</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php if ($pesan_list && mysqli_num_rows($pesan_list) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($pesan_list)): 
                                    $is_unread = (isset($row['status']) && $row['status'] == 'belum_dibaca');
                                ?>
                                    <!-- Baris Tabel Diklik untuk Membuka Popup Sekaligus Ubah Status Menjadi Dibaca -->
                                    <tr onclick="bukaModal(
                                            '<?= $row['id']; ?>',
                                            '<?= htmlspecialchars($row['nama'], ENT_QUOTES); ?>',
                                            '<?= htmlspecialchars($row['email'], ENT_QUOTES); ?>',
                                            '<?= htmlspecialchars($row['telepon'], ENT_QUOTES); ?>',
                                            '<?= htmlspecialchars($row['created_at'], ENT_QUOTES); ?>',
                                            '<?= htmlspecialchars(str_replace(["\r", "\n"], ' ', $row['pesan']), ENT_QUOTES); ?>',
                                            '<?= $row['status']; ?>'
                                        )" 
                                        class="hover:bg-blue-50/60 cursor-pointer transition <?= $is_unread ? 'bg-blue-50/40 font-medium' : ''; ?>">
                                        <td class="py-4 px-4 text-center">
                                            <?php if ($is_unread): ?>
                                                <span class="inline-block w-2.5 h-2.5 bg-blue-600 rounded-full animate-ping" title="Belum Dibaca"></span>
                                                <span class="text-[10px] bg-blue-100 text-blue-700 font-bold px-2 py-0.5 rounded-full ml-1">Baru</span>
                                            <?php else: ?>
                                                <span class="text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Dibaca</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-4 text-gray-400 whitespace-nowrap"><?= isset($row['created_at']) ? $row['created_at'] : '-'; ?></td>
                                        <td class="py-4 px-4 font-bold text-gray-900 whitespace-nowrap"><?= htmlspecialchars($row['nama']); ?></td>
                                        <td class="py-4 px-4 text-gray-600">
                                            <div><?= htmlspecialchars($row['email']); ?></div>
                                            <div class="text-gray-400"><?= htmlspecialchars($row['telepon']); ?></div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-600 max-w-xs truncate"><?= htmlspecialchars($row['pesan']); ?></td>
                                        <td class="py-4 px-4 text-center whitespace-nowrap space-x-1" onclick="event.stopPropagation();">
                                            <a href="dashboard.php?hapus=<?= $row['id']; ?>" onclick="return confirm('Hapus pesan ini?')" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-3 py-1.5 rounded-xl transition inline-block">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="py-8 text-center text-gray-400">Belum ada pesan masuk dari pelanggan.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

        </div>
    </main>

    <!-- POPUP MODAL DETAIL PESAN -->
    <div id="modalPesan" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-xl max-w-lg w-full p-6 relative transform transition-all">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <h3 class="text-base font-bold text-gray-900">Detail Pesan Masuk</h3>
                <button onclick="tutupModal()" class="text-gray-400 hover:text-gray-600 font-bold text-lg p-1">✕</button>
            </div>
            <div class="space-y-3 text-xs">
                <div>
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Waktu Kirim</p>
                    <p id="modalWaktu" class="text-gray-800 font-medium"></p>
                </div>
                <div>
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Nama Pengirim</p>
                    <p id="modalNama" class="text-gray-900 font-bold text-sm"></p>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Email</p>
                        <p id="modalEmail" class="text-gray-800 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px]">Telepon / WhatsApp</p>
                        <p id="modalTelepon" class="text-gray-800 font-medium"></p>
                    </div>
                </div>
                <div>
                    <p class="text-gray-400 font-semibold uppercase tracking-wider text-[10px] mb-1">Isi Pesan</p>
                    <div id="modalIsiPesan" class="p-3 bg-gray-50 rounded-2xl border border-gray-200 text-gray-700 whitespace-pre-wrap leading-relaxed"></div>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap items-center justify-between gap-2 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2">
                    <a id="btnBalasEmail" href="#" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3.5 py-2 rounded-xl text-xs transition shadow-sm inline-flex items-center gap-1.5">
                        ✉️ Balas via Email
                    </a>
                    <a id="btnBalasWa" href="#" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-3.5 py-2 rounded-xl text-xs transition shadow-sm inline-flex items-center gap-1.5">
                        💬 Balas via WhatsApp
                    </a>
                </div>
                <button onclick="tutupModalReload()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        // Minta izin Notifikasi Desktop Browser saat halaman pertama kali dibuka
        document.addEventListener("DOMContentLoaded", function () {
            if (window.Notification && Notification.permission !== "granted") {
                Notification.requestPermission();
            }

            // Cek pesan baru setiap 5 detik
            setInterval(cekPesanBaruRealtime, 5000);
        });

        function cekPesanBaruRealtime() {
            fetch('cek_pesan_baru.php')
                .then(response => response.json())
                .then(data => {
                    if (data.ada_pesan_baru) {
                        let notifiedId = localStorage.getItem('last_notified_pesan_id');

                        if (notifiedId !== String(data.id)) {
                            localStorage.setItem('last_notified_pesan_id', data.id);

                            if (window.Notification && Notification.permission === "granted") {
                                let notif = new Notification("Pesan Masuk Baru - Suralaya Teknik", {
                                    body: data.nama + ": " + data.pesan.substring(0, 80) + "...",
                                    icon: "../logo.png"
                                });

                                notif.onclick = function () {
                                    window.focus();
                                    window.location.href = "dashboard.php?tab=pesan";
                                };
                            }
                        }
                    }
                })
                .catch(error => console.error('Gagal mengecek pesan:', error));
        }

        function bukaModal(id, nama, email, telepon, waktu, pesan, status) {
            document.getElementById('modalNama').textContent = nama;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalTelepon').textContent = telepon;
            document.getElementById('modalWaktu').textContent = waktu;
            document.getElementById('modalIsiPesan').textContent = pesan;

            const subject = encodeURIComponent("Balasan dari Suralaya Teknik untuk " + nama);
            const body = encodeURIComponent("Halo " + nama + ",\n\nTerima kasih telah menghubungi Suralaya Teknik.\n\n");
            document.getElementById('btnBalasEmail').href = "mailto:" + email + "?subject=" + subject + "&body=" + body;

            let cleanPhone = telepon.replace(/\D/g, ''); 
            if (cleanPhone.startsWith('0')) {
                cleanPhone = '62' + cleanPhone.substring(1); 
            }
            const waMessage = encodeURIComponent("Halo " + nama + ", terima kasih telah menghubungi Suralaya Teknik. Terkait pesan Anda: \"" + pesan + "\", ...");
            document.getElementById('btnBalasWa').href = "https://wa.me/" + cleanPhone + "?text=" + waMessage;

            document.getElementById('modalPesan').classList.remove('hidden');

            if (status === 'belum_dibaca') {
                window.lastReadId = id;
            } else {
                window.lastReadId = null;
            }
        }

        function tutupModal() {
            document.getElementById('modalPesan').classList.add('hidden');
        }

        function tutupModalReload() {
            document.getElementById('modalPesan').classList.add('hidden');
            if (window.lastReadId) {
                window.location.href = 'dashboard.php?tab=pesan&baca_id=' + window.lastReadId;
            }
        }

        function toggleKatalogOptions() {
            const kategori = document.getElementById('kategoriSelect').value;
            const container = document.getElementById('unitOptionsContainer');
            const katElektronik = document.getElementById('kategoriElektronikSelect');
            const merekSelect = document.getElementById('merekSelect');
            const tipeAcSelect = document.getElementById('tipeAcSelect');

            if (kategori === 'Barang / Unit') {
                container.classList.remove('hidden');
                katElektronik.setAttribute('required', 'required');
                merekSelect.setAttribute('required', 'required');
                tipeAcSelect.setAttribute('required', 'required');
            } else {
                container.classList.add('hidden');
                katElektronik.removeAttribute('required');
                merekSelect.removeAttribute('required');
                tipeAcSelect.removeAttribute('required');
            }
        }

        function updatePerangkatOptions() {
            const perangkat = document.getElementById('kategoriElektronikSelect').value;
            const acContainer = document.getElementById('acJenisContainer');
            const jenisAcSelect = document.getElementById('jenisAcSelect');
            const merekSelect = document.getElementById('merekSelect');
            const tipeSelect = document.getElementById('tipeAcSelect');

            merekSelect.innerHTML = '<option value="" disabled selected>-- Pilih Merek --</option>';
            tipeSelect.innerHTML = '<option value="" disabled selected>-- Pilih Tipe --</option>';

            let merekOptions = [];
            let tipeOptions = [];

            if (perangkat === 'AC') {
                acContainer.classList.remove('hidden');
                jenisAcSelect.setAttribute('required', 'required');
                updateTipeAcOptions();
            } else {
                acContainer.classList.add('hidden');
                jenisAcSelect.removeAttribute('required');

                if (perangkat === 'Kipas') {
                    merekOptions = ['Maspion', 'KDK', 'Panasonic', 'Sekai', 'Miyako', 'CKE', 'Krisbow', 'Cosmos'];
                    tipeOptions = ['Kipas Dinding (Wall Fan)', 'Kipas Berdiri (Stand Fan)', 'Kipas Meja (Desk Fan)', 'Kipas Plafon (Ceiling Fan)', 'Exhaust Fan'];
                } else if (perangkat === 'Kulkas') {
                    merekOptions = ['Samsung', 'LG', 'Sharp', 'Polytron', 'Panasonic', 'Toshiba', 'AQUA', 'Hitachi'];
                    tipeOptions = ['Kulkas 1 Pintu', 'Kulkas 2 Pintu', 'Kulkas Side by Side', 'Kulkas Inverter'];
                } else if (perangkat === 'Mesin Cuci') {
                    merekOptions = ['Sharp', 'Polytron', 'Samsung', 'LG', 'Panasonic', 'AQUA', 'Midea'];
                    tipeOptions = ['Mesin Cuci 1 Tabung (Top Loading)', 'Mesin Cuci 1 Tabung (Front Loading)', 'Mesin Cuci 2 Tabung (Twin Tub)'];
                }

                merekOptions.forEach(m => {
                    let el = document.createElement('option');
                    el.value = m;
                    el.textContent = m;
                    merekSelect.appendChild(el);
                });

                tipeOptions.forEach(opt => {
                    let el = document.createElement('option');
                    el.value = opt;
                    el.textContent = opt;
                    tipeSelect.appendChild(el);
                });
            }
        }

        function updateTipeAcOptions() {
            const jenis = document.getElementById('jenisAcSelect').value;
            const merekSelect = document.getElementById('merekSelect');
            const tipeSelect = document.getElementById('tipeAcSelect');
            
            let merekOptions = ['Daikin', 'Samsung', 'Panasonic', 'Midea', 'Sharp', 'LG', 'Changhong', 'Gree', 'Mitsubishi', 'Polytron', 'Toshiba', 'F-Life'];
            
            merekSelect.innerHTML = '<option value="" disabled selected>-- Pilih Merek --</option>';
            merekOptions.forEach(m => {
                let el = document.createElement('option');
                el.value = m;
                el.textContent = m;
                merekSelect.appendChild(el);
            });

            tipeSelect.innerHTML = '<option value="" disabled selected>-- Pilih Tipe AC --</option>';

            let options = [];
            if (jenis === 'AC Single') {
                options = ['AC Wall Mounted', 'AC Multi S', 'AC Cassette', 'AC Floor Standing', 'AC Split Duct'];
            } else if (jenis === 'AC VRV / VRF') {
                options = ['AC Wall Mounted', 'AC Cassette', 'AC Split Duct'];
            }

            options.forEach(opt => {
                let el = document.createElement('option');
                el.value = opt;
                el.textContent = opt;
                tipeSelect.appendChild(el);
            });
        }
    </script>
</body>
</html>