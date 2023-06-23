# PHP Login nasıl kullanılır.
## Aşağıdaki adımlar yaklaşık 5 Dakika sürüyor kolay gelsin!
### Destek ve yardım için discord hesabım: mrhamzaless


> **Öncelikle** => Kolay database kurulumundan **mysql tablenize (db.sql)** dosyasını aktarın. 
> **Sonra** => veritabanı.php dosyasına **doğru bilgileri** giriniz, ve çalıştığından emin olunuz. 
> **Son olarak** => mail-ayarları.php **smtp bilgileriniz** ile doldurunuz.. (Küçük bir öneri: Yandex Mail kullanın...)

## Siteniz hazır durumda! Şimdi C#'a entegre edelim!

# Peki bunu C#'a nasıl entegre edeceğim? Aşağıda verdiğim kod Login için kullanacağımız fonksiyon:
```
public static bool Login(string Username,string Password)
            {

                string nm = Username;
                string pw = Password;
                var request = (HttpWebRequest)WebRequest.Create("apinize giden yol mesela: localhost/api/login/");

                var postData = "username=" + Uri.EscapeDataString(nm);
                postData += "&password=" + Uri.EscapeDataString(pw);
                var data = Encoding.ASCII.GetBytes(postData);

                request.Method = "POST";
                request.ContentType = "application/x-www-form-urlencoded";
                request.ContentLength = data.Length;
                using (var stream = request.GetRequestStream())
                {
                    stream.Write(data, 0, data.Length);
                }
                var response = (HttpWebResponse)request.GetResponse();

                var responseString = new StreamReader(response.GetResponseStream()).ReadToEnd();
                if (responseString == "true")
		{
		return true;
		}
                return false;
            }
```



### Peki bu kodu login sayfamda nasıl kullanacağım? Bu diğerlerinden daha kolay..

```
if (Login(nametextbox.Text, passwordtextbox.Text) == true)
{
   // Şifre ve Kullanıcı adı doğru geldiğinde olacak işlemler
}
else
{
    MessageBox.Show("Kullanıcı adı veya şifre yanlış", "BeyClient", MessageBoxButtons.OK,MessageBoxIcon.Error);
}
```


# Bu Proje MIT Lisansı altında paylaşılmıştır;
## Kendiniz yapmışsınız gibi pazarlanamaz.
### Credit vermeden paylaşılamaz

Teşekkürler :)
