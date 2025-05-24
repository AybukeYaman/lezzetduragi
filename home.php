<?php
session_start();
require_once 'config.php'; // Veritabanı bağlantısı için

// Kullanıcı giriş yapmamışsa, index.php'ye yönlendir
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$active_page = basename($_SERVER['PHP_SELF']);

// Ana sayfa için en son eklenen 4 tarifi çek
$sql_latest = "SELECT r.id, r.title, r.image_path, u.name as author_name 
               FROM recipes r 
               JOIN users u ON r.user_id = u.id 
               ORDER BY r.created_at DESC LIMIT 4";
$stmt_latest = $pdo->query($sql_latest);
$latest_recipes = $stmt_latest->fetchAll(PDO::FETCH_ASSOC);

// Eğer tarif yoksa veya resim yolu boşsa default.jpg kullanmak için fonksiyon
function get_image_path($path) {
    $trimmed_path = trim($path); // Önce boşlukları temizle
    $full_path = 'images/' . htmlspecialchars($trimmed_path);
    // Resim yolu boşsa veya dosya yoksa default kullan
    if (empty($trimmed_path) || !file_exists($full_path)) {
        return 'images/default.jpg';
    }
    return $full_path;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ana Sayfa - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #D81B60; /* Koyu Pembe Ana Renk */
            --primary-hover: #b0154c; /* Koyu Pembenin Hover Hali */
            --secondary-color: #2c3e50; 
            --background-color: #f9f6f7; /* Hafif pembe tonlu gri */
            --text-color: #333;
            --card-background: #fff;
            --navbar-background: #fff;
        }

        body { 
            padding-top: 56px; /* Navbar sabit olduğu için */
            background-color: var(--background-color); 
            font-family: 'Poppins', sans-serif; 
        }
        .navbar { 
            background-color: var(--navbar-background); 
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); 
            font-family: 'Poppins', sans-serif;
        }
        .navbar-brand { 
            font-family: 'Playfair Display', serif; 
            font-weight: 700;
            color: var(--primary-color) !important; 
            font-size: 1.6em;
        }
        .navbar-nav .nav-link { 
            color: #555; 
            font-weight: 600;
            margin: 0 5px;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active { 
            color: var(--primary-color) !important; 
        }
        .btn-primary { 
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }
         .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('images/hero_background.jpg'); 
            background-size: cover; background-position: center; padding: 7rem 0; text-align: center;
            color: #fff; border-radius: 0 0 25px 25px; margin-bottom: 50px;
        }
        .hero-section h1 { font-family: 'Playfair Display', serif; font-size: 3.2em; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); }
        .hero-section p { font-size: 1.2em; margin-bottom: 30px; font-weight: 300; }
        .hero-section .input-group .form-control { border-radius: 25px 0 0 25px; border: none; padding: 0.75rem 1.5rem; }
        .hero-section .input-group .btn { border-radius: 0 25px 25px 0; background-color: var(--primary-color); border-color: var(--primary-color); padding: 0.75rem 1.5rem; }
        .hero-section .input-group .btn:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }

        /* Başlıklar için genel stil */
        .section-title { 
            text-align: center; margin-bottom: 40px; margin-top: 40px; 
            font-family: 'Playfair Display', serif; color: var(--text-color); 
            position: relative; padding-bottom: 10px; 
        }
        .section-title::after { 
            content: ''; display: block; width: 80px; height: 3px; 
            background-color: var(--primary-color); margin: 10px auto 0; 
        }

        /* Kategori Bölümü */
        .category-card { text-align: center; border: none; background: none; transition: transform 0.3s ease; }
        .category-card:hover { transform: scale(1.05); }
        .category-card img { 
            width: 140px; height: 140px; object-fit: cover; border-radius: 50%; 
            margin-bottom: 15px; border: 5px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        .category-card .card-title { font-weight: 600; color: var(--text-color); font-size: 1.1em; }

        /* Tarif Kartları */
        .recipe-card { 
            background-color: var(--card-background); border: 1px solid #eee; border-radius: 10px; 
            overflow: hidden; transition: box-shadow 0.3s ease; height: 100%; 
        }
        .recipe-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .recipe-card img { height: 200px; object-fit: cover; }
        .recipe-card .card-body a { text-decoration: none; color: var(--text-color); }
        .recipe-card .card-title:hover { color: var(--primary-color); }
        .recipe-card .author { font-size: 0.9em; }

        /* Footer */
        .footer { background-color: #343a40; color: #ccc; padding: 25px 0; margin-top: 60px; text-align: center; font-size: 0.9em; }
        .footer a { color: var(--primary-color); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="home.php"><i class="bi bi-egg-fried"></i> Lezzet Durağı</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'home.php') ? 'active' : ''; ?>" href="home.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'recipes.php' || $active_page == 'add_recipe.php') ? 'active' : ''; ?>" href="recipes.php">Tarifler</a></li>
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

    <section class="hero-section">
        <div class="container">
            <h1>Mutfaktaki Yeni Maceranız Başlıyor!</h1>
            <p>Binlerce tarif arasından aradığınızı bulun, kendi tariflerinizi paylaşın.</p>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <form action="recipes.php" method="GET"> 
                        <div class="input-group">
                            <input type="text" name="search_query" class="form-control form-control-lg" placeholder="Örn: Mercimek Çorbası, Brownie...">
                            <button class="btn btn-lg" type="submit"><i class="bi bi-search"></i> Ara</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <section class="category-section mb-5">
            <h2 class="section-title">Kategorileri Keşfedin</h2>
            <div class="row text-center g-4">
                <div class="col-6 col-sm-6 col-md-3">
                    <div class="card category-card">
                        <a href="recipes.php?category=salads"> 
                            <img src="images/category_salads.jpg" alt="Salatalar">
                        </a>
                        <div class="card-body">
                           <h5 class="card-title"><a href="recipes.php?category=salads" class="text-decoration-none text-dark">Salatalar</a></h5>
                        </div>
                    </div>
                </div>
                 <div class="col-6 col-sm-6 col-md-3">
                    <div class="card category-card">
                        <a href="recipes.php?category=main">
                            <img src="images/category_main.jpg" alt="Ana Yemekler">
                        </a>
                        <div class="card-body">
                           <h5 class="card-title"><a href="recipes.php?category=main" class="text-decoration-none text-dark">Ana Yemekler</a></h5>
                        </div>
                    </div>
                </div>
                 <div class="col-6 col-sm-6 col-md-3">
                    <div class="card category-card">
                         <a href="recipes.php?category=soups">
                            <img src="images/category_soups.jpg" alt="Çorbalar">
                         </a>
                        <div class="card-body">
                           <h5 class="card-title"><a href="recipes.php?category=soups" class="text-decoration-none text-dark">Çorbalar</a></h5>
                        </div>
                    </div>
                </div>
                 <div class="col-6 col-sm-6 col-md-3">
                    <div class="card category-card">
                        <a href="recipes.php?category=desserts">
                            <img src="images/category_desserts.jpg" alt="Tatlılar">
                        </a>
                        <div class="card-body">
                           <h5 class="card-title"><a href="recipes.php?category=desserts" class="text-decoration-none text-dark">Tatlılar</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="latest-recipes">
            <h2 class="section-title">Son Eklenen Lezzetler</h2>
             <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php if (empty($latest_recipes)): ?>
                    <div class="col-12">
                        <p class="alert alert-info">Henüz tarif yok. <a href="add_recipe.php" class="alert-link">İlk tarifi siz ekleyin!</a></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($latest_recipes as $recipe): ?>
                    <div class="col">
                        <div class="card recipe-card">
                            <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>">
                                <img src="<?php echo get_image_path($recipe['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>" class="text-decoration-none">
                                        <?php echo htmlspecialchars($recipe['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text author"><small class="text-muted"><i class="bi bi-person"></i> <?php echo htmlspecialchars($recipe['author_name']); ?></small></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
             <div class="text-center mt-4">
                <a href="recipes.php" class="btn btn-outline-primary">Tüm Tarifleri Gör <i class="bi bi-arrow-right-short"></i></a>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> Lezzet Durağı - Tüm Hakları Saklıdır.</p>
        </div>
    </footer>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>