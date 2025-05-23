<?php
// Aktif sayfayı belirlemek için bir helper fonksiyon veya değişken kullanılabilir.
// Şimdilik basit tutalım ve ana dosyalarda $currentPage değişkenini tanımlayalım.
// Örneğin, index.php'de $currentPage = 'anasayfa'; gibi.
// Bu değişkeni burada kullanarak 'active' class'ını dinamik olarak atayabiliriz.
// Veya daha basit bir yol olarak, her ana sayfada navbar'ı manuel olarak 'active' class'ı ile çağırabiliriz.
// Şimdilik en son kullandığımız ve $currentPage'e ihtiyaç duymayan yapıyı koruyalım.
// Dinamik 'active' class ataması için daha sonra bir geliştirme yapılabilir.

// Temel URL'yi tanımlayalım (Eğer projeniz bir alt klasördeyse, onu belirtin. Örn: /lezzetduragi/)
// Bu, config.php dosyasında veya her sayfanın başında tanımlanabilir.
// Şimdilik basit olması için linkleri göreceli bırakıyorum, ancak BASE_URL en iyi pratiktir.
// define('BASE_URL', '/'); // Eğer ana dizindeyse
?>
<nav class="navbar">
    <div class="container">
        <a href="index.php" class="logo">Lezzet Durağı <span role="img" aria-label="yemek tenceresi">🍲</span></a>
        <button class="menu-toggle" id="mobile-menu" aria-label="Menüyü aç/kapat">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="nav-links" id="nav-links-list">
            <li><a href="index.php" class="<?php echo ($pageTitle === "Lezzet Durağı - En İyi Yemek Tarifleri" ? 'active' : ''); ?>">Ana Sayfa</a></li>
            <li><a href="tarifler.php" class="<?php echo ($pageTitle === "Tüm Tarifler - Lezzet Durağı" ? 'active' : ''); ?>">Tarifler</a></li>
            <li><a href="kategoriler.php" class="<?php echo ($pageTitle === "Kategoriler - Lezzet Durağı" ? 'active' : ''); ?>">Kategoriler</a></li>
            <li><a href="kac-kalori.php" class="<?php echo ($pageTitle === "Kaç Kalori? - Lezzet Durağı" ? 'active' : ''); ?>">Kaç Kalori?</a></li>
            <li><a href="diyet-menuleri.php" class="<?php echo ($pageTitle === "Diyet Menüleri - Lezzet Durağı" ? 'active' : ''); ?>">Diyet Menüleri</a></li>
            <li><a href="hakkimizda.php" class="<?php echo ($pageTitle === "Hakkımızda - Lezzet Durağı" ? 'active' : ''); ?>">Hakkımızda</a></li>
        </ul>
        <div class="auth-links">
            <a href="login.php" class="btn btn-outline">Giriş Yap</a>
            <a href="register.php" class="btn">Kayıt Ol</a>
        </div>
    </div>
</nav>