<?php
require_once 'config.php';
session_start(); // Oturumu burada başlatalım, çünkü session değişkenlerine ihtiyacımız olacak

// Giriş kontrolü
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$active_page = 'recipes.php'; // Tarifler menüsünü aktif tutalım

if ($recipe_id <= 0) {
    header("location: recipes.php?error=GecersizTarifID");
    exit;
}

// Veritabanından düzenlenecek tarifi çek
$sql_fetch = "SELECT * FROM recipes WHERE id = :id";
if ($stmt_fetch = $pdo->prepare($sql_fetch)) {
    $stmt_fetch->bindParam(':id', $recipe_id, PDO::PARAM_INT);
    if ($stmt_fetch->execute()) {
        if ($stmt_fetch->rowCount() == 1) {
            $recipe = $stmt_fetch->fetch(PDO::FETCH_ASSOC);
            // Yetkilendirme: Kullanıcı sadece kendi tarifini düzenleyebilir
            if ($recipe['user_id'] != $_SESSION['id']) {
                header("location: recipes.php?error=BuTarifiDuzenleyemezsiniz");
                exit;
            }
        } else {
            header("location: recipes.php?error=TarifBulunamadi");
            exit;
        }
    } else {
        die("Hata: Tarif bilgileri çekilemedi.");
    }
    unset($stmt_fetch);
} else {
    die("Hata: Sorgu hazırlanamadı.");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifi Düzenle: <?php echo htmlspecialchars($recipe['title']); ?> - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #D81B60; --primary-hover: #b0154c; --background-color: #f9f6f7; }
        body { padding-top: 70px; background-color: var(--background-color); font-family: 'Poppins', sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color) !important; font-size: 1.6em; }
        .navbar-nav .nav-link { color: #555; font-weight: 600; }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary-color) !important; }
        .wrapper { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-top: 30px;}
        .form-label { font-weight: bold; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(216, 27, 96, 0.25); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top"> <div class="container">
            <a class="navbar-brand" href="home.php"><i class="bi bi-egg-fried"></i> Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="recipes.php">Tarifler</a></li> {/* Tarifler aktif */}
                    <li class="nav-item"><a class="nav-link" href="#">Diyet Menüleri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kaç Kalori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hakkımızda</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item"><a class="nav-link bg-warning text-dark rounded px-2" href="admin_panel.php">Admin Paneli</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3">Merhaba, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 py-4">
        <div class="wrapper">
            <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Tarifi Düzenle: <?php echo htmlspecialchars($recipe['title']); ?></h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>


            <form action="handle_edit_recipe.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>"> {/* Güncellenecek tarifin ID'si */}

                <div class="mb-3">
                    <label for="title" class="form-label">Tarif Başlığı:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($recipe['description']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Malzemeler (Her satıra bir malzeme):</label>
                    <textarea class="form-control" id="ingredients" name="ingredients" rows="5" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label">Hazırlanışı:</label>
                    <textarea class="form-control" id="instructions" name="instructions" rows="7" required><?php echo htmlspecialchars($recipe['instructions']); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="prep_time" class="form-label">Hazırlık Süresi (Dakika):</label>
                        <input type="number" class="form-control" id="prep_time" name="prep_time" value="<?php echo htmlspecialchars($recipe['prep_time_minutes']); ?>" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cook_time" class="form-label">Pişirme Süresi (Dakika):</label>
                        <input type="number" class="form-control" id="cook_time" name="cook_time" value="<?php echo htmlspecialchars($recipe['cook_time_minutes']); ?>" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="servings" class="form-label">Kaç Kişilik:</label>
                        <input type="number" class="form-control" id="servings" name="servings" value="<?php echo htmlspecialchars($recipe['servings']); ?>" min="1">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="current_image" class="form-label">Mevcut Resim Yolu (örn: `benim_tarifim.jpg` veya boş bırakın):</label>
                    <input type="text" class="form-control" id="image_path" name="image_path" value="<?php echo htmlspecialchars($recipe['image_path'] == 'default.jpg' ? '' : $recipe['image_path']); ?>" placeholder="images/ klasöründeki resim adı veya boş">
                    <div class="form-text">Resmi değiştirmek istemiyorsanız bu alanı boş bırakabilirsiniz. Eğer yeni bir resim eklediyseniz veya değiştirdiyseniz, resmin adını `images/` klasörüne attıktan sonra buraya yazın (örn: `yeni_resmim.jpg`). Varsayılan resim için boş bırakın.</div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-save"></i> Değişiklikleri Kaydet</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>