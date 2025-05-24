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
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarifler - Lezzet Durağı</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { padding-top: 70px; background-color: #f8f9fa; }
        .navbar { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar-brand { font-weight: bold; color: #6a1b9a !important; }
        .navbar-nav .nav-link.active { color: #6a1b9a !important; font-weight: bold; border-bottom: 2px solid #6a1b9a; }
        .recipe-card { transition: transform 0.2s ease, box-shadow 0.2s ease; height: 100%; }
        .recipe-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.15); }
        .recipe-card img { height: 200px; object-fit: cover; }
        .recipe-card .card-text { font-size: 0.9em; color: #555; }
        .recipe-card .author { font-size: 0.8em; color: #777; }
        .recipe-card .btn-group a { margin-right: 5px; }
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
                    <li class="nav-item"><a class="nav-link <?php echo ($active_page == 'recipes.php' || $active_page == 'add_recipe.php') ? 'active' : ''; ?>" href="recipes.php">Tarifler</a></li>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tüm Tarifler</h1>
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
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        Henüz hiç tarif eklenmemiş. İlk tarifi eklemek için yukarıdaki butonu kullanabilirsiniz!
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="col">
                        <div class="card h-100 recipe-card">
                            <img src="images/<?php echo htmlspecialchars($recipe['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo htmlspecialchars($recipe['title']); ?></h5>
                                <p class="card-text author">Ekleyen: <?php echo htmlspecialchars($recipe['author_name']); ?></p>
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