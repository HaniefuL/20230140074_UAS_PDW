<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'SIMPRAK'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-item:hover {
            background-color: #f3f4f6;
        }
        .sidebar-item.active {
            background-color: #3b82f6;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold text-gray-800">SIMPRAK - Asisten</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                    <a href="../logout.php" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-md min-h-screen">
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="dashboard.php" class="sidebar-item <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?> block px-4 py-2 rounded">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="praktikum.php" class="sidebar-item <?php echo ($activePage == 'praktikum') ? 'active' : ''; ?> block px-4 py-2 rounded">
                            Kelola Praktikum
                        </a>
                    </li>
                    <li>
                        <a href="modul.php" class="sidebar-item <?php echo ($activePage == 'modul') ? 'active' : ''; ?> block px-4 py-2 rounded">
                            Kelola Modul
                        </a>
                    </li>
                    <li>
                        <a href="laporan.php" class="sidebar-item <?php echo ($activePage == 'laporan') ? 'active' : ''; ?> block px-4 py-2 rounded">
                            Review Laporan
                        </a>
                    </li>
                    <li>
                        <a href="users.php" class="sidebar-item <?php echo ($activePage == 'users') ? 'active' : ''; ?> block px-4 py-2 rounded">
                            Kelola User
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">