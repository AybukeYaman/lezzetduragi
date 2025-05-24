<?php
require_once 'config.php';
session_start(); // Oturumu burada başlatalım

// Giriş kontrolü
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Silinecek tarifin ID'sini al
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipe_id <= 0) {
    // Geçerli bir ID yoksa tarifler sayfasına hata mesajıyla yönlendir
    header("location: recipes.php?error=GecersizTarifID");
    exit;
}

// Yetkilendirme: Kullanıcı sadece kendi tarifini silebilir
// Önce tarifin kime ait olduğunu bulalım
$sql_check_owner = "SELECT user_id FROM recipes WHERE id = :id";
if ($stmt_check = $pdo->prepare($sql_check_owner)) {
    $stmt_check->bindParam(':id', $recipe_id, PDO::PARAM_INT);
    $stmt_check->execute();
    $owner = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if (!$owner) {
        header("location: recipes.php?error=TarifBulunamadi");
        exit;
    }

    // Eğer tarifi ekleyen kişi o anki kullanıcı değilse, silme yetkisi yok
    // (Admin yetkisi şimdilik yok)
    if ($owner['user_id'] != $_SESSION['id']) {
        header("location: recipes.php?error=BuTarifiSilemezsiniz");
        exit;
    }
    unset($stmt_check);
} else {
    // Sorgu hazırlanamazsa genel bir hata verelim
    header("location: recipes.php?error=VeritabaniHatasi");
    exit;
}


// Veritabanından tarifi silme sorgusunu hazırla
$sql_delete = "DELETE FROM recipes WHERE id = :id AND user_id = :user_id"; // user_id ile ek güvenlik

if ($stmt_delete = $pdo->prepare($sql_delete)) {
    // Parametreleri bağla
    $stmt_delete->bindParam(':id', $recipe_id, PDO::PARAM_INT);
    $stmt_delete->bindParam(':user_id', $_SESSION['id'], PDO::PARAM_INT);

    // Sorguyu çalıştır
    if ($stmt_delete->execute()) {
        // Başarılı olursa ve en az bir satır etkilendiyse (yani silme gerçekleştiyse)
        if ($stmt_delete->rowCount() > 0) {
            header("location: recipes.php?success=Tarif başarıyla silindi!");
            exit;
        } else {
            // Silme işlemi gerçekleşmedi (belki ID yanlıştı veya yetki sorunu - yukarıda yakalanmalıydı ama ek kontrol)
            header("location: recipes.php?error=Tarif silinemedi veya zaten silinmiş.");
            exit;
        }
    } else {
        // Hata olursa tarifler sayfasına hata mesajıyla yönlendir
        header("location: recipes.php?error=Bir hata oluştu, tarif silinemedi.");
        exit;
    }
    unset($stmt_delete);
} else {
    header("location: recipes.php?error=VeritabaniSorguHatasiSilme");
    exit;
}

unset($pdo); // Veritabanı bağlantısını kapat
?>