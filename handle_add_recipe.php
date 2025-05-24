<?php
// Oturumu başlat ve config dosyasını dahil et
require_once 'config.php';

// Kullanıcı giriş yapmamışsa veya POST isteği değilse durdur
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Sadece POST metodu ile gelen istekleri kabul et
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Formdan gelen verileri al ve temizle (basit seviye)
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $prep_time = !empty($_POST['prep_time']) ? (int)$_POST['prep_time'] : null;
    $cook_time = !empty($_POST['cook_time']) ? (int)$_POST['cook_time'] : null;
    $servings = !empty($_POST['servings']) ? (int)$_POST['servings'] : null;
    $user_id = $_SESSION['id']; // Giriş yapmış kullanıcının ID'si

    // Gerekli alanların boş olup olmadığını kontrol et
    if (empty($title) || empty($ingredients) || empty($instructions)) {
        header("location: add_recipe.php?error=Lütfen başlık, malzemeler ve hazırlanışı alanlarını doldurun.");
        exit;
    }

    // Veritabanına ekleme sorgusunu hazırla
    $sql = "INSERT INTO recipes (title, description, ingredients, instructions, prep_time_minutes, cook_time_minutes, servings, user_id) 
            VALUES (:title, :description, :ingredients, :instructions, :prep_time, :cook_time, :servings, :user_id)";

    if ($stmt = $pdo->prepare($sql)) {
        // Parametreleri bağla
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
        $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt->bindParam(':prep_time', $prep_time, PDO::PARAM_INT);
        $stmt->bindParam(':cook_time', $cook_time, PDO::PARAM_INT);
        $stmt->bindParam(':servings', $servings, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        // Sorguyu çalıştır
        if ($stmt->execute()) {
            // Başarılı olursa tarifler sayfasına yönlendir
            header("location: recipes.php?success=Tarif başarıyla eklendi!");
            exit;
        } else {
            // Hata olursa formu tekrar göster
            header("location: add_recipe.php?error=Bir hata oluştu, tarif eklenemedi.");
            exit;
        }
    }

    // PDO statement nesnesini temizle
    unset($stmt);

} else {
    // POST isteği değilse, ana sayfaya yönlendir (veya bir hata göster)
    header("location: home.php");
    exit;
}

// Veritabanı bağlantısını kapat
unset($pdo);
?>