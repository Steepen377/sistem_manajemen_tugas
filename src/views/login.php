<?php
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Contoh validasi sederhana
        if ($password === $confirm_password) {
            // Simpan data pengguna baru ke database atau sesi (contoh sederhana)
            $_SESSION['registered_user'] = [
                'username' => $username,
                'email' => $email,
                'password' => $password
            ];
            $success = 'Pendaftaran berhasil! Silakan masuk dengan akun baru Anda.';
        } else {
            $error = 'Kata sandi dan konfirmasi kata sandi tidak cocok.';
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Contoh validasi sederhana
        if (isset($_SESSION['registered_user']) && $_SESSION['registered_user']['username'] === $username && $_SESSION['registered_user']['password'] === $password) {
            $_SESSION['loggedin'] = true;
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMWB - Manajemen Waktu Belajar</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms@0.5.7,typography@0.5.13,aspect-ratio@0.4.2,container-queries@0.1.1"></script>
    <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#000000" data-border-radius="small"></script>
</head>
<body class="min-h-screen bg-gray-50 font-[Poppins]">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white shadow">
            <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold">SMWB</span>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center gap-4">
                        <a href="#" class="text-gray-600 hover:text-custom" onclick="showLoginForm()">Masuk</a>
                        <a href="#" class="bg-custom text-white px-4 py-2 !rounded-button" onclick="showRegistrationForm()">Daftar</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg">
                <div id="loginForm" class="space-y-6">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900">Selamat Datang Kembali</h2>
                        <p class="mt-2 text-sm text-gray-600">Masuk untuk melanjutkan belajar</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php" class="space-y-4">
                        <input type="hidden" name="login" value="1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="username" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom focus:border-custom" placeholder="Masukkan username Anda" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" name="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-custom focus:border-custom" placeholder="Masukkan kata sandi" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-custom border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                            </div>
                            <a href="#" class="text-sm font-medium text-custom hover:text-custom-dark">Lupa kata sandi?</a>
                        </div>

                        <button type="submit" class="w-full bg-custom text-white py-2 px-4 !rounded-button hover:bg-custom-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                            Masuk
                        </button>
                    </form>

                    <p class="text-center text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="#" class="font-medium text-custom hover:text-custom-dark" onclick="showRegistrationForm()">Daftar sekarang</a>
                    </p>
                </div>

                <div id="registrationForm" class="hidden space-y-6">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
                        <p class="mt-2 text-sm text-gray-600">Isi formulir di bawah untuk membuat akun baru</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="login.php" class="space-y-4">
                        <input type="hidden" name="register" value="1">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-custom focus:border-custom" placeholder="Pilih username Anda" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-custom focus:border-custom" placeholder="Masukkan email Anda" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                            <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-custom focus:border-custom" placeholder="Buat kata sandi" required>
                            <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter dengan huruf, angka, dan simbol</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi</label>
                            <input type="password" name="confirm_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-custom focus:border-custom" placeholder="Konfirmasi kata sandi" required>
                        </div>

                        <button type="submit" class="w-full bg-custom text-white py-2 px-4 !rounded-button hover:bg-custom-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom">
                            Daftar
                        </button>
                    </form>

                    <p class="text-center text-sm text-gray-600">
                        Sudah punya akun? 
                        <a href="#" class="font-medium text-custom hover:text-custom-dark" onclick="showLoginForm()">Masuk</a>
                    </p>
                </div>
            </div>
        </div>

        <footer class="bg-white">
            <div class="max-w-8xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-500">
                    © 2024 SMWB. Hak Cipta Dilindungi.
                </p>
            </div>
        </footer>
    </div>
    <script>
        function showLoginForm() {
            document.getElementById('loginForm').classList.remove('hidden');
            document.getElementById('registrationForm').classList.add('hidden');
        }

        function showRegistrationForm() {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registrationForm').classList.remove('hidden');
        }
    </script>
</body>
</html>