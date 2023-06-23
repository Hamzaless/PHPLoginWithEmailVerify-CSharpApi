<?php
include "veritabanı.php";

if (isset($_GET["email"]) && isset($_GET["vcode"])) {
    $email = $_GET["email"];
    $vcode = $_GET["vcode"];

    // veri boşluk kontrolü
    if (empty($email)) {
        header("Location: giris-yap.php?error=Mail boş?");
        exit();
    } else if (empty($vcode)) {
        header("Location: giris-yap.php?error=Doğrulama kodu boş?");
        exit();
    }

    $query = "SELECT * FROM mails WHERE email = '$email' AND vcode = '$vcode'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mail_id = $row["id"];

        $query = "UPDATE users SET verified = '1' WHERE email = '$email'";
        $result = mysqli_query($conn, $query); // kullanıcıyı onaylıyoruz artık giriş yapabilir

        if ($result) {
            $query = "DELETE FROM mails WHERE id = '$mail_id'";
            $result = mysqli_query($conn, $query); // mail doğrulama kodunu veritabanından siliyoruz

            if ($result) {
                header("Location: giris-yap.php?success=Hesap doğrulandı! Giriş yapabilirsin...");
                exit();
            } else {
                header("Location: giris-yap.php?error=Link geçersiz?");
                exit();
            }
        } else {
            header("Location: giris-yap.php?error=Link geçersiz?");
            exit();
        }
    } else {
        header("Location: giris-yap.php?error=Link geçersiz?");
        exit();
    }
} else {
    echo "link invalid";
}
