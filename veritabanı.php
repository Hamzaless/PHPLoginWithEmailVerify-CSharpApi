<?php
// veritabanı ayarları

$sname = "localhost"; // sunucu
$unmae = "root"; // kullanıcı adı
$password = ""; // şifre

$db_name = "mrai"; // veritabanı adı

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
    echo "Bağlantı Hatası";
}
