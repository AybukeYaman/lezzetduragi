<?php
// config.php'yi dahil et (veritabanı bağlantısı ve session_start() için)
require_once 'config.php'; 

// Formdan gelen verileri al (varsa)
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Sadece POST metodu ile gelen istekleri kabul et
// Eğer form gönderilmediyse (doğrudan login.php'ye gelinirse) index.php'ye dön
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: index.php");
    exit;
}

// E-posta veya şifre boşsa, hata mesajıyla index.php'ye yönlendir
if (empty($email) || empty($password)) {
    header("Location: index.php?error=E-posta ve şifre gereklidir.");
    exit();
}

// Kullanıcıyı e-postaya göre bul (role sütununu da al)
$sql = "SELECT id, name, email, password, role FROM users WHERE email = :email";

if ($stmt = $pdo->prepare($sql)) {
    // Parametreyi bağla
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        // Kullanıcı bulundu mu kontrol et (sadece 1 tane olmalı)
        if ($stmt->rowCount() == 1) {
            // Kullanıcı bilgilerini al
            if ($row = $stmt->fetch()) {
                $id = $row['id'];
                $name = $row['name'];
                $hashed_password = $row['password'];
                $role = $row['role']; // Rolü al

                // Girilen şifre ile veritabanındaki hash'lenmiş şifreyi doğrula
                if (password_verify($password, $hashed_password)) {
                    // Şifre doğru! Oturum değişkenlerini ayarla.
                    // config.php'de session_start() zaten var, burada tekrar başlatmaya gerek yok.
                    
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["name"] = $name;
                    $_SESSION["email"] = $email;
                    $_SESSION["role"] = $role; // Rolü oturuma kaydet

                    // Ana sayfaya yönlendir
                    header("Location: home.php"); 
                    exit(); // Yönlendirmeden sonra betiği durdurmak önemlidir.

                } else {
                    // Şifre yanlış
                    header("Location: index.php?error=Geçersiz e-posta veya şifre.");
                    exit();
                }
            }
        } else {
            // Kullanıcı bulunamadı
            header("Location: index.php?error=Geçersiz e-posta veya şifre.");
            exit();
        }
    } else {
        // Sorgu çalıştırılamadı
        header("Location: index.php?error=Bir şeyler ters gitti. Lütfen tekrar deneyin.");
        exit();
    }
    // PDO statement nesnesini temizle
    unset($stmt);
} else {
     // Sorgu hazırlanamadı
     header("Location: index.php?error=Veritabanı hatası. Lütfen tekrar deneyin.");
     exit();
}

// Veritabanı bağlantısını kapat
unset($pdo);
?>