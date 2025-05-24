<?php
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$active_page = 'recipes.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Tarif Ekle - Lezzet Durağı</title>
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
        .btn-success { background-color: #4CAF50; border-color: #4CAF50; }
        .btn-success:hover { background-color: #45a049; border-color: #45a049; }
        .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.25rem rgba(216, 27, 96, 0.25); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top"> /* Navbar Kodu Buraya Gelecek (home.php'den kopyala) */ </nav>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php"><i class="bi bi-egg-fried"></i> Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'home.php') ? 'active' : ''; ?>" href="home.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'recipes.php' || $active_page == 'add_recipe.php') ? 'active' : ''; ?>" href="recipes.php">Tarifler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Diyet Menüleri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kaç Kalori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hakkımızda</a></li>
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
            <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Yeni Tarif Ekle</h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="handle_add_recipe.php" method="POST">
                <div class="mb-3"><label for="title" class="form-label">Tarif Başlığı:</label><input type="text" class="form-control" id="title" name="title" required></div>
                <div class="mb-3"><label for="description" class="form-label">Açıklama:</label><textarea class="form-control" id="description" name="description" rows="3"></textarea></div>
                <div class="mb-3"><label for="ingredients" class="form-label">Malzemeler:</label><textarea class="form-control" id="ingredients" name="ingredients" rows="5" required></textarea></div>
                <div class="mb-3"><label for="instructions" class="form-label">Hazırlanışı:</label><textarea class="form-control" id="instructions" name="instructions" rows="7" required></textarea></div>
                <div class="row">
                    <div class="col-md-4 mb-3"><label for="prep_time" class="form-label">Hazırlık Süresi (Dakika):</label><input type="number" class="form-control" id="prep_time" name="prep_time" min="0"></div>
                    <div class="col-md-4 mb-3"><label for="cook_time" class="form-label">Pişirme Süresi (Dakika):</label><input type="number" class="form-control" id="cook_time" name="cook_time" min="0"></div>
                    <div class="col-md-4 mb-3"><label for="servings" class="form-label">Kaç Kişilik:</label><input type="number" class="form-control" id="servings" name="servings" min="1"></div>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100"><i class="bi bi-check-circle"></i> Tarifi Kaydet</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>