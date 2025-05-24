<?php
require_once 'config.php';
session_start(); // Oturumu burada başlatalım

// Giriş kontrolü
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Sadece POST metodu ile gelen istekleri kabul et
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Formdan gelen verileri al
    $recipe_id = isset($_POST['recipe_id']) ? (int)$_POST['recipe_id'] : 0;
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $ingredients = trim($_POST['ingredients']);
    $instructions = trim($_POST['instructions']);
    $prep_time = !empty($_POST['prep_time']) ? (int)$_POST['prep_time'] : null;
    $cook_time = !empty($_POST['cook_time']) ? (int)$_POST['cook_time'] : null;
    $servings = !empty($_POST['servings']) ? (int)$_POST['servings'] : null;
    $image_path = trim($_POST['image_path']); // Yeni resim yolu

    // Geçerli bir tarif ID'si olmalı
    if ($recipe_id <= 0) {
        header("location: recipes.php?error=GecersizTarifID");
        exit;
    }

    // Gerekli alanların boş olup olmadığını kontrol et
    if (empty($title) || empty($ingredients) || empty($instructions)) {
        header("location: edit_recipe.php?id=" . $recipe_id . "&error=Lütfen başlık, malzemeler ve hazırlanışı alanlarını doldurun.");
        exit;
    }

    // Yetkilendirme: Kullanıcı sadece kendi tarifini güncelleyebilir
    // (Admin yetkilendirmesi şimdilik yok)
    $sql_check_owner = "SELECT user_id FROM recipes WHERE id = :id";
    if ($stmt_check = $pdo->prepare($sql_check_owner)) {
        $stmt_check->bindParam(':id', $recipe_id, PDO::PARAM_INT);
        $stmt_check->execute();
        $owner = $stmt_check->fetch(PDO::FETCH_ASSOC);
        if (!$owner || $owner['user_id'] != $_SESSION['id']) {
            header("location: recipes.php?error=BuTarifiGuncelleyemezsiniz");
            exit;
        }
        unset($stmt_check);
    } else {
        die("Yetkilendirme hatası.");
    }

    // Resim yolu boş bırakılırsa veya 'default.jpg' ise, onu default.jpg olarak ayarla
    // Kullanıcı `images/` klasörüne resmi kendi atmalı ve buraya sadece dosya adını yazmalı
    if (empty($image_path) || strtolower($image_path) === 'default.jpg') {
        $final_image_path = 'default.jpg';
    } else {
        // Güvenlik için sadece dosya adını alalım, yol enjeksiyonunu önleyelim
        $final_image_path = basename($image_path);
    }


    // Veritabanını güncelleme sorgusunu hazırla
    $sql_update = "UPDATE recipes SET 
                    title = :title, 
                    description = :description, 
                    ingredients = :ingredients, 
                    instructions = :instructions, 
                    prep_time_minutes = :prep_time, 
                    cook_time_minutes = :cook_time, 
                    servings = :servings,
                    image_path = :image_path
                  WHERE id = :id AND user_id = :user_id"; // user_id ile ek güvenlik

    if ($stmt_update = $pdo->prepare($sql_update)) {
        // Parametreleri bağla
        $stmt_update->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt_update->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt_update->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
        $stmt_update->bindParam(':instructions', $instructions, PDO::PARAM_STR);
        $stmt_update->bindParam(':prep_time', $prep_time, PDO::PARAM_INT);
        $stmt_update->bindParam(':cook_time', $cook_time, PDO::PARAM_INT);
        $stmt_update->bindParam(':servings', $servings, PDO::PARAM_INT);
        $stmt_update->bindParam(':image_path', $final_image_path, PDO::PARAM_STR);
        $stmt_update->bindParam(':id', $recipe_id, PDO::PARAM_INT);
        $stmt_update->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);


        // Sorguyu çalıştır
        if ($stmt_update->execute()) {
            // Başarılı olursa tarifin detay sayfasına yönlendir
            header("location: view_recipe.php?id=" . $recipe_id . "&success=Tarif başarıyla güncellendi!");
            exit;
        } else {
            // Hata olursa düzenleme formuna geri gönder
            header("location: edit_recipe.php?id=" . $recipe_id . "&error=Bir hata oluştu, tarif güncellenemedi.");
            exit;
        }
        unset($stmt_update);
    } else {
        header("location: edit_recipe.php?id=" . $recipe_id . "&error=Veritabanı sorgu hatası.");
        exit;
    }

} else {
    // POST isteği değilse, ana sayfaya yönlendir
    header("location: home.php");
    exit;
}

unset($pdo); // Veritabanı bağlantısını kapat
?>