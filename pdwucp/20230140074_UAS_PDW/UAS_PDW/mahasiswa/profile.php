
<?php
session_start();

// Akses hanya untuk mahasiswa
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

require_once '../config.php';

$user_id = $_SESSION['user_id'];
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (empty($nama) || empty($email)) {
        $message = 'Nama dan email harus diisi!';
    } else {
        // Update basic info
        $stmt = $conn->prepare("UPDATE users SET nama = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $nama, $email, $user_id);
        
        if ($stmt->execute()) {
            $_SESSION['nama'] = $nama;
            
            // Handle password change if provided
            if (!empty($current_password) && !empty($new_password)) {
                if ($new_password !== $confirm_password) {
                    $message = 'Konfirmasi password tidak sesuai!';
                } else {
                    // Verify current password
                    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $user = $result->fetch_assoc();
                    
                    if (password_verify($current_password, $user['password'])) {
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                        $stmt->bind_param("si", $hashed_password, $user_id);
                        $stmt->execute();
                        $message = 'Profil dan password berhasil diperbarui!';
                    } else {
                        $message = 'Password saat ini salah!';
                    }
                }
            } else {
                $message = 'Profil berhasil diperbarui!';
            }
        } else {
            $message = 'Gagal memperbarui profil!';
        }
        $stmt->close();
    }
}

// Get user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$pageTitle = 'Profil Saya';
$activePage = 'profile';
include 'templates/header_mahasiswa.php';
?>

<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center">
            <div class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mr-6">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($user['nama']) ?></h2>
                <p class="text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mt-2">
                    Mahasiswa
                </span>
            </div>
        </div>
    </div>

    <?php if (!empty($message)): ?>
    <div class="mb-6 p-4 rounded-lg <?= strpos($message, 'berhasil') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <!-- Profile Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-6">Edit Profil</h3>
        
        <form method="post" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
            </div>
            
            <div class="border-t pt-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h4>
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">Kosongkan jika tidak ingin mengubah password</p>
            </div>
            
            <div class="flex justify-end space-x-4">
                <a href="dashboard.php" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    
    <!-- Statistics -->
    <div class="mt-6 grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-book text-blue-600"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">Praktikum Diikuti</h4>
            <p class="text-2xl font-bold text-blue-600 mt-1">
                <?php
                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM pendaftaran_praktikum WHERE mahasiswa_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                echo $stmt->get_result()->fetch_assoc()['count'];
                ?>
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-file-alt text-green-600"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">Laporan Submitted</h4>
            <p class="text-2xl font-bold text-green-600 mt-1">
                <?php
                $stmt = $conn->prepare("SELECT COUNT(*) as count FROM laporan WHERE mahasiswa_id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                echo $stmt->get_result()->fetch_assoc()['count'];
                ?>
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-star text-purple-600"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800">Rata-rata Nilai</h4>
            <p class="text-2xl font-bold text-purple-600 mt-1">
                <?php
                $stmt = $conn->prepare("SELECT AVG(nilai) as avg_nilai FROM laporan WHERE mahasiswa_id = ? AND nilai IS NOT NULL");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $avg = $stmt->get_result()->fetch_assoc()['avg_nilai'];
                echo $avg ? number_format($avg, 1) : '-';
                ?>
            </p>
        </div>
    </div>
</div>

<?php 
$conn->close();
include 'templates/footer_mahasiswa.php'; 
?>
