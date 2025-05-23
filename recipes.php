<?php
// Oturumu başlat ve config dosyasını dahil et
require_once 'config.php';

// Kullanıcı giriş yapmamışsa, index.php'ye yönlendir
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// Aktif sayfayı belirle
$active_page = basename($_SERVER['PHP_SELF']);

// Tarifleri veritabanından çek
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
    <title>Tarifler - Yemek Tarifleri</title>
    <style>
        body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; }
        .wrapper { max-width: 1200px; margin: 20px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1, h2 { color: #4a4a4a; text-align: center; }
        .header-area { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 25px; overflow: hidden; display: flex; justify-content: space-between; align-items: center; }
        .welcome-msg { font-size: 1.1em; } .welcome-msg b { color: #6a1b9a; }
        nav { background-color: #e9ecef; padding: 15px 0; text-align: center; margin-bottom: 30px; border-radius: 5px; }
        nav ul { list-style: none; padding: 0; margin: 0; } nav ul li { display: inline; margin: 0 20px; }
        nav ul li a { text-decoration: none; color: #343a40; font-weight: bold; font-size: 1.1em; padding: 8px 15px; transition: all 0.3s ease; border-radius: 4px; }
        nav ul li a:hover, nav ul li a.active { color: #fff; background-color: #6a1b9a; }
        .logout-btn { background-color: #dc3545; color: white; padding: 10px 18px; border: none; border-radius: 4px; text-decoration: none; font-size: 1em; cursor: pointer; }
        .logout-btn:hover { background-color: #c82333; }
        .add-recipe-link { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .add-recipe-link:hover { background-color: #218838; }
        .recipe-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .recipe-card { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: transform 0.2s ease; }
        .recipe-card:hover { transform: translateY(-5px); }
        .recipe-card img { max-width: 100%; height: 200px; object-fit: cover; }
        .recipe-card-content { padding: 15px; }
        .recipe-card h3 { margin-top: 0; margin-bottom: 10px; font-size: 1.3em; }
        .recipe-card p { font-size: 0.9em; color: #555; margin-bottom: 15px; }
        .recipe-card .author { font-size: 0.8em; color: #777; margin-bottom: 15px; }
        .recipe-card .actions a { margin-right: 10px; text-decoration: none; color: #007bff; }
        .recipe-card .actions a.delete { color: #dc3545; }
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

        <h1>Yemek Tarifleri</h1>

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

        <a href="add_recipe.php" class="add-recipe-link">Yeni Tarif Ekle +</a>

        <div class="recipe-list">
            <?php if (empty($recipes)): ?>
                <p>Henüz hiç tarif eklenmemiş. İlk tarifi eklemek için yukarıdaki linki kullanabilirsiniz!</p>
            <?php else: ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card">
                        <img src="images/<?php echo htmlspecialchars($recipe['image_path']); ?>" alt="<?php echo htmlspecialchars($recipe['title']); ?>">
                        <div class="recipe-card-content">
                            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
                            <p class="author">Ekleyen: <?php echo htmlspecialchars($recipe['author_name']); ?></p>
                            <p><?php echo htmlspecialchars(substr($recipe['description'], 0, 100)) . '...'; // Açıklamanın ilk 100 karakteri ?></p>
                            <div class="actions">
                                <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>">Detaylar</a>
                                <a href="edit_recipe.php?id=<?php echo $recipe['id']; ?>">Düzenle</a>
                                <a href="delete_recipe.php?id=<?php echo $recipe['id']; ?>" class="delete" onclick="return confirm('Bu tarifi silmek istediğinizden emin misiniz?');">Sil</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>