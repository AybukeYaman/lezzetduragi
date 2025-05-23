<?php
session_start(); // oturum başlatılır

// Geçici olarak bir kullanıcı bilgisi (veritabanı yerine)
$correct_email = "test@example.com";
$correct_password = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Şifre ve email doğruysa giriş başarılı
    if ($email === $correct_email && $password === $correct_password) {
        $_SESSION['email'] = $email; // oturum kaydı
        header("Location: home.php"); // yönlendirme
        exit();
    } else {
        // Giriş başarısızsa hata göster
        echo "<script>alert('Invalid email or password'); window.history.back();</script>";
    }
}
?>
