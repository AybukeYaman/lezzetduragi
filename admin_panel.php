<?php
session_start();
require_once 'config.php';

// Kullanıcı giriş yapmamışsa VEYA admin değilse, ana sayfaya yönlendir
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || !isset($_SESSION["role"]) || $_SESSION["role"] !== 'admin') {
    header("location: home.php");
    exit;
}

$active_page = 'admin_panel.php'; 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #D81B60; }
        body { padding-top: 70px; background-color: #f9f6f7; font-family: 'Poppins', sans-serif; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .navbar-brand { font-family: 'Playfair Display', serif; font-weight: 700; color: var(--primary-color) !important; font-size: 1.6em; }
        .navbar-nav .nav-link { color: #555; font-weight: 600; }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary-color) !important; }
        .wrapper { background-color: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); margin-top: 30px;}
        .navbar-nav .nav-link.bg-warning.active { color: #000 !important; font-weight: bold; } /* Admin linki aktifken */
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top"> <div class="container">
            <a class="navbar-brand" href="home.php"><i class="bi bi-egg-fried"></i> Lezzet Durağı (Admin)</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="home.php" target="_blank">Siteyi Görüntüle</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kullanıcılar</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tarifler</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kategoriler</a></li>
                    <li class="nav-item">
                        <a class="nav-link bg-warning text-dark rounded px-2 <?php echo ($active_page == 'admin_panel.php') ? 'active' : ''; ?>" href="admin_panel.php">Admin Paneli</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="navbar-text me-3">Admin: <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="wrapper">
            <h1 class="text-center" style="font-family: 'Playfair Display', serif;">Admin Kontrol Paneli</h1>
            <p class="text-center lead">Hoş geldiniz, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</p>
            <hr>
            <p>Bu alanda site yönetimi ile ilgili işlemler yer alacaktır. Aşağıdaki linkleri kullanarak ilgili bölümlere gidebilirsiniz:</p>
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-people-fill me-2"></i>Kullanıcı Yönetimi</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-book-fill me-2"></i>Tarif Yönetimi</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-tags-fill me-2"></i>Kategori Yönetimi</a>
                <a href="#" class="list-group-item list-group-item-action"><i class="bi bi-chat-dots-fill me-2"></i>Yorum Yönetimi</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>