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
    <style>
        body { padding-top: 70px; background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: bold; color: #6a1b9a !important; }
        .navbar-nav .nav-link.active { color: #6a1b9a !important; font-weight: bold; border-bottom: 2px solid #6a1b9a; }
        .wrapper { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-top: 30px;}
        .form-label { font-weight: bold; }
        .btn-success { background-color: #28a745; border-color: #28a745; }
        .btn-success:hover { background-color: #218838; border-color: #1e7e34; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
       <div class="container">
            <a class="navbar-brand" href="home.php">Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'home.php') ? 'active' : ''; ?>" href="home.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'recipes.php') ? 'active' : ''; ?>" href="recipes.php">Tarifler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Diyet Menüleri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kaç Kalori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hakkımızda</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3">Merhaba, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</span>
                    <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5 py-4">
        <div class="wrapper">
            <h2 class="text-center mb-4">Yeni Tarif Ekle</h2>

            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="handle_add_recipe.php" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label"><i class="bi bi-type"></i> Tarif Başlığı:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label"><i class="bi bi-card-text"></i> Açıklama:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label"><i class="bi bi-basket"></i> Malzemeler (Her satıra bir malzeme):</label>
                    <textarea class="form-control" id="ingredients" name="ingredients" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="instructions" class="form-label"><i class="bi bi-list-ol"></i> Hazırlanışı:</label>
                    <textarea class="form-control" id="instructions" name="instructions" rows="7" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="prep_time" class="form-label"><i class="bi bi-clock"></i> Hazırlık Süresi (Dakika):</label>
                        <input type="number" class="form-control" id="prep_time" name="prep_time" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="cook_time" class="form-label"><i class="bi bi-stopwatch"></i> Pişirme Süresi (Dakika):</label>
                        <input type="number" class="form-control" id="cook_time" name="cook_time" min="0">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="servings" class="form-label"><i class="bi bi-people"></i> Kaç Kişilik:</label>
                        <input type="number" class="form-control" id="servings" name="servings" min="1">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100"><i class="bi bi-check-circle"></i> Tarifi Kaydet</button>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>