<?php
// Eğer bir config dosyanız varsa burada include edebilirsiniz.
// define('BASE_URL', '/'); // veya projenizin alt klasör yolu

// $pageTitle değişkeni bu dosyadan önce ana PHP dosyasında tanımlanmalıdır.
// Örnek: <?php $pageTitle = "Ana Sayfa - Lezzet Durağı"; include 'includes/header.php'; >
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : "Lezzet Durağı"; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? htmlspecialchars($pageDescription) : "Binlerce denenmiş, lezzetli ve pratik yemek tarifleri."; ?>">
    
    <link rel="stylesheet" href="assets/css/style.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
</head>
<body>

<?php include 'navbar.php'; // Navbar'ı burada çağırıyoruz ?>