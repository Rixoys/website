<?php
include 'baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');

$isim = $_POST['isim'];
$cinsiyet = $_POST['cinsiyet'];
$sinif = $_POST['sinif'];
$mesaj = $_POST['mesaj'];
$tarih = date('d-m-Y');
$saat = date('H:i:s');

$sql = "INSERT INTO admin (tarih, saat, isim, cinsiyet, sinif, mesaj) VALUES ('$tarih', '$saat', '$isim', '$cinsiyet', '$sinif', '$mesaj')";

if ($conn->query($sql) === TRUE) {
    echo "Mesaj başarıyla kaydedildi.";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<html>
<head>
<meta chartset="utf-8">
<meta http-equiv="refresh" content="2; url=mesajlar.php"> 
</head>
<body>
Mesaj listesine yönlendiriliyorsunuz.<br/> Otomatik olarak yönlendirilmezseniz <a href="mesajlar.php">buraya</a> tıklayın.
</body>
<html>