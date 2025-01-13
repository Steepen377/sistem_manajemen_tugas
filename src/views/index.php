<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'autoload.php';

use App\TaskManager;

$error = '';
$tasks = [];

try {
    $tasks[] = new TaskManager("Task 1", 30, "High", "Work");
    $tasks[] = new TaskManager("Task 2", 45, "Medium", "Personal");
    $tasks[] = new TaskManager("Task 3", 15, "Low", "Chores");

    $tasks[0]->completeTask();
} catch (Exception $e) {
    $error = 'Error: ' . $e->getMessage();
}

$subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : 'Tugas Matematika';
$deadline = isset($_SESSION['deadline']) ? $_SESSION['deadline'] : 'Hari ini, 15:00';

$days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$today = $days[date('w')];
$jadwal = isset($_SESSION['jadwal']) ? $_SESSION['jadwal'] : [];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMWB - Beranda</title>
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
                        <span class="text-sm text-gray-700">Selamat datang, <?php echo htmlspecialchars($username); ?></span>
                        <img src="">
                    </div>
                </div>
            </nav>
        </header>
        <main class="flex-1 max-w-8xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-2 gap-6 mb-8">
                <a href="pengisi.php" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-custom/10 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-tasks text-custom text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Pengingat Tugas</span>
                    </div>
                </a>
                <a href="jadwal.php" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 bg-custom/10 rounded-full flex items-center justify-center mb-3">
                            <i class="fas fa-book-reader text-custom text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-900">Jadwal pelajaran</span>
                    </div>
                </a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Hari Ini (<?php echo $today; ?>)</h2>
                    <div class="space-y-4">
                        <?php if (isset($jadwal[$today])): ?>
                            <?php foreach ($jadwal[$today] as $item): ?>
                                <div class="flex items-start space-x-4">
                                    <div class="flex-none">
                                        <div class="bg-custom/10 text-custom rounded px-2 py-1 text-sm font-medium">
                                            <?php echo $item['time']; ?>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900"><?php echo $item['subject']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-sm text-gray-500">Tidak ada jadwal untuk hari ini.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Pengingat Aktif</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4 bg-yellow-50 p-3 rounded-lg">
                            <div class="flex-none">
                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i id="tugas-matematika-icon" class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900"><?php echo $subject; ?></p>
                                <p class="text-sm text-gray-500">Deadline: <?php echo $deadline; ?></p>
                                <p id="tugas-matematika-status" class="text-sm text-green-500 hidden">Tugas Selesai</p>
                            </div>
                            <div class="flex-none">
                                <button id="tugas-matematika-button" class="text-sm text-blue-500 hover:underline">Selesai</button>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 bg-blue-50 p-3 rounded-lg">
                            <div class="flex-none">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-book text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Ujian Fisika</p>
                                <p class="text-sm text-gray-500">Besok, 08:00</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 bg-green-50 p-3 rounded-lg">
                            <div class="flex-none">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-green-600"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900">Rapat OSIS</p>
                                <p class="text-sm text-gray-500">Jumat, 14:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-white border-t border-gray-200 mt-8">
            <div class="max-w-8xl mx-auto px-4">
                <div class="flex justify-center py-4">
                    <a href="#" class="flex flex-col items-center text-gray-600 hover:text-custom">
                        <i class="fas fa-home text-xl"></i>
                        <span class="text-xs mt-1">Beranda</span>
                    </a>
                </div>
            </div>
        </footer>
    </div>
    <script>
        document.getElementById('tugas-matematika-button').addEventListener('click', function(event) {
            event.preventDefault();
            var icon = document.getElementById('tugas-matematika-icon');
            var status = document.getElementById('tugas-matematika-status');
            icon.classList.remove('fa-exclamation-triangle', 'text-yellow-600');
            icon.classList.add('fa-check-circle', 'text-green-500');
            status.classList.remove('hidden');
        });
    </script>
</body>
</html>