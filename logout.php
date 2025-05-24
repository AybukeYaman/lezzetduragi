<?php
// Oturumu başlat
session_start();

// Tüm oturum değişkenlerini temizle
$_SESSION = array();

// Oturumu yok et
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendir
header("location: index.php");
exit;
?>