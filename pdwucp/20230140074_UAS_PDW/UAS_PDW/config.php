<?php
// Pengaturan Database
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'SIMPRAK');

// Membuat koneksi ke database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Set charset
$conn->set_charset("utf8mb4");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Fungsi untuk sanitasi input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi untuk hash password
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fungsi untuk verify password
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Mulai session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>