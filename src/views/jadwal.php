<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jadwal = [];
    foreach ($_POST['jadwal'] as $day => $subjects) {
        foreach ($subjects as $subject) {
            $jadwal[$day][] = [
                'time' => $subject['time'],
                'subject' => $subject['subject']
            ];
        }
    }
    $_SESSION['jadwal'] = $jadwal;
    header('Location: index.php');
    exit;
}

$days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$jadwal = isset($_SESSION['jadwal']) ? $_SESSION['jadwal'] : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMWB - Jadwal Pelajaran</title>
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
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Pelajaran</h2>
                <form action="jadwal.php" method="post">
                    <?php foreach ($days as $day): ?>
                        <div class="mb-4">
                            <h3 class="text-md font-semibold text-gray-900 mb-2"><?php echo $day; ?></h3>
                            <div class="space-y-2">
                                <?php for ($i = 0; $i < 8; $i++): ?>
                                    <div class="flex items-center space-x-4">
                                        <input type="time" name="jadwal[<?php echo $day; ?>][<?php echo $i; ?>][time]" class="w-1/4 px-2 py-1 border-gray-300 rounded-md" value="<?php echo isset($jadwal[$day][$i]['time']) ? $jadwal[$day][$i]['time'] : ''; ?>">
                                        <input type="text" name="jadwal[<?php echo $day; ?>][<?php echo $i; ?>][subject]" class="w-3/4 px-2 py-1 border-gray-300 rounded-md" placeholder="Mata Pelajaran" value="<?php echo isset($jadwal[$day][$i]['subject']) ? $jadwal[$day][$i]['subject'] : ''; ?>">
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
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