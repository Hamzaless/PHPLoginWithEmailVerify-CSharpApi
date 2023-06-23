<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "./vendor/autoload.php";
include "veritabanı.php";

// kullanıcı giriş yapmış mı kontrol ediyoruz
if (isset($_SESSION["id"]) && isset($_SESSION["username"]) && isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["re_password"])) {
    // verideki özel karakterleri temizler
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // benzersiz, 6 haneli sayılardan oluşan doğrulama kodu oluşturur
    function generateVCode($length = 6)
    {
        $chars = '0123456789qwertyuopasdfghjklizxcvbnm';
        $charsLength = strlen($chars);
        $vcode = '';
        for ($i = 0; $i < $length; $i++) {
            $vcode .= $chars[mt_rand(0, $charsLength - 1)];
        }
        return $vcode;
    }

    // doğrulama linki oluşturur
    function generateLink($email)
    {
        include "veritabanı.php";
        $config = include "./mail-ayarları.php";

        $vcode = generateVCode();

        $query = "INSERT INTO mails(id, email, vcode) VALUES ('', '$email', '$vcode')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $link = $config["base_url"] . "doğrulama.php?email=" . $email . "&vcode=" . $vcode;
            // $link = "https://" . $_SERVER["HTTP_HOST"] . "/" . basename(__DIR__) . "/doğrulama.php?email=" . $email . "&vcode=" . $vcode;
            return $link;
        } else {
            return false;
        }
    }

    // kullanıcıya mail gönderir
    // doğrulama maili gönderebilmek için 'mail-ayarları.php' dosyası içerisindeki ayarları
    // kendi sunucunuza göre değiştirin
    function sendMail($username, $email)
    {
        $mail = new PHPMailer(true);
    
        $config = include "./mail-ayarları.php";
    
        try {
            // sunucu ayarları
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = $config["host"];
            $mail->SMTPAuth = true;
            $mail->Username = $config["username"];
            $mail->Password = $config["password"];
            $mail->SMTPSecure = "ssl";
            $mail->Port = $config["port"];
            $mail->CharSet = "UTF-8";
    
            // alıcılar
            $mail->setFrom($config["username"], "MrHamzaless Doğrulama");
            $mail->addAddress($email, $username);
            // $mail->addAddress('ellen@example.com');
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
    
            // Ekler
            // $mail->addAttachment('/var/tmp/file.tar.gz');
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');
    
            $link = generateLink($email);
    
            // HTML sayfasını yükle
            
    
            // içerik
            $mail->isHTML(true);
            $mail->Subject = "MrHamzaless Doğrulama Linki";
            $mail->Body = "Doğrulama linkin: <a href=".$link.">bana tıkla!</a>";
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            header("Location: kayıt-ol.php?error=" . $mail->ErrorInfo);
           return false;
        }
    }
    

    // verilerdeki özel karakterleri temizliyoruz
    $username = validate($_POST["username"]);
    $email = validate($_POST["email"]);
    $password = validate($_POST["password"]);
    $re_password = validate($_POST["re_password"]);

    // şifreyi ham haliyle alıp işlem yapmak istiyorsanız buradaki '$password' değişkenini kullanabilirsiniz

    // veri boşluk kontrolü yapıyoruz
    if (empty($username)) {
        header("Location: kayıt-ol.php?error=Kullanıcı adı kısmını boş bırakmayın");
        exit();
    } else if (empty($email)) {
        header("Location: kayıt-ol.php?error=Email kısmını boş bırakmayın");
        exit();
    } else if (empty($password)) {
        header("Location: kayıt-ol.php?error=Şifre boş...");
        exit();
    } else if (empty($re_password)) {
        header("Location: kayıt-ol.php?error=Şifrenizi tekrar girmeyi unutmayın!");
        exit();
    } else if ($password != $re_password) {
        header("Location: kayıt-ol.php?error=Şifreler eşleşmiyor...");
        exit();
    } else {
        $password = md5($password); // şifreyi 'md5()' fonksiyonu ile şifreliyoruz

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            header("Location: kayıt-ol.php?error=Bu mail adresi ile zaten kayıt olunmuş?");
            exit();
        } else {
            $query = "INSERT INTO users(id, username, email, password, verified) VALUES ('', '$username', '$email', '$password', '0')";
            $result = mysqli_query($conn, $query); // veritabanına kullanıcıyı ekliyoruz

            if ($result) {
                // doğrulama maili gönderiyoruz
                if (sendMail($username, $email)) {
                    header("Location: kayıt-ol.php?success=Mail " . $email . " adresine gönderildi...");
                    exit();
                } else {
                    // header("Location: kayıt-ol.php?error=mail_not_sended");
                    exit();
                }
            } else {
                header("Location: kayıt-ol.php?error=Hata! Hesap oluşturulamadı");
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MrHamzaless Kayıt</title>
    <link rel="shortcut icon" href="./app/ai/static/img/MrHamzaless.png" />
    <link rel="stylesheet" type="text/css" href="./css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <form action="./kayıt-ol.php" method="POST">
        <h3>Kayıt Ol</h3>
        <?php if (isset($_GET["success"]) && !empty($_GET["success"])) { ?>
            <div class="success"><?php echo $_GET["success"]; ?></div>
        <?php } ?>
        <?php if (isset($_GET["error"]) && !empty($_GET["error"])) { ?>
            <div class="error"><?php echo $_GET["error"]; ?></div>
        <?php } ?>
        <label for="username">Kullanıcı Adı</label>
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Email" required>
        <label for="password">Şifre</label>
        <input type="password" name="password" placeholder="Şifre" required>
        <label for="re_password">Şifre Tekrar</label>
        <input type="password" name="re_password" placeholder="Şifre Tekrar" required>
        <button>Kayıt Ol</button>
        <p>Zaten hesabın var mı? <a href="./giris-yap.php">Giriş Yap</a></p>
    </form>
</body>

</html>