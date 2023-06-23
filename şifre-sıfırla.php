<?php
session_start();
include "veritabanı.php";

// kullanıcı giriş yapmış mı kontrol ediyoruz
if (!isset($_SESSION["id"]) && !isset($_SESSION["username"]) && !isset($_SESSION["email"])) {
    header("Location: giris-yap.php");
    exit();
}

if (isset($_POST["old_password"]) && isset($_POST["new_password"]) && isset($_POST["re_new_password"])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // veriyi özel karakterlerden temizliyoruz
    $old_password = validate($_POST["old_password"]);
    $new_password = validate($_POST["new_password"]);
    $re_new_password = validate($_POST["re_new_password"]);

    // veri boşluk kontrolü yapıyoruz
    if (empty($old_password)) {
        header("Location: şifre-sıfırla.php?error=Eski şifre doğru değil");
        exit();
    } else if (empty($new_password)) {
        header("Location: şifre-sıfırla.php?error=Yeni şifre doğru değil");
        exit();
    } else if (empty($re_new_password)) {
        header("Location: şifre-sıfırla.php?error=Şifreler eşleşmiyor");
        exit();
    } else if ($new_password != $re_new_password) {
        header("Location: şifre-sıfırla.php?error=Yeni şifre belirtilmedi");
        exit();
    } else {
        $id = $_SESSION["id"];
        $email = $_SESSION["email"];
        $old_password = md5($old_password); // şifreyi 'md5()' fonksiyonu ile şifreliyoruz
        $new_password = md5($new_password);

        $query = "SELECT * FROM users WHERE id = '$id' AND email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if ($row["password"] == $old_password) {
                $query = "UPDATE users SET password = '$new_password' WHERE id='$id' AND email='$email'";
                $result = mysqli_query($conn, $query); // eksi şifreyi yeni şifre ile değiştiriyoruz

                if ($result) {
                    // şifre değiştirildiği için kullanıcının çıkışını yapıyoruz
                    session_unset();
                    session_destroy();
                    header("Location: giris-yap.php?success=Şifre değiştirildi!");
                    exit();
                } else {
                    header("Location: şifre-sıfırla.php?error=Şifrenizi değiştiremedik?");
                    exit();
                }
            } else {
                header("Location: şifre-sıfırla.php?error=Eski şifre doğru değil?");
                exit();
            }
        } else {
            header("Location: şifre-sıfırla.php?error=Hesap bulunamadı?");
            exit();
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
    <title>MrHamzaless Şifre Sıfırla</title>
    <link rel="shortcut icon" href="./app/ai/static/img/mrai.png" />
    <link rel="stylesheet" type="text/css" href="./css/reset-password.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <form action="./şifre-sıfırla.php" method="POST">
        <h3>Şifre Sıfırla</h3>
        <?php if (isset($_GET["success"]) && !empty($_GET["success"])) { ?>
            <div class="success"><?php echo $_GET["success"]; ?></div>
        <?php } ?>
        <?php if (isset($_GET["error"]) && !empty($_GET["error"])) { ?>
            <div class="error"><?php echo $_GET["error"]; ?></div>
        <?php } ?>
        <label for="old_password">Eski Şifre</label>
        <input type="password" name="old_password" placeholder="Eski Şifre" required>
        <label for="new_password">Yeni Şifre</label>
        <input type="password" name="new_password" placeholder="Yeni Şifre" required>
        <label for="re_new_password">Yeni Şifre Tekrar</label>
        <input type="password" name="re_new_password" placeholder="Yeni Şifre Tekrar" required>
        <button>Sıfırla</button>
    </form>
</body>

</html>