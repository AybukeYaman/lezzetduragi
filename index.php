<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Giriş & Kayıt Sayfası | Yemek Tarifleri</title>
</head>

<body>
    <?php
    // Hata veya başarı mesajlarını göstermek için
    if (isset($_GET['error'])) {
        echo '<p style="color:red; text-align:center; margin-top:10px;">' . htmlspecialchars($_GET['error']) . '</p>';
    }
    if (isset($_GET['success'])) {
        echo '<p style="color:green; text-align:center; margin-top:10px;">' . htmlspecialchars($_GET['success']) . '</p>';
    }
    ?>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="register.php" method="POST">
                <h1>Hesap Oluştur</h1>
                <div class="social-icons">
                </div>
                <span>veya kayıt için e-postanızı kullanın</span>
                <input type="text" placeholder="İsim" name="name" required> <input type="email" placeholder="E-posta"
                    name="email" required> <input type="password" placeholder="Şifre" name="password" required> <button
                    type="submit">Kayıt Ol</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="login.php" method="POST">
                <h1>Giriş Yap</h1>
                <div class="social-icons">
                </div>
                <span>veya e-posta ve şifrenizi kullanın</span>
                <input type="email" placeholder="E-posta" name="email" required> <input type="password"
                    placeholder="Şifre" name="password" required> <a href="#">Şifrenizi mi unuttunuz?</a> <button
                    type="submit">Giriş Yap</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Tekrar Hoş Geldiniz!</h1>
                    <p>Site özelliklerini kullanmak için kişisel bilgilerinizle giriş yapın.</p>
                    <button class="hidden" id="login">Giriş Yap</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Merhaba, Arkadaş!</h1>
                    <p>Site özelliklerini kullanmak için kişisel bilgilerinizle kayıt olun.</p>
                    <button class="hidden" id="register">Kayıt Ol</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>