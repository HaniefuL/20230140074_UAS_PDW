
<?php
session_start();

// Already logged in? Redirect based on role
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['role'];
    if ($role === 'mahasiswa') {
        header('Location: mahasiswa/dashboard.php');
        exit;
    } elseif ($role === 'asisten') {
        header('Location: asisten/dashboard.php');
        exit;
    }
}

$pageTitle = 'SIMPRAK - Sistem Informasi Manajemen Praktikum';
$activePage = 'home';
include 'index/indexheader.php';
?>

<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-12">
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-600 rounded-full mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-5xl font-bold text-gray-800 mb-4">SIMPRAK</h1>
                <p class="text-xl text-gray-600 mb-8">Sistem Informasi Manajemen Praktikum</p>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Platform pembelajaran praktikum terintegrasi yang memudahkan mahasiswa dan asisten dalam mengelola kegiatan praktikum secara efisien dan modern.</p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Manajemen Praktikum</h3>
                <p class="text-gray-600">Kelola praktikum, modul, dan materi pembelajaran dengan mudah</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Laporan Digital</h3>
                <p class="text-gray-600">Upload dan kelola laporan praktikum secara digital</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-transform">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Penilaian Otomatis</h3>
                <p class="text-gray-600">Sistem penilaian yang efisien untuk asisten dan mahasiswa</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center">
            <div class="inline-flex flex-col sm:flex-row gap-4 mb-8">
                <a href="login.php" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                    Masuk ke Sistem
                </a>
                <a href="register.php" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold shadow-lg">
                    Daftar Sekarang
                </a>
                <a href="katalog_praktikum.php" class="px-8 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-semibold shadow-lg">
                    Lihat Katalog Praktikum
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-xl shadow-lg p-8 mt-16">
            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-blue-600 mb-2">100+</div>
                    <div class="text-gray-600">Mahasiswa Aktif</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-green-600 mb-2">25+</div>
                    <div class="text-gray-600">Praktikum Tersedia</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">50+</div>
                    <div class="text-gray-600">Modul Pembelajaran</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-orange-600 mb-2">10+</div>
                    <div class="text-gray-600">Asisten Berpengalaman</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'index/indexfooter.php'; ?>
