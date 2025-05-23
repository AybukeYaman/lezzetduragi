<?php
/* Veritabanı Bağlantı Bilgileri */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // XAMPP varsayılan kullanıcı adı
define('DB_PASSWORD', '');     // XAMPP varsayılan şifre (boş)
define('DB_NAME', 'recipe_db');

/* Veritabanına Bağlanma Denemesi */
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // PDO hata modunu istisna olarak ayarla
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Karakter setini ayarla
    $pdo->exec("SET NAMES 'utf8mb4'");
} catch(PDOException $e){
    die("HATA: Veritabanına bağlanılamadı. " . $e->getMessage());
}

// Oturumu başlat (Giriş/Çıkış işlemleri için gerekli)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>