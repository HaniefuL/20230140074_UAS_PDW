
<?php
require_once '../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'asisten') {
    header('Location: ../login.php');
    exit;
}

$asisten_id = $_SESSION['user_id'];
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = sanitize_input($_POST['nama']);
    $deskripsi = sanitize_input($_POST['deskripsi']);
    $durasi = sanitize_input($_POST['durasi']);
    
    if (!empty($nama) && !empty($deskripsi)) {
        $stmt = $conn->prepare("INSERT INTO praktikum (asisten_id, nama, deskripsi, durasi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $asisten_id, $nama, $deskripsi, $durasi);
        
        if ($stmt->execute()) {
            $message = 'Praktikum berhasil ditambahkan!';
        } else {
            $message = 'Terjadi kesalahan saat menambahkan praktikum.';
        }
    }
}

// Ambil semua praktikum
$stmt = $conn->prepare("SELECT * FROM praktikum WHERE asisten_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $asisten_id);
$stmt->execute();
$praktikum_list = $stmt->get_result();

$pageTitle = 'Kelola Praktikum';
$activePage = 'praktikum';
include 'templates/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Praktikum</h1>
        <p class="text-gray-600 mt-2">Kelola praktikum yang Anda ampu</p>
    </div>

    <?php if ($message): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Form Add Praktikum -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Tambah Praktikum Baru</h2>
        </div>
        <div class="p-6">
            <form method="POST" class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Praktikum</label>
                    <input type="text" id="nama" name="nama" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" required
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <div>
                    <label for="durasi" class="block text-sm font-medium text-gray-700">Durasi</label>
                    <input type="text" id="durasi" name="durasi" placeholder="Contoh: 14 Minggu"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Tambah Praktikum
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- List Praktikum -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">Daftar Praktikum</h2>
        </div>
        <div class="p-6">
            <?php if ($praktikum_list->num_rows > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php while ($row = $praktikum_list->fetch_assoc()): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['nama']); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900"><?php echo htmlspecialchars(substr($row['deskripsi'], 0, 100)); ?>...</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($row['durasi']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo date('d/m/Y', strtotime($row['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="edit_praktikum.php?id=<?php echo $row['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <a href="modul.php?praktikum_id=<?php echo $row['id']; ?>" class="text-green-600 hover:text-green-900">Kelola Modul</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada praktikum yang dibuat.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
