<?php


return array(
    // sistemin mail atabilmesi için önemlidir
    // daha detaylı ayar yapmak için 'kayıt-ol.php' dosyasındaki 'sendMail()' fonksiyonuna göz atın
    "base_url" => "http://localhost/login/", // 'index.php' bulunduğu klasör (gerekli)
    "host" => "smtp.yandex.com", // SMTP sunucusu
    "username" => "FullSharpDeveloper@yandex.com", // SMTP kullanıcı adı
    "password" => "smtp şifresi & yandex kullanmanızı öneriyorum!", // SMTP şifre
    "port" => "465" // SMTP port
);


?>

lan şifreleri çalma