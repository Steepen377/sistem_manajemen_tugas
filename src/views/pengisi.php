<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['subject'] = $_POST['subject'];
    $_SESSION['deadline'] = date('d/m/Y H:i', strtotime($_POST['time']));
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMWB - Pengisi Tugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://ai-public.creatie.ai/gen_page/tailwind-custom.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.5?plugins=forms@0.5.7,typography@0.5.13,aspect-ratio@0.4.2,container-queries@0.1.1"></script>
    <script src="https://ai-public.creatie.ai/gen_page/tailwind-config.min.js" data-color="#000000" data-border-radius="small"></script>
</head>
<body class="bg-gray-50 font-[Poppins]">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-sm">
            <nav class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-xl text-gray-900"></i>
                        <span class="ml-3 text-xl font-semibold text-gray-900">SMWB</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-700">Selamat datang, Steepen Istiawan</span>
                        <img src="">
                    </div>
                </div>
            </nav>
        </header>
        <main class="flex-1 max-w-8xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengisi Tugas</h2>
                <form action="pengisi.php" method="post">
                    <div class="mb-4">
                        <label for="subject" class="block text-sm font-medium text-gray-700">Pelajaran</label>
                        <select id="subject" name="subject" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-custom focus:border-custom sm:text-sm rounded-md">
                            <option>Matematika</option>
                            <option>Fisika</option>
                            <option>Kimia</option>
                            <option>Biologi</option>
                            <option>Bahasa Indonesia</option>
                            <option>Bahasa Inggris</option>
                            <option>Sejarah</option>
                            <option>Geografi</option>
                            <option>Ekonomi</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="time" class="block text-sm font-medium text-gray-700">Waktu</label>
                        <input type="datetime-local" id="time" name="time" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-custom focus:border-custom sm:text-sm rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="text-sm text-blue-500 hover:underline">Simpan</button>
                        <a href="index.php" class="ml-4 text-sm text-blue-500 hover:underline">Kembali ke Beranda</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>