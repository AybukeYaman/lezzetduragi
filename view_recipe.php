<?php
require_once 'config.php'; 

$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($recipe_id <= 0) {
    header("location: recipes.php");
    exit;
}

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$active_page = 'recipes.php'; 

$sql = "SELECT r.*, u.name as author_name 
        FROM recipes r 
        JOIN users u ON r.user_id = u.id 
        WHERE r.id = :id";

if ($stmt = $pdo->prepare($sql)) {
    $stmt->bindParam(':id', $recipe_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
            $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            header("location: recipes.php?error=Tarif bulunamadi.");
            exit;
        }
    } else { die("Hata: Sorgu çalıştırılamadı."); }
    unset($stmt);
} else { die("Hata: Sorgu hazırlanamadı."); }

function get_image_path_view($path) {
    $full_path = 'images/' . htmlspecialchars($path);
    return (!empty($path) && file_exists($full_path)) ? $full_path : 'images/default.jpg';
}

function nl2br_custom($string) {
    return nl2br(htmlspecialchars($string));
}

unset($pdo);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?> - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #D81B60; --background-color: #f9f6f7; --text-color: #333; }
        body { padding-top: 70px; background-color: var(--background-color); font-family: 'Poppins', sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color) !important; font-size: 1.6em; }
        .navbar-nav .nav-link { color: #555; font-weight: 600; }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary-color) !important; }
        .recipe-detail-card { background-color: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); margin-top: 30px; }
        .recipe-title { font-family: 'Playfair Display', serif; color: var(--text-color); border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px; }
        .recipe-image { width: 100%; max-width: 600px; height: auto; border-radius: 10px; margin-bottom: 30px; display: block; margin-left: auto; margin-right: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .recipe-meta { display: flex; justify-content: space-around; background-color: #f1f1f1; padding: 15px; border-radius: 8px; margin-bottom: 30px; text-align: center; font-size: 0.95em; }
        .recipe-meta div { color: #555; } .recipe-meta i { color: var(--primary-color); margin-right: 5px; font-size: 1.2em; }
        .recipe-section h3 { font-family: 'Playfair Display', serif; color: var(--primary-color); margin-top: 30px; margin-bottom: 15px; }
        .ingredients-list, .instructions-list { background-color: #fff; padding: 20px; border-radius: 8px; border: 1px solid #eee; }
        .ingredients-list ul { list-style: none; padding-left: 0; } .ingredients-list li { padding: 8px 0; border-bottom: 1px dashed #eee; } .ingredients-list li:last-child { border-bottom: none; }
        .instructions-list p { line-height: 1.8; } .author-info { text-align: right; margin-top: 20px; font-style: italic; color: #777; }
        .action-buttons { margin-top: 30px; text-align: center; } .action-buttons .btn { margin: 0 10px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top"> <div class="container">
            <a class="navbar-brand" href="home.php"><i class="bi bi-egg-fried"></i> Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="recipes.php">Tarifler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Diyet Menüleri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kaç Kalori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hakkımızda</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link bg-warning text-dark rounded px-2" href="admin_panel.php">Admin Paneli</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3">Merhaba, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="recipe-detail-card">
            <h1 class="recipe-title text-center"><?php echo htmlspecialchars($recipe['title']); ?></h1>
            <img src="<?php echo get_image_path_view($recipe['image_path']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>" class="recipe-image img-fluid">
            <div class="recipe-meta"> /* Meta Kodu */ </div>
            <?php if (!empty($recipe['description'])): ?> <div class="recipe-section"><p class="lead text-center fst-italic">"<?php echo htmlspecialchars($recipe['description']); ?>"</p></div> <?php endif; ?>
            <div class="row">
                <div class="col-md-5">
                    <div class="recipe-section ingredients-list">
                        <h3><i class="bi bi-basket"></i> Malzemeler</h3>
                        <ul>
                           <?php 
                                $ingredients_array = explode("\n", $recipe['ingredients']);
                                foreach ($ingredients_array as $ingredient) {
                                    $ingredient = trim($ingredient);
                                    if (!empty($ingredient)) { echo '<li>' . htmlspecialchars($ingredient) . '</li>'; }
                                }
                           ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7">
                     <div class="recipe-section instructions-list">
                        <h3><i class="bi bi-list-ol"></i> Hazırlanışı</h3>
                        <p><?php echo nl2br_custom($recipe['instructions']); ?></p>
                     </div>
                </div>
            </div>
            <p class="author-info">Bu tarifi ekleyen: <?php echo htmlspecialchars($recipe['author_name']); ?></p>

            <div class="action-buttons">
                <?php 
                // Eğer giriş yapan kullanıcı tarifi ekleyen kişi VEYA admin ise butonları göster
                if (isset($_SESSION['id']) && isset($_SESSION['role']) && ($recipe['user_id'] == $_SESSION['id'] || $_SESSION['role'] == 'admin')): 
                ?>
                    <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-secondary"><i class="bi bi-pencil"></i> Tarifi Düzenle</a>
                    <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-danger" onclick="return confirm('Bu tarifi silmek istediğinizden emin misiniz?');"><i class="bi bi-trash"></i> Tarifi Sil</a>
                <?php endif; ?>
                 <a href="recipes.php" class="btn btn-outline-primary"><i class="bi bi-arrow-left"></i> Tüm Tariflere Dön</a>
            </div>

        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>