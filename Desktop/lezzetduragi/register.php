<?php
// Oturum başlatmak istersen:
// session_start();

// Veritabanına bağlan
try {
    $db = new PDO("mysql:host=localhost;dbname=login;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Form verilerini al
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Şifreyi hash'le
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Email zaten kayıtlı mı kontrol et
$stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetchColumn() > 0) {
    echo "<script>alert('This email is already registered.'); window.history.back();</script>";
    exit();
}

// Veritabanına kullanıcıyı ekle
$stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->execute([$name, $email, $hashedPassword]);

// Giriş sayfasına yönlendir
header("Location: index.html"); // ya da home.php
exit();
?>
