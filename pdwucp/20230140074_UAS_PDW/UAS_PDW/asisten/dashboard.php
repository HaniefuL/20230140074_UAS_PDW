
<?php
require_once '../config.php';

// Cek apakah user sudah login sebagai asisten
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
    header('Location: ../login.php');
    exit;
}

$asisten_id = $_SESSION['user_id'];

// Ambil statistik
$total_praktikum = $conn->query("SELECT COUNT(*) as total FROM praktikum WHERE asisten_id = $asisten_id")->fetch_assoc()['total'];
$total_mahasiswa = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'mahasiswa'")->fetch_assoc()['total'];
$total_laporan = $conn->query("SELECT COUNT(*) as total FROM laporan")->fetch_assoc()['total'];
$laporan_pending = $conn->query("SELECT COUNT(*) as total FROM laporan WHERE status = 'pending'")->fetch_assoc()['total'];

// Ambil praktikum yang dikelola
$stmt = $conn->prepare("SELECT * FROM praktikum WHERE asisten_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->bind_param("i", $asisten_id);
$stmt->execute();
$praktikum_terbaru = $stmt->get_result();

$pageTitle = 'Dashboard Asisten';
$activePage = 'dashboard';
include 'templates/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Asisten</h1>
        <p class="text-gray-600 mt-2">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Praktikum</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $total_praktikum; ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Mahasiswa</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $total_mahasiswa; ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Total Laporan</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $total_laporan; ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-600">Laporan Pending</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo $laporan_pending; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Praktikum Terbaru</h2>
        </div>
        <div class="p-6">
            <?php if ($praktikum_terbaru->num_rows > 0): ?>
                <div class="space-y-4">
                    <?php while ($row = $praktikum_terbaru->fetch_assoc()): ?>
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                    <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                    <p class="text-xs text-gray-500 mt-2">Dibuat: <?php echo date('d/m/Y', strtotime($row['created_at'])); ?></p>
                                </div>
                                <div class="text-right">
                                    <a href="edit_praktikum.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada praktikum yang dibuat.</p>
                    <a href="praktikum.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Buat Praktikum Baru
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
