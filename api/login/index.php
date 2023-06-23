<?php

// Veri Tabanı bağlantısı!
include '../../veritabanı.php';

// Kullanıcı adı ve şifre POST isteğiyle alınır
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Şifre MD5 ile şifrelenir
    $hpassword = md5($password);

    // Veritabanında kullanıcıyı sorgula
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hpassword'";
    $result = mysqli_query($conn, $query);

    // Sorgu sonucuna göre doğrulama yapılır
    if (mysqli_num_rows($result) > 0) {
        // Kullanıcı doğrulandı
        die("true");
    } else {
        // Kullanıcı doğrulanamadı
        die("false");
    }
} else {
    // Kullanıcı adı veya şifre POST isteğiyle gönderilmemiş
    die("error");
}

?>
