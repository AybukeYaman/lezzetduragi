<?php 
// index.php (Ana Sayfa Örneği - Bu dosyayı projenizin ana dizinine kaydedin)

// Sayfa özel değişkenleri header.php'den önce tanımlayın
$pageId = 'anasayfa'; // Navbar'da aktif linki belirlemek için
$pageTitle = "Lezzet Durağı - En İyi Yemek Tarifleri"; 
$pageDescription = "Binlerce denenmiş, lezzetli ve pratik yemek tarifleri Lezzet Durağı'nda. Mutfaktaki yardımcınız!";
// $bodyClass = 'homepage'; // Opsiyonel: Sadece bu sayfaya özel bir body class'ı eklemek için

include 'includes/header.php'; 
?>

<main>
    <section class="hero" style="background-image: url('assets/images/hero-bg.jpg');"> 
        <div class="hero-content">
            <h1>Mutfaktaki Yeni Maceranız Başlasın!</h1>
            <p>Binlerce denenmiş, fotoğraflı ve pratik yemek tarifini keşfedin. Her güne özel bir lezzet bulun.</p>
            <a href="tarifler.php" class="btn btn-primary btn-lg">Tarifleri Keşfet</a>
        </div>
    </section>

    <section id="popular-recipes" class="section section-light">
        <div class="container">
            <h2 class="section-title">Popüler Tarifler</h2>
            <div class="recipe-grid">
                <article class="recipe-card">
                    <a href="tarif-detay.php?id=1" aria-label="Karnıyarık tarifine git">
                        <img src="assets/images/placeholder-400x300.png" alt="Karnıyarık Tarifi"> </a>
                    <div class="recipe-card-content">
                        <h3><a href="tarif-detay.php?id=1">Karnıyarık</a></h3>
                        <p class="description">Türk mutfağının vazgeçilmezi, doyurucu ve lezzetli bir ana yemek.</p>
                        <div class="recipe-meta">
                            <span><i class="fas fa-clock"></i> 60 dk</span>
                            <span><i class="fas fa-utensils"></i> 4 Kişilik</span>
                        </div>
                        <a href="tarif-detay.php?id=1" class="btn">Tarife Git</a>
                    </div>
                </article>
                
                <article class="recipe-card">
                     <a href="tarif-detay.php?id=2" aria-label="Mercimek Çorbası tarifine git">
                        <img src="assets/images/placeholder-400x300.png" alt="Mercimek Çorbası"> </a>
                    <div class="recipe-card-content">
                        <h3><a href="tarif-detay.php?id=2">Mercimek Çorbası</a></h3>
                        <p class="description">Herkesin sevdiği, pratik ve besleyici klasik bir başlangıç.</p>
                         <div class="recipe-meta">
                            <span><i class="fas fa-clock"></i> 30 dk</span>
                            <span><i class="fas fa-utensils"></i> 6 Kişilik</span>
                        </div>
                        <a href="tarif-detay.php?id=2" class="btn">Tarife Git</a>
                    </div>
                </article>

                <article class="recipe-card">
                    <a href="tarif-detay.php?id=3" aria-label="Çikolatalı Sufle tarifine git">
                        <img src="assets/images/placeholder-400x300.png" alt="Çikolatalı Sufle"> </a>
                    <div class="recipe-card-content">
                        <h3><a href="tarif-detay.php?id=3">Çikolatalı Sufle</a></h3>
                        <p class="description">Akışkan iç dolgusuyla tatlı krizlerinin en lezzetli çözümü.</p>
                         <div class="recipe-meta">
                            <span><i class="fas fa-clock"></i> 25 dk</span>
                            <span><i class="fas fa-utensils"></i> 2 Kişilik</span>
                        </div>
                        <a href="tarif-detay.php?id=3" class="btn">Tarife Git</a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section id="categories" class="section section-dark">
        <div class="container">
            <h2 class="section-title">Kategorilere Göz Atın</h2>
            <div class="category-list">
                <span class="category-item"><a href="kategoriler.php?kategori=corbalar">Çorbalar</a></span>
                <span class="category-item"><a href="kategoriler.php?kategori=ana-yemekler">Ana Yemekler</a></span>
                <span class="category-item"><a href="kategoriler.php?kategori=tatlilar">Tatlılar</a></span>
                <span class="category-item"><a href="kategoriler.php?kategori=salatalar">Salatalar & Mezeler</a></span>
                <span class="category-item"><a href="kategoriler.php?kategori=hamur-isleri">Hamur İşleri</a></span>
                <span class="category-item"><a href="kategoriler.php?kategori=icecekler">İçecekler</a></span>
            </div>
        </div>
    </section>

    <section id="about-snippet" class="section section-light">
        <div class="container about-section">
            <h2 class="section-title">Lezzet Durağı'na Hoş Geldiniz!</h2>
            <p>
                Lezzet Durağı, yemek yapmayı seven herkes için bir buluşma noktasıdır. Burada binlerce denenmiş tarifi keşfedebilir, kendi tariflerinizi paylaşabilir ve mutfak sırlarını öğrenebilirsiniz. Amacımız, herkesin mutfakta harikalar yaratmasına yardımcı olmaktır. Afiyet olsun!
            </p>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
