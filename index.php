<?php
session_start();

// kullanıcı giriş yapmış mı kontrol ediyoruz
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"]) && !isset($_SESSION["email"])) {
    header("Location: giris-yap.php");
    exit();
}
// Veritabanı bağlantısı

if (isset($_SESSION["id"]) && isset($_SESSION["username"]) && isset($_SESSION["email"])) :

    
    //header("Location: site.php"); Burada eğer giriş yapılmışsa gerçek siteye yönlendiriyoruz


endif;



$conn->close();
// burası kullanıcının giriş yaptıktan sonra görebildiği sayfa
// şablon olarak kullanabilirsiniz
// bu sayfayı şu anki haliyle kopyalayarak giriş yapılmadan erişilemeyen sayfalar oluşturabilirsiniz

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrHamzaless Hesap Yönetimi</title>
    <link rel="stylesheet" type="text/css" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./app/ai/static/img/MrHamzaless.png" />
</head>

<body>
    <h1>Merhaba, <?php echo $_SESSION["username"]; ?></h1>
    <a href="./şifre-sıfırla.php">Şifre Sıfırla</a></br>
    <a href="./çıkış-yap.php">Çıkış Yap</a>
    <?php if (isset($_SESSION["id"]) && isset($_SESSION["username"]) && isset($_SESSION["email"])) : ?>
        <a type="button" href=".\" style="padding-top:20px;">Bu butona sitenizin açılış ekranına yönlendirme yapın</a>
        <a href="">veya php'deki kodu kullanarak direkt yönlendirme yapın</a>
    <?php endif; ?>
    
   
</body>

</html>