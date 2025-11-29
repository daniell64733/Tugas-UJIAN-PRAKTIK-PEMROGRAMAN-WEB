<?php
// Konfigurasi database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_ppdb';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi hashing password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Admin hardcoded (untuk sederhana)
$admin_username = 'admin';
$admin_password_hash = hashPassword('admin123'); // Ganti password jika perlu
?>