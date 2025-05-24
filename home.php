<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$active_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .wrapper { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); margin-top: 30px;}
        .welcome-msg b { color: #6a1b9a; }
        .content h2 { margin-top: 30px; }
        .navbar-brand { font-weight: bold; color: #6a1b9a !important; }
        .navbar-nav .nav-link.active { color: #6a1b9a !important; font-weight: bold; border-bottom: 2px solid #6a1b9a; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php">Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'home.php') ? 'active' : ''; ?>" href="home.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($active_page == 'recipes.php' || $active_page == 'add_recipe.php') ? 'active' : ''; ?>" href="recipes.php">Tarifler</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#">Diyet Menüleri</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kaç Kalori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Haberler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Hakkımızda</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3 welcome-msg">Merhaba, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</span>
                    <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="wrapper">
            <h1 class="mb-4">Yemek Tarifleri Dünyasına Hoş Geldiniz!</h1>
            <div class="content text-center">
                <h2>Bugün Ne Pişirsem?</h2>
                <p class="lead">En lezzetli ve pratik tarifler için doğru adrestesiniz. Sitemizde binlerce tarifi keşfedebilir, kendi tariflerinizi ekleyebilir ve mutfakta harikalar yaratabilirsiniz!</p>
                <p>Yukarıdaki menüden dilediğiniz bölüme gidebilirsiniz.</p>
                <a href="recipes.php" class="btn btn-primary btn-lg mt-3">Tarifleri Keşfet!</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>