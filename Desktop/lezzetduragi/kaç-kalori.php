<?php
    // Sayfa özel değişkenleri
    $pageTitle = "Kaç Kalori?"; 
    $pageDescription = "Yiyeceklerin kalori değerlerini hesaplayın ve sağlıklı beslenme hedeflerinize ulaşın.";

    // Header'ı dahil et
    include 'includes/header.php'; 
?>

<main>
    <header class="page-header">
        <div class="container">
            <h1>Besin Değerleri ve Kalori Hesaplayıcı</h1>
            <p>Yediğiniz yiyeceklerin yaklaşık kalori ve besin değerlerini öğrenin.</p>
        </div>
    </header>

    <section class="section section-light">
        <div class="container calorie-calculator-container">

            <h2 class="section-title">Kalori Hesaplayıcı</h2>

            <div class="calculator-form">
                <div class="form-group">
                    <label for="food-search">Yiyecek Arayın:</label>
                    <input type="text" id="food-search" placeholder="Örn: Elma, Tavuk Göğsü, Pilav...">
                    <button id="search-btn" class="btn">Ara</button>
                </div>

                <div class="form-group">
                    <label for="food-select">Veya Listeden Seçin:</label>
                    <select id="food-select">
                        <option value="">-- Yiyecek Seçin --</option>
                        <option value="elma">Elma (1 adet orta boy)</option>
                        <option value="muz">Muz (1 adet orta boy)</option>
                        <option value="tavuk">Tavuk Göğsü (100g, haşlanmış)</option>
                        <option value="pilav">Pirinç Pilavı (100g)</option>
                        <option value="yumurta">Yumurta (1 adet, haşlanmış)</option>
                        <option value="ekmek">Beyaz Ekmek (1 dilim)</option>
                        <option value="badem">Badem (20 adet)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="food-amount">Miktar (gram veya adet):</label>
                    <input type="number" id="food-amount" value="100" min="1">
                </div>

                <button id="calculate-btn" class="btn btn-primary">Hesapla</button>
            </div>

            <div id="calorie-result" class="calculator-result">
                <h3>Sonuç:</h3>
                <p>Lütfen bir yiyecek seçin veya arayın ve hesapla butonuna tıklayın.</p>
                </div>

            <div class="info-box">
                <h4>Önemli Not:</h4>
                <p>Burada gösterilen kalori değerleri **yaklaşık** değerlerdir ve kullanılan malzemeye, pişirme yöntemine göre değişiklik gösterebilir. Bu araç sadece bilgilendirme amaçlıdır ve profesyonel tıbbi veya diyetisyen tavsiyesi yerine geçmez.</p>
            </div>

        </div>
    </section>
</main>

<?php 
    // Footer'ı dahil et
    include 'includes/footer.php'; 
?>