<?php
require_once 'config.php'; // Veritabanı bağlantısını ve session_start'ı dahil et

// Formdan gelen verileri al
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Basit doğrulama
if (empty($email) || empty($password)) {
    header("Location: index.php?error=E-posta ve şifre gereklidir.");
    exit();
}

// Kullanıcıyı e-postaya göre bul
$sql = "SELECT id, name, email, password FROM users WHERE email = :email";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Kullanıcı bulundu mu kontrol et
        if ($stmt->rowCount() == 1) {
            if ($row = $stmt->fetch()) {
                $id = $row['id'];
                $name = $row['name'];
                $hashed_password = $row['password'];

                // Girilen şifre ile veritabanındaki hash'lenmiş şifreyi karşılaştır
                if (password_verify($password, $hashed_password)) {
                    // Şifre doğru, oturumu başlat
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["name"] = $name;
                    $_SESSION["email"] = $email;

                    // Ana sayfaya yönlendir (henüz oluşturmadık ama adı 'home.php' olabilir)
                    header("Location: home.php"); // Burayı ana sayfanızın adıyla değiştirin
                    exit();
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
        header("Location: index.php?error=Bir şeyler ters gitti. Lütfen tekrar deneyin.");
        exit();
    }
    unset($stmt);
}

unset($pdo);
?>