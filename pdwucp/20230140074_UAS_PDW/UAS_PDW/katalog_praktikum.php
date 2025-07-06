
<?php
require_once 'config.php';

$pageTitle = 'Katalog Praktikum - SIMPRAK';
$activePage = 'catalog';
include 'index/indexheader.php';

// Ambil semua praktikum
$sql = "SELECT * FROM praktikum ORDER BY nama";
$result = $conn->query($sql);
?>

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Katalog Praktikum</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">Jelajahi berbagai praktikum yang tersedia dan temukan yang sesuai dengan kebutuhan pembelajaran Anda</p>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="searchInput" placeholder="Cari praktikum..." 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <select id="categoryFilter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Kategori</option>
                        <option value="programming">Pemrograman</option>
                        <option value="database">Database</option>
                        <option value="web">Web Development</option>
                        <option value="mobile">Mobile Development</option>
                    </select>
                </div>
            </div>
        </div>

        <?php if ($result->num_rows > 0): ?>
        <!-- Praktikum Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="praktikumGrid">
            <?php while ($praktikum = $result->fetch_assoc()): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover praktikum-card" 
                 data-name="<?= strtolower(htmlspecialchars($praktikum['nama'])) ?>">
                <div class="h-48 bg-gradient-to-br from-blue-500 to-purple-600 relative">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    <div class="absolute bottom-4 left-4 text-white">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mb-2">
                            <i class="fas fa-code text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold"><?= htmlspecialchars($praktikum['nama']) ?></h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-600 mb-4 line-clamp-3"><?= htmlspecialchars($praktikum['deskripsi'] ?? 'Deskripsi praktikum akan segera tersedia.') ?></p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-clock mr-1"></i>
                            <span><?= htmlspecialchars($praktikum['durasi'] ?? '8 Minggu') ?></span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-users mr-1"></i>
                            <span><?= rand(20, 50) ?> Mahasiswa</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">A1</div>
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">A2</div>
                            <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-semibold">+</div>
                        </div>
                        
                        <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'mahasiswa'): ?>
                        <a href="mahasiswa/daftar_praktikum.php?id=<?= $praktikum['id'] ?>" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-semibold">
                            Daftar
                        </a>
                        <?php else: ?>
                        <a href="login.php" 
                           class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition-colors text-sm font-semibold">
                            Login untuk Daftar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Progress indicator jika sudah login -->
                <?php if (isset($_SESSION['user_id'])): ?>
                <div class="px-6 pb-4">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?= rand(0, 100) ?>%"></div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Progress: <?= rand(0, 100) ?>%</div>
                </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-gray-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Praktikum</h3>
            <p class="text-gray-500">Praktikum akan segera tersedia. Silakan cek kembali nanti.</p>
        </div>
        <?php endif; ?>
        
        <!-- CTA Section -->
        <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai Pembelajaran?</h2>
            <p class="text-xl mb-6">Bergabunglah dengan ribuan mahasiswa yang telah merasakan pengalaman belajar terbaik</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="space-x-4">
                <a href="register.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Daftar Sekarang
                </a>
                <a href="login.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Masuk
                </a>
            </div>
            <?php else: ?>
            <a href="<?= $_SESSION['role'] ?>/dashboard.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                Ke Dashboard
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = document.querySelectorAll('.praktikum-card');
    
    cards.forEach(card => {
        const name = card.dataset.name;
        if (name.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Category filter functionality
document.getElementById('categoryFilter').addEventListener('change', function() {
    const category = this.value.toLowerCase();
    const cards = document.querySelectorAll('.praktikum-card');
    
    cards.forEach(card => {
        if (category === '' || card.dataset.name.includes(category)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>

<?php 
$conn->close();
include 'index/indexfooter.php'; 
?>
