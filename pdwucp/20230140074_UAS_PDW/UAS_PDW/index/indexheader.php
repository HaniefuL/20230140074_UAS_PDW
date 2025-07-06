
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'SIMPRAK'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">SIMPRAK</span>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="index.php" class="text-gray-600 hover:text-blue-600 transition-colors <?php echo ($activePage == 'home') ? 'text-blue-600 font-semibold' : ''; ?>">Beranda</a>
                    <a href="katalog_praktikum.php" class="text-gray-600 hover:text-blue-600 transition-colors">Katalog</a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="login.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Masuk</a>
                    <a href="register.php" class="border border-blue-600 text-blue-600 px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors">Daftar</a>
                    <?php else: ?>
                    <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">Keluar</a>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button class="text-gray-600 hover:text-blue-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="index.php" class="block py-2 text-gray-600 hover:text-blue-600">Beranda</a>
                <a href="katalog_praktikum.php" class="block py-2 text-gray-600 hover:text-blue-600">Katalog</a>
                <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="login.php" class="block py-2 text-gray-600 hover:text-blue-600">Masuk</a>
                <a href="register.php" class="block py-2 text-gray-600 hover:text-blue-600">Daftar</a>
                <?php else: ?>
                <a href="logout.php" class="block py-2 text-red-600 hover:text-red-700">Keluar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
