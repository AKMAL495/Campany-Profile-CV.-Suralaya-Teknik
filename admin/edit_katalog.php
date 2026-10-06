<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$result = mysqli_query($koneksi, "SELECT * FROM katalog WHERE id = '$id'");
if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: dashboard.php?tab=katalog");
    exit;
}
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $kategori_elektronik = ($kategori == 'Barang / Unit' && isset($_POST['kategori_elektronik'])) ? mysqli_real_escape_string($koneksi, $_POST['kategori_elektronik']) : null;
    $merek = ($kategori == 'Barang / Unit' && isset($_POST['merek'])) ? mysqli_real_escape_string($koneksi, $_POST['merek']) : null;
    $jenis_ac = ($kategori == 'Barang / Unit' && isset($_POST['jenis_ac'])) ? mysqli_real_escape_string($koneksi, $_POST['jenis_ac']) : null;
    $tipe_ac = ($kategori == 'Barang / Unit' && isset($_POST['tipe_ac'])) ? mysqli_real_escape_string($koneksi, $_POST['tipe_ac']) : null;
    
    $nama_file_gambar = $data['gambar'];

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg', 'webp');
        $nama_file = $_FILES['gambar']['name'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $file_tmp = $_FILES['gambar']['tmp_name'];

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            $nama_file_gambar = uniqid() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $nama_file);
            
            if (!is_dir('../assets/uploads/katalog')) {
                mkdir('../assets/uploads/katalog', 0777, true);
            }
            
            if (!empty($data['gambar']) && file_exists('../assets/uploads/katalog/' . $data['gambar'])) {
                unlink('../assets/uploads/katalog/' . $data['gambar']);
            }

            move_uploaded_file($file_tmp, '../assets/uploads/katalog/' . $nama_file_gambar);
        }
    }

    $stmt = $koneksi->prepare("UPDATE katalog SET kategori = ?, nama = ?, deskripsi = ?, gambar = ?, kategori_elektronik = ?, merek = ?, jenis_ac = ?, tipe_ac = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $kategori, $nama, $deskripsi, $nama_file_gambar, $kategori_elektronik, $merek, $jenis_ac, $tipe_ac, $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?tab=katalog&pesan=berhasil_edit_katalog");
    } else {
        header("Location: dashboard.php?tab=katalog&pesan=gagal_edit_katalog");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Katalog - Admin Suralaya Teknik</title>
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
        <div class="max-w-4xl mx-auto">
            
            <header class="mb-8 flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden bg-white p-2.5 rounded-xl border border-gray-200 text-gray-700 shadow-sm focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">Edit Item Katalog</h1>
                    <p class="text-xs md:text-sm text-gray-500">Perbarui informasi produk atau layanan pada katalog website.</p>
                </div>
            </header>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 md:p-6">
                <form action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Kategori Utama</label>
                        <select name="kategori" id="kategoriSelect" onchange="toggleKatalogOptions()" required class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                            <option value="Barang / Unit" <?= ($data['kategori'] == 'Barang / Unit') ? 'selected' : ''; ?>>Barang / Unit</option>
                            <option value="Jasa" <?= ($data['kategori'] == 'Jasa') ? 'selected' : ''; ?>>Jasa</option>
                        </select>
                    </div>

                    <!-- Opsi Tambahan untuk Barang / Unit -->
                    <div id="unitOptionsContainer" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-blue-50/50 p-4 rounded-2xl border border-blue-100 <?= ($data['kategori'] == 'Barang / Unit') ? '' : 'hidden'; ?>">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Jenis Perangkat</label>
                            <select name="kategori_elektronik" id="kategoriElektronikSelect" onchange="updatePerangkatOptions()" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                <option value="AC" <?= ($data['kategori_elektronik'] == 'AC') ? 'selected' : ''; ?>>AC (Air Conditioner)</option>
                                <option value="Kipas" <?= ($data['kategori_elektronik'] == 'Kipas') ? 'selected' : ''; ?>>Kipas Angin</option>
                                <option value="Kulkas" <?= ($data['kategori_elektronik'] == 'Kulkas') ? 'selected' : ''; ?>>Kulkas / Refrigerator</option>
                                <option value="Mesin Cuci" <?= ($data['kategori_elektronik'] == 'Mesin Cuci') ? 'selected' : ''; ?>>Mesin Cuci</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Merek</label>
                            <select name="merek" id="merekSelect" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                <option value="<?= htmlspecialchars($data['merek']); ?>" selected><?= htmlspecialchars($data['merek']); ?></option>
                            </select>
                        </div>
                        <div id="acJenisContainer">
                            <label class="block text-xs font-bold text-gray-700 mb-1">Sistem AC</label>
                            <select name="jenis_ac" id="jenisAcSelect" onchange="updateTipeAcOptions()" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                <option value="AC Single" <?= ($data['jenis_ac'] == 'AC Single') ? 'selected' : ''; ?>>AC Single</option>
                                <option value="AC VRV / VRF" <?= ($data['jenis_ac'] == 'AC VRV / VRF') ? 'selected' : ''; ?>>AC VRV / VRF</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Tipe / Model</label>
                            <select name="tipe_ac" id="tipeAcSelect" class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                                <option value="<?= htmlspecialchars($data['tipe_ac']); ?>" selected><?= htmlspecialchars($data['tipe_ac']); ?></option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Nama Produk / Layanan</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="4" required class="w-full p-2.5 border border-gray-300 rounded-xl bg-white text-xs"><?= htmlspecialchars($data['deskripsi']); ?></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Foto Saat Ini</label>
                        <?php if (!empty($data['gambar']) && file_exists('../assets/uploads/katalog/' . $data['gambar'])): ?>
                            <div class="mb-2">
                                <img src="../assets/uploads/katalog/<?= $data['gambar']; ?>" class="w-20 h-20 object-cover rounded-xl border border-gray-200">
                            </div>
                        <?php else: ?>
                            <p class="text-xs text-gray-400 italic mb-2">Tidak ada foto.</p>
                        <?php endif; ?>
                        
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full p-2 border border-gray-300 rounded-xl bg-white text-xs">
                    </div>

                    <div class="flex items-center space-x-2 pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm">Simpan Perubahan</button>
                        <a href="dashboard.php?tab=katalog" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-5 py-2.5 rounded-xl text-xs transition">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <script>
        function toggleKatalogOptions() {
            const kategori = document.getElementById('kategoriSelect').value;
            const container = document.getElementById('unitOptionsContainer');
            if (kategori === 'Barang / Unit') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function updatePerangkatOptions() {
            const perangkat = document.getElementById('kategoriElektronikSelect').value;
            const acContainer = document.getElementById('acJenisContainer');
            const jenisAcSelect = document.getElementById('jenisAcSelect');
            const merekSelect = document.getElementById('merekSelect');
            const tipeSelect = document.getElementById('tipeAcSelect');

            merekSelect.innerHTML = '';
            tipeSelect.innerHTML = '';

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
            
            merekSelect.innerHTML = '';
            merekOptions.forEach(m => {
                let el = document.createElement('option');
                el.value = m;
                el.textContent = m;
                merekSelect.appendChild(el);
            });

            tipeSelect.innerHTML = '';

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

        // Inisialisasi awal saat edit page dimuat
        window.addEventListener('DOMContentLoaded', () => {
            const savedPerangkat = "<?= htmlspecialchars($data['kategori_elektronik'] ?? 'AC'); ?>";
            const savedMerek = "<?= htmlspecialchars($data['merek'] ?? ''); ?>";
            const savedTipe = "<?= htmlspecialchars($data['tipe_ac'] ?? ''); ?>";

            document.getElementById('kategoriElektronikSelect').value = savedPerangkat;
            updatePerangkatOptions();

            if (savedPerangkat === 'AC') {
                const savedJenis = "<?= htmlspecialchars($data['jenis_ac'] ?? 'AC Single'); ?>";
                document.getElementById('jenisAcSelect').value = savedJenis;
                updateTipeAcOptions();
            }

            // Pilih kembali Merek yang tersimpan
            const merekSelect = document.getElementById('merekSelect');
            for(let i=0; i<merekSelect.options.length; i++) {
                if(merekSelect.options[i].value === savedMerek) {
                    merekSelect.selectedIndex = i;
                    break;
                }
            }

            // Pilih kembali Tipe yang tersimpan
            const tipeSelect = document.getElementById('tipeAcSelect');
            for(let i=0; i<tipeSelect.options.length; i++) {
                if(tipeSelect.options[i].value === savedTipe) {
                    tipeSelect.selectedIndex = i;
                    break;
                }
            }
        });
    </script>
</body>
</html>