
<?php
require_once '../config.php';

// Cek apakah user sudah login sebagai mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php');
    exit;
}

$mahasiswa_id = $_SESSION['user_id'];

// Ambil data praktikum yang diikuti
$stmt = $conn->prepare("
    SELECT p.nama, p.deskripsi, pp.tanggal_daftar, pp.status 
    FROM pendaftaran_praktikum pp 
    JOIN praktikum p ON pp.praktikum_id = p.id 
    WHERE pp.mahasiswa_id = ?
");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$praktikum_diikuti = $stmt->get_result();

// Ambil jumlah laporan yang sudah diupload
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM laporan WHERE mahasiswa_id = ?");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$total_laporan = $stmt->get_result()->fetch_assoc()['total'];

// Ambil jumlah praktikum yang diikuti
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM pendaftaran_praktikum WHERE mahasiswa_id = ?");
$stmt->bind_param("i", $mahasiswa_id);
$stmt->execute();
$total_praktikum = $stmt->get_result()->fetch_assoc()['total'];

$pageTitle = 'Dashboard Mahasiswa';
$activePage = 'dashboard';
include 'templates/header_mahasiswa.php';
?>

<div class="flex">
    <?php include 'templates/sidebar.php'; ?>
    
    <div class="flex-1 p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Mahasiswa</h1>
            <p class="text-gray-600 mt-2">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Praktikum Diikuti</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $total_praktikum; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Laporan Diupload</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $total_laporan; ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="text-2xl font-bold text-gray-800">Aktif</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Courses -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Praktikum yang Diikuti</h2>
            </div>
            <div class="p-6">
                <?php if ($praktikum_diikuti->num_rows > 0): ?>
                    <div class="space-y-4">
                        <?php while ($row = $praktikum_diikuti->fetch_assoc()): ?>
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-gray-800"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                        <p class="text-gray-600 text-sm mt-1"><?php echo htmlspecialchars($row['deskripsi']); ?></p>
                                        <p class="text-xs text-gray-500 mt-2">Terdaftar: <?php echo date('d/m/Y', strtotime($row['tanggal_daftar'])); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <p class="text-gray-500">Anda belum mengikuti praktikum apapun.</p>
                        <a href="courses.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Lihat Praktikum Tersedia
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer_mahasiswa.php'; ?>
