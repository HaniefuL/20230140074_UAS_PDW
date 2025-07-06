
<div class="bg-white shadow-lg h-screen w-64 fixed left-0 top-0 overflow-y-auto z-40" id="sidebar">
    <div class="p-6">
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
            <span class="text-xl font-bold text-gray-800">SIMPRAK</span>
        </div>
        
        <div class="mb-6">
            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-800"><?= htmlspecialchars($_SESSION['nama']) ?></div>
                    <div class="text-sm text-gray-600">Mahasiswa</div>
                </div>
            </div>
        </div>
        
        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors <?= ($activePage == 'dashboard') ? 'bg-blue-50 text-blue-600' : '' ?>">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>
            <a href="courses.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors <?= ($activePage == 'courses') ? 'bg-blue-50 text-blue-600' : '' ?>">
                <i class="fas fa-book mr-3"></i>
                Katalog Praktikum
            </a>
            <a href="my_courses.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors <?= ($activePage == 'my_courses') ? 'bg-blue-50 text-blue-600' : '' ?>">
                <i class="fas fa-bookmark mr-3"></i>
                Praktikum Saya
            </a>
            <a href="../katalog_praktikum.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <i class="fas fa-search mr-3"></i>
                Jelajahi Praktikum
            </a>
            <div class="border-t border-gray-200 my-4"></div>
            <a href="profile.php" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-colors">
                <i class="fas fa-user-cog mr-3"></i>
                Profil Saya
            </a>
            <a href="../logout.php" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Keluar
            </a>
        </nav>
    </div>
</div>

<!-- Mobile menu overlay -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden" id="sidebar-overlay" onclick="toggleSidebar()"></div>
