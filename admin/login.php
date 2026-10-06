<?php
session_start();
include '../koneksi.php';
if (!isset($koneksi) && isset($conn)) { $koneksi = $conn; }

$error = '';

// Proses saat tombol Masuk ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $query = mysqli_query($koneksi, "SELECT * FROM admins WHERE username = '$username'");
    if ($query && mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);
        
        if (password_verify($password, $admin['password']) || md5($password) == $admin['password'] || $password == $admin['password']) {
            $_SESSION['admin_logged'] = true;
            $_SESSION['admin_user'] = $admin['username'];
            $_SESSION['login_time'] = date('d-m-Y H:i');

            // Simpan Username dan Password ke Cookie selama 30 hari jika dicentang
            if ($remember) {
                setcookie('saved_username', $username, time() + (86400 * 30), "/");
                setcookie('saved_password', $password, time() + (86400 * 30), "/");
            } else {
                // Hapus cookie jika tidak dicentang
                setcookie('saved_username', '', time() - 3600, "/");
                setcookie('saved_password', '', time() - 3600, "/");
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}

// Ambil nilai cookie jika sebelumnya pernah disimpan
$cookie_username = isset($_COOKIE['saved_username']) ? $_COOKIE['saved_username'] : '';
$cookie_password = isset($_COOKIE['saved_password']) ? $_COOKIE['saved_password'] : '';
$is_checked = !empty($cookie_username) ? 'checked' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Suralaya Teknik</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Konsistensi 1 Jenis Font -->
    <style>
        body, button, input, select, textarea, th, td, label {
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4 sm:px-6">

    <!-- Container Responsif (Lebar menyesuaikan layar HP & Padding adaptif) -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-gray-100 w-full max-w-md my-6">
        
        <!-- Header Form -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Admin Panel</h1>
            <p class="text-xs text-gray-500 mt-1">Suralaya Teknik - Masuk untuk mengelola sistem</p>
        </div>

        <!-- Notifikasi Error jika ada -->
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-xs font-semibold text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($cookie_username); ?>" placeholder="Masukkan username admin" required autocomplete="username" class="w-full p-3 border border-gray-300 rounded-xl text-xs bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" value="<?= htmlspecialchars($cookie_password); ?>" placeholder="Masukkan password" required autocomplete="current-password" class="w-full p-3 pr-10 border border-gray-300 rounded-xl text-xs bg-white focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                        <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Checkbox Ingat Saya -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-gray-600">
                    <input type="checkbox" name="remember" <?= $is_checked; ?> class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                    <span>Ingat username & password saya</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition shadow-md shadow-blue-500/20 mt-2">
                Masuk
            </button>
        </form>

        <!-- Kembali ke Beranda -->
        <div class="text-center mt-6">
            <a href="../index.php" class="text-xs text-gray-500 hover:text-blue-600 transition font-medium">← Kembali ke Beranda Website</a>
        </div>

    </div>

    <!-- Skrip JavaScript untuk Toggle Show/Hide Password -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>

</body>
</html>