<?php
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
$active_page = basename($_SERVER['PHP_SELF']);
$sql = "SELECT r.id, r.title, r.description, r.image_path, u.name as author_name 
        FROM recipes r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.created_at DESC";
$stmt = $pdo->query($sql);
$recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

function get_image_path_recipes($path) { // Farklı bir isim verdim ki çakışmasın
    $full_path = 'images/' . htmlspecialchars($path);
    return (!empty($path) && file_exists($full_path)) ? $full_path : 'images/default.jpg';
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifler - Lezzet Durağı</title>
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
        .recipe-card { transition: transform 0.2s ease, box-shadow 0.2s ease; height: 100%; border-radius: 10px; border: 1px solid #eee; }
        .recipe-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
        .recipe-card img { height: 200px; object-fit: cover; border-radius: 10px 10px 0 0; }
        .recipe-card .card-text { font-size: 0.9em; color: #555; }
        .recipe-card .author { font-size: 0.8em; color: #777; }
        .btn-success { background-color: #4CAF50; border-color: #4CAF50; } /* Yeşil kalsın */
        .btn-success:hover { background-color: #45a049; border-color: #45a049; }
        .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
        .btn-outline-primary:hover { background-color: var(--primary-color); color: #fff; }
        .btn-outline-secondary { color: #555; border-color: #ccc; }
        .btn-outline-secondary:hover { background-color: #555; color: #fff; }
        .btn-outline-danger { color: #dc3545; border-color: #dc3545; }
        .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="font-family: 'Playfair Display', serif;">Tüm Tarifler</h1>
            <a href="add_recipe.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Yeni Tarif Ekle</a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php if (empty($recipes)): ?>
                <div class="col-12"><div class="alert alert-info">Henüz tarif yok.</div></div>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col">
                        <div class="card h-100 recipe-card">
                            <img src="<?php echo get_image_path_recipes($recipe['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                <p class="card-text author"><small class="text-muted"><i class="bi bi-person"></i> <?php echo htmlspecialchars($recipe['author_name']); ?></small></p>
                                <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($recipe['description'], 0, 100)) . '...'; ?></p>
                                <div class="btn-group mt-auto w-100">
                                    <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Detay</a>
                                    <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i> Düzenle</a>
                                    <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu tarifi silmek istediğinizden emin misiniz?');"><i class="bi bi-trash"></i> Sil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>