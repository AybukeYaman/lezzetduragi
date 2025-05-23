<?php
// Oturumu başlat (her zaman en başta olmalı)
session_start();

// Kullanıcı giriş yapmamışsa, index.php'ye yönlendir
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit; // Betiğin çalışmasını durdur
}

// Hangi sayfanın aktif olduğunu belirlemek için (şimdilik sadece home.php)
$active_page = basename($_SERVER['PHP_SELF']); // Mevcut dosya adını alır (örn: home.php)

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - Yemek Tarifleri</title>
    <style>
        /* Genel Stil Ayarları */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa; /* Açık gri arka plan */
            color: #333;
        }

        /* Ana İçerik Kapsayıcısı */
        .wrapper {
            max-width: 1200px;
            margin: 20px auto; /* Üstten ve alttan boşluk, ortalama */
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Başlık Stilleri */
        h1, h2 {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Üst Başlık Alanı (Karşılama ve Çıkış Butonu) */
        .header-area {
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
            overflow: hidden; /* float'tan etkilenmeyi önler */
            display: flex; /* Flexbox ile hizalama */
            justify-content: space-between; /* Öğeleri aralıklı dağıt */
            align-items: center; /* Dikeyde ortala */
        }

        /* Karşılama Mesajı */
        .welcome-msg {
            font-size: 1.1em;
        }
        .welcome-msg b {
            color: #6a1b9a; /* Mor renk */
        }

        /* Navigasyon Menüsü */
        nav {
            background-color: #e9ecef; /* Biraz daha koyu gri */
            padding: 15px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        nav ul li {
            display: inline;
            margin: 0 20px; /* Linkler arası daha fazla boşluk */
        }
        nav ul li a {
            text-decoration: none;
            color: #343a40; /* Koyu gri renk */
            font-weight: bold;
            font-size: 1.1em;
            padding: 8px 15px;
            transition: all 0.3s ease; /* Yumuşak geçiş efekti */
            border-radius: 4px;
        }
        /* Link üzerine gelince ve aktifken stil */
        nav ul li a:hover,
        nav ul li a.active {
            color: #fff; /* Beyaz yazı */
            background-color: #6a1b9a; /* Mor arka plan */
        }

        /* Çıkış Yap Butonu */
        .logout-btn {
            background-color: #dc3545; /* Kırmızı */
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .logout-btn:hover {
            background-color: #c82333; /* Koyu kırmızı */
        }

        /* İçerik Alanı */
        .content {
            margin-top: 20px;
            line-height: 1.6;
            text-align: center; /* İçeriği ortaladım */
        }

    </style>
</head>
<body>

    <div class="wrapper">
        <div class="header-area">
             <div class="welcome-msg">
                Merhaba, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!
            </div>
            <a href="logout.php" class="logout-btn">Çıkış Yap</a>
        </div>

        <h1>Yemek Tarifleri Dünyasına Hoş Geldiniz!</h1>

        <nav>
            <ul>
                <li><a href="home.php" class="<?php echo ($active_page == 'home.php') ? 'active' : ''; ?>">Ana Sayfa</a></li>
                <li><a href="recipes.php" class="<?php echo ($active_page == 'recipes.php') ? 'active' : ''; ?>">Tarifler</a></li>
                <li><a href="diet_menus.php" class="<?php echo ($active_page == 'diet_menus.php') ? 'active' : ''; ?>">Diyet Menüleri</a></li>
                <li><a href="calories.php" class="<?php echo ($active_page == 'calories.php') ? 'active' : ''; ?>">Kaç Kalori</a></li>
                <li><a href="news.php" class="<?php echo ($active_page == 'news.php') ? 'active' : ''; ?>">Haberler</a></li>
                <li><a href="about.php" class="<?php echo ($active_page == 'about.php') ? 'active' : ''; ?>">Hakkımızda</a></li>
            </ul>
        </nav>

        <div class="content">
            <h2>Bugün Ne Pişirsem?</h2>
            <p>En lezzetli ve pratik tarifler için doğru adrestesiniz. Sitemizde binlerce tarifi keşfedebilir, kendi tariflerinizi ekleyebilir ve mutfakta harikalar yaratabilirsiniz!</p>
            <p>Yukarıdaki menüden dilediğiniz bölüme gidebilirsiniz.</p>
        </div>

    </div>

</body>
</html>