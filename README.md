# PHP Login nasıl kullanılır.
## Aşağıdaki adımlar yaklaşık 5 Dakika sürüyor kolay gelsin!
### https://mrhamzaless.com

# Yükleme:
> Git indirin<br>
> ve **cmd** (konsol)'a şu kodu yazın<br>
> ```git clone https://github.com/Hamzaless/PHPLoginWithEmailVerify-CSharpApi.git```<br>
> ```cd PHPLoginWithEmailVerify-CSharpApi```<br>

# Kurulum

> **Öncelikle** => Kolay database kurulumundan **mysql tablenize (db.sql)** dosyasını aktarın.<br>
> **Sonra** => veritabanı.php dosyasına **doğru bilgileri** giriniz, ve çalıştığından emin olunuz.<br> 
> **Son olarak** => mail-ayarları.php **smtp bilgileriniz** ile doldurunuz.. bknz (https://mehmet.net/smtp-nedir-nasil-kurulur/)<br>

## Siteniz hazır durumda! Şimdi C#'a entegre edelim!

# Peki bunu C#'a nasıl entegre edeceğim? Aşağıda verdiğim kod Login için kullanacağımız fonksiyon:
```
public static bool Login(string Username,string Password)
            {

                string nm = Username;
                string pw = Password;
                var request = (HttpWebRequest)WebRequest.Create("apinize giden yol mesela: https://mrhamzaless.com/phplogin/api/login");

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
if (Login(nametextbox.Text, passwordtextbox.Text))
{
   // Şifre ve Kullanıcı adı doğru geldiğinde olacak işlemler
}
else
{
    MessageBox.Show("Kullanıcı adı veya şifre yanlış", "BeyClient", MessageBoxButtons.OK,MessageBoxIcon.Error);
}
```

Teşekkürler :)
