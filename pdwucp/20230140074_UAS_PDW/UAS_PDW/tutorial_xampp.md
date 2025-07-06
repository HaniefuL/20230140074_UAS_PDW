
# Tutorial Instalasi dan Setup SIMPRAK dengan XAMPP

## 1. Download dan Instalasi XAMPP

### Download XAMPP
1. Kunjungi website resmi XAMPP: https://www.apachefriends.org/
2. Pilih versi XAMPP untuk sistem operasi Anda (Windows, macOS, atau Linux)
3. Download versi terbaru (disarankan PHP 8.1 atau lebih baru)

### Instalasi XAMPP
1. **Windows:**
   - Jalankan file installer yang telah didownload
   - Ikuti wizard instalasi
   - Pilih komponen yang akan diinstall (Apache, MySQL, PHP, phpMyAdmin)
   - Pilih direktori instalasi (default: C:\xampp)
   - Selesaikan instalasi

2. **macOS:**
   - Buka file DMG yang telah didownload
   - Drag XAMPP ke folder Applications
   - Buka Terminal dan jalankan: `sudo /Applications/XAMPP/xamppfiles/xampp start`

3. **Linux:**
   - Berikan permission executable: `chmod +x xampp-linux-installer.run`
   - Jalankan installer: `sudo ./xampp-linux-installer.run`
   - Ikuti wizard instalasi

## 2. Menjalankan XAMPP

### Membuka XAMPP Control Panel
1. **Windows:** Cari "XAMPP Control Panel" di Start Menu
2. **macOS/Linux:** Buka terminal dan jalankan `sudo /opt/lampp/lampp start`

### Menjalankan Services
1. Klik tombol "Start" untuk Apache
2. Klik tombol "Start" untuk MySQL
3. Pastikan status kedua service menunjukkan "Running" (hijau)

## 3. Setup Database SIMPRAK

### Membuat Database
1. Buka browser dan akses http://localhost/phpmyadmin
2. Klik tab "Databases"
3. Buat database baru dengan nama "SIMPRAK"
4. Set Collation ke "utf8mb4_general_ci"
5. Klik "Create"

### Import Database Schema
1. Pilih database "SIMPRAK" yang telah dibuat
2. Klik tab "Import"
3. Klik "Choose File" dan pilih file `simprak.sql` dari folder project
4. Klik "Go" untuk mengimport

Atau jalankan SQL berikut untuk membuat tabel manual:

```sql
-- Tabel users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel praktikum
CREATE TABLE `praktikum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text,
  `durasi` varchar(50),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel modul
CREATE TABLE `modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `praktikum_id` int(11) DEFAULT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `file_materi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `praktikum_id` (`praktikum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel pendaftaran_praktikum
CREATE TABLE `pendaftaran_praktikum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` int(11) DEFAULT NULL,
  `praktikum_id` int(11) DEFAULT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('aktif','selesai','batal') DEFAULT 'aktif',
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  KEY `praktikum_id` (`praktikum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel laporan
CREATE TABLE `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `file_laporan` varchar(255) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tanggal_upload` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `modul_id` (`modul_id`),
  KEY `mahasiswa_id` (`mahasiswa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Foreign Key Constraints
ALTER TABLE `modul`
  ADD CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`);

ALTER TABLE `pendaftaran_praktikum`
  ADD CONSTRAINT `pendaftaran_praktikum_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pendaftaran_praktikum_ibfk_2` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`);

ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`id`),
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`);
```

## 4. Setup Project SIMPRAK

### Copy Project ke XAMPP
1. Copy folder `20230140074_UAS_PDW` ke dalam folder `htdocs` XAMPP
   - **Windows:** C:\xampp\htdocs\
   - **macOS:** /Applications/XAMPP/htdocs/
   - **Linux:** /opt/lampp/htdocs/

### Konfigurasi Database
1. Buka file `config.php`
2. Pastikan konfigurasi database sesuai:
```php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'SIMPRAK');
```

### Setup Folder Uploads
1. Buat folder `uploads` di dalam direktori project jika belum ada
2. Pastikan folder memiliki permission write
   - **Windows:** Klik kanan folder → Properties → Security → Edit → Full Control
   - **macOS/Linux:** `chmod 755 uploads/`

### Integrasi Semua File
1. Pastikan semua file PHP sudah terhubung dengan benar
2. Cek koneksi database di setiap file
3. Pastikan session management berjalan dengan baik
4. Test semua fitur upload file

### Struktur Folder yang Benar
```
htdocs/
└── 20230140074_UAS_PDW/
    └── UAS_PDW/
        ├── config.php (konfigurasi database)
        ├── index.php (halaman utama)
        ├── login.php (halaman login)
        ├── register.php (halaman register)
        ├── logout.php (proses logout)
        ├── katalog_praktikum.php (katalog praktikum)
        ├── simprak.sql (file database)
        ├── uploads/ (folder upload file)
        ├── index/
        │   ├── indexheader.php
        │   └── indexfooter.php
        ├── mahasiswa/
        │   ├── dashboard.php
        │   ├── courses.php
        │   ├── profile.php
        │   └── templates/
        └── asisten/
            ├── dashboard.php
            ├── praktikum.php
            ├── users.php
            └── templates/
```

## 5. Akses Aplikasi

### Membuka SIMPRAK
1. Pastikan Apache dan MySQL sudah running
2. Buka browser dan akses: http://localhost/20230140074_UAS_PDW/UAS_PDW/
3. Aplikasi SIMPRAK akan terbuka

### Login Pertama Kali
1. Daftar akun baru melalui halaman register
2. Atau buat akun manual melalui phpMyAdmin:

```sql
-- Membuat akun asisten
INSERT INTO users (nama, email, password, role) VALUES 
('Admin Asisten', 'asisten@simprak.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'asisten');

-- Membuat akun mahasiswa  
INSERT INTO users (nama, email, password, role) VALUES 
('Mahasiswa Test', 'mahasiswa@simprak.ac.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mahasiswa');
```

Password default: `password`

## 6. Troubleshooting

### Apache Tidak Bisa Start
- **Port 80 sudah digunakan:** Ganti port Apache di httpd.conf
- **Skype conflict:** Matikan Skype atau ganti port di Skype settings
- **IIS conflict:** Matikan IIS di Windows Features

### MySQL Tidak Bisa Start
- **Port 3306 sudah digunakan:** Ganti port MySQL di my.ini
- **Service conflict:** Stop MySQL service yang lain di Task Manager

### Error Permission Denied
- **Windows:** Run XAMPP sebagai Administrator
- **macOS/Linux:** Gunakan `sudo` untuk menjalankan commands

### File Upload Error
- Pastikan folder `uploads` memiliki permission write
- Check PHP configuration di `php.ini`:
  ```ini
  file_uploads = On
  upload_max_filesize = 10M
  post_max_size = 10M
  ```

### Database Connection Error
- Pastikan MySQL service running
- Check konfigurasi di `config.php`
- Pastikan database "SIMPRAK" sudah dibuat

## 7. Fitur-Fitur SIMPRAK

### Untuk Mahasiswa:
- Dashboard dengan overview praktikum
- Pendaftaran praktikum baru
- Upload laporan praktikum
- Melihat nilai dan feedback
- Manajemen profil

### Untuk Asisten:
- Dashboard administratif
- Manajemen praktikum dan modul
- Review dan penilaian laporan
- Manajemen user mahasiswa
- Statistik sistem

## 8. Pengembangan Lebih Lanjut

### Menambah Fitur Baru
1. Buat file PHP baru di folder yang sesuai
2. Gunakan template header dan footer yang sudah ada
3. Ikuti struktur MVC yang sudah diterapkan

### Customisasi Tampilan
- Edit file CSS di dalam tag `<style>` atau buat file CSS terpisah
- Gunakan Tailwind CSS classes yang sudah tersedia
- Tambahkan JavaScript untuk interaktivitas

### Backup Data
- Reguler backup database melalui phpMyAdmin
- Export dan simpan file SQL backup
- Backup folder project secara berkala

## 9. Testing Integrasi

### Test Koneksi Database
1. Akses http://localhost/20230140074_UAS_PDW/UAS_PDW/
2. Pastikan tidak ada error koneksi database
3. Test register akun baru
4. Test login dengan akun yang dibuat

### Test Fitur Mahasiswa
1. Login sebagai mahasiswa
2. Test dashboard mahasiswa
3. Test pendaftaran praktikum
4. Test upload laporan

### Test Fitur Asisten
1. Login sebagai asisten
2. Test dashboard asisten
3. Test kelola praktikum
4. Test kelola modul
5. Test review laporan

### Test File Upload
1. Buat folder uploads jika belum ada
2. Set permission yang benar
3. Test upload file laporan
4. Test upload file materi

## 10. Tips Keamanan

1. **Ganti Password Default:** Ubah password default untuk akun admin
2. **Update XAMPP:** Selalu gunakan versi XAMPP terbaru
3. **Firewall:** Konfigurasi firewall untuk membatasi akses
4. **File Permissions:** Set permission file yang tepat
5. **Backup Regular:** Lakukan backup data secara rutin
6. **Sanitasi Input:** Selalu sanitasi input pengguna
7. **Session Security:** Gunakan session dengan benar

## 10. Support dan Dokumentasi

Untuk bantuan lebih lanjut:
- Dokumentasi XAMPP: https://www.apachefriends.org/docs/
- Tutorial PHP: https://www.php.net/manual/
- Tutorial MySQL: https://dev.mysql.com/doc/

---

**Selamat! SIMPRAK sudah siap digunakan dengan XAMPP.**
