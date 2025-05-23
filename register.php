<?php
require_once 'config.php'; // Veritabanı bağlantısını dahil et

// Formdan gelen verileri al
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Basit doğrulama (daha kapsamlı yapılabilir)
if (empty($name) || empty($email) || empty($password)) {
    header("Location: index.php?error=Lütfen tüm alanları doldurun.");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?error=Geçersiz e-posta formatı.");
    exit();
}

// E-postanın zaten kayıtlı olup olmadığını kontrol et
$sql_check = "SELECT id FROM users WHERE email = :email";
//kullanıcıdan gelecek e postayı al databse üzerinden kontrol et
if ($stmt_check = $pdo->prepare($sql_check)) {
    $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_check->execute();
    if ($stmt_check->rowCount() > 0) {
        header("Location: index.php?error=Bu e-posta adresi zaten kayıtlı.");
        exit();
    }
    unset($stmt_check);
}

// Şifreyi hash'le (güvenlik için çok önemli!)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Veritabanına ekleme sorgusu
$sql_insert = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";

if ($stmt_insert = $pdo->prepare($sql_insert)) {
    // Parametreleri bağla
    $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_insert->bindParam(':password', $hashed_password, PDO::PARAM_STR);

    // Sorguyu çalıştır
    if ($stmt_insert->execute()) {
        // Başarılı kayıt sonrası giriş sayfasına yönlendir
        header("Location: index.php?success=Kayıt başarılı! Şimdi giriş yapabilirsiniz.");
        exit();
    } else {
        header("Location: index.php?error=Bir şeyler ters gitti. Lütfen tekrar deneyin.");
        exit();
    }
    unset($stmt_insert);
}

// Veritabanı bağlantısını kapat
unset($pdo);
?>