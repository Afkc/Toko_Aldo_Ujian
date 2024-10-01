<?php
// database.php
$host = 'localhost';
$db = 'ecommerce';
$user = 'root'; // Ganti dengan username database Anda
$pass = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
