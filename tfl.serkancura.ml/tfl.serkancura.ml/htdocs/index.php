<?php
include 'baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');

$sql_select_duyurular = "SELECT * FROM duyuru ORDER BY tarih DESC, saat DESC";
$result_duyurular = $conn->query($sql_select_duyurular);
?>

<?php

session_start();

// ## KULLANICININ DOĞRU İP ADRESİNİ ÖĞRENELİM!
function ipogrenme(){
if(getenv("HTTP_CLIENT_IP")){
$ip = getenv("HTTP_CLIENT_IP");
}else if(getenv("HTTP_X_FORWARDED_FOR")){
$ip = getenv("HTTP_X_FORWARDED_FOR");
if(strstr($ip, ',')) {
$tmp = explode (',', $ip);
$ip = trim($tmp[0]);
}
}else{
$ip = getenv("REMOTE_ADDR");
}
return $ip;
}
$browser= htmlspecialchars ($_SERVER['HTTP_USER_AGENT']);
// ## LOG DOSYASI YAZALIM
function logla($logmetin){
$dosya = 'log.html';
$metin = date('d-m-Y h:i - ').$logmetin.'<br/>';
$fh = fopen($dosya, 'a+') or die('Hata!');
fwrite($fh, $metin);
fclose($fh);
$_SESSION['ipadreskayit'] = true;
}

// ## ŞEHİR BİLGİSİNİ BULALIM
if(!isset($_SESSION['ipadreskayit'])){
function sehir_bul($ip){
$default = 'Bilinmiyor';
if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost'){
$ip = '8.8.8.8';
}
$curlopt_useragent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.71 Safari/537.36';
$url = 'http://www.ipsorgu.com/?ip=' . urlencode($ip) . '#sorgu';
$ch = curl_init();
$curl_opt = array(
CURLOPT_FOLLOWLOCATION => 1,
CURLOPT_HEADER => 0,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_USERAGENT => $curlopt_useragent,
CURLOPT_URL => $url,
CURLOPT_TIMEOUT => 1,
CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
);
curl_setopt_array($ch, $curl_opt);
$content = curl_exec($ch);
curl_close($ch);

if(preg_match('#<title>(.*?)</title>#', $content, $regs)){
$city=$regs[1];
}
if($city != ''){
$city=explode("-", $city);
$city=trim($city[0]);
logla($city);
}else{
return $default;
}
}
sehir_bul(ipogrenme());
}

?>



<!DOCTYPE html>
<html>
<head>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LCJ4KSRQVZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LCJ4KSRQVZ');
</script>
    <meta charset="utf-8">
    <title>TFL İtiraf Web Sitesi</title>
    <link rel="stylesheet" type="text/css" href="stylemain.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
        .satir33{background-color: bisque; border-radius: 5%; box-shadow: 2px 2px 6px #000;}
        th{padding:30px;}
        .cookie-uyarisi {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            display: none;
        }

        .close-btn {
            cursor: pointer;
            float: right;
            font-size: 20px;
            margin-top: -5px;
        }
        .cookie-uyarisi a {color: bisque;}
    </style>
</head>
<body background="bg.jpg">
    <header>
        <div class="topnav">
            <a href="index.php" class="active">Ana Sayfa</a>
            <a href="mesajlar.php">Mesajlar</a>
            <a href="mesajyaz.html">Mesaj Yaz</a>
            <a href="/oylama/index.php">Oylamalar</a>
            <a href="admineyaz.html">Admin'e yazın</a>
            <a href="/admin/index.html">Admin Kontrol Paneli</a>
            <a href="#">Kullanıcılar</a><br/><br/>
            <div class="header">
                <h1>TFL Tarihinde Bir İlk!</h1>
                <p>%100 Yerli ve Milli Üretim İtiraf Sayfamız Erişime Açılmıştır.</p>
            </div>
        </div>
    </header>
    <main>
    <!-- Çerez Uyarısı -->
    <div class="cookie-uyarisi" id="cookieUyarisi" >
        Bu sitede çerezler kullanılmaktadır. Daha fazla bilgi için <a href="/gizlilik-politikasi">Gizlilik Politikası</a>'nı inceleyebilirsiniz.
        <span class="close-btn" onclick="kapatCookieUyarisi()">&times;</span>
    </div>

    <script>
        function kapatCookieUyarisi() {
            var cookieUyarisi = document.getElementById("cookieUyarisi");
            cookieUyarisi.style.display = "none";

            // Çerez oluştur (kullanıcı uyarıyı kapattı)
            document.cookie = "cookieUyarisiKapandi=1; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/";
        }

        // Çerez uyarısını kontrol et
        function kontrolEtCookieUyarisi() {
            if (!document.cookie.includes("cookieUyarisiKapandi=1")) {
                var cookieUyarisi = document.getElementById("cookieUyarisi");
                cookieUyarisi.style.display = "block";
            }
        }

        window.onload = function() {
            kontrolEtCookieUyarisi();
        };
    </script>
        <div class="satirlar">
            <a href="mesajyaz.html">
                <div class="satir33">
                    <div class="madde">
                        <h2>Mesaj Yazın</h2>
                    </div>
                </div>
            </a>
            <a href="mesajlar.php">
                <div class="satir33" style="margin-left: 0.5%; margin-right:0.5%;">
                    <div class="madde">
                        <h2>Yazılan Mesajlar</h2>
                    </div>
                </div>
            </a>
            <a href="admineyaz.html">
                <div class="satir33">
                    <div class="madde">
                        <h2>Admin'e Yazın</h2>
                    </div>
                </div>
            </a>
        </div>
        <div class="satirlar">
        <a href="/oylama/index.php">
        <div class="satir33">
        <div class="madde">
        <h2>Oylamalar</h2>
        </div>
        </div>
        </a>
        <a href="/admin/index.html">
        <div class="satir33" style="margin-left: 0.5%; margin-right:0.5%;">
        <div class="madde">
        <h2>Admin Kontrol Paneli</h2>
        </div>
        </div>
        </a>
        <div class="satirlar" style="background-color: #68b5ca; opacity:1; border-radius: 3%; box-shadow: 2px 2px 6px #000; margin-bottom: 50px;">
            <b>
                <div class="satir100" style="margin-left: 10%;"><h2>Duyurular</h2></div>
            <div class="satir70" style="margin-left: 10%;">
            <table class="duyuru-tablo" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tarih</th>
                <th>Saat</th>
                <th>Duyuru Metni</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_duyurular->num_rows > 0) {
                while ($row_duyurular = $result_duyurular->fetch_assoc()) {
                    $duyuru_id = $row_duyurular['id'];
                    $duyuru_tarih = $row_duyurular['tarih'];
                    $duyuru_saat = $row_duyurular['saat'];
                    $duyuru_metin = $row_duyurular['metin'];

                    echo "<tr>";
                    echo "<td>$duyuru_id</td>";
                    echo "<td>$duyuru_tarih</td>";
                    echo "<td>$duyuru_saat</td>";
                    echo "<td>$duyuru_metin</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Hiç duyuru bulunamadı.</td></tr>";
            }
            ?>
        </tbody>
    </table>
            </div>
            </b>
        </div>
    </main>
</body>
</html>
