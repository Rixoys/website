<?php
include 'baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');
// Mesaj filtreleme için sınıf ve cinsiyet değerlerini al
$sinif = $_GET['sinif'] ?? '';
$cinsiyet = $_GET['cinsiyet'] ?? '';

// Mesajları veritabanından çek
$mesajlar = array();
$sql = "SELECT id, tarih, saat, isim, cinsiyet, sinif, mesaj FROM mesajlar";

// Sınıf filtresi varsa sorguya ekle
if ($sinif != '') {
    $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar WHERE sinif = '$sinif'";
}

// Cinsiyet filtresi varsa sorguya ekle
if ($cinsiyet != '') {
    if ($sinif != '') {
        $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar AND cinsiyet = '$cinsiyet'";
    } else {
        $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar WHERE cinsiyet = '$cinsiyet'";
    }
}

// Filtreleme seçeneklerine göre sorguyu güncelle
if ($sinif != '' && $cinsiyet != '') {
    $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar WHERE sinif = '$sinif' AND cinsiyet = '$cinsiyet'";
} elseif ($sinif != '') {
    $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar WHERE sinif = '$sinif'";
} elseif ($cinsiyet != '') {
    $sql .= "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar WHERE cinsiyet = '$cinsiyet'";
}

// Mesajları tarih sırasına göre en yeni olanından en eskisine doğru sırala
$sql .= " ORDER BY tarih DESC, saat DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mesajlar[] = $row;
    }
}

$conn->close();
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
    <title>TFL - Mesajlar</title>
    <link rel="stylesheet" type="text/css" href="style2.css">
    <link rel="stylesheet" type="text/css" href="stylemain.css">
    <script>
        function filtrele() {
            var sinif = document.getElementById('sinif').value;
            var cinsiyet = document.getElementById('cinsiyet').value;
            window.location.href = "mesajlar.php?sinif=" + sinif + "&cinsiyet=" + cinsiyet;
        }
    </script>
    <style type="text/css">
        body{margin:0px;}
        main{margin:0px;}
    </style>
</head>
<body>
<header>
        <div class="topnav">
            <a href="index.php" class="active">Ana Sayfa</a>
            <a href="mesajlar.php">Mesajlar</a>
            <a href="mesajyaz.html">Mesaj Yaz</a>
            <a href="/oylama/index.php">Oylamalar</a>
            <a href="admineyaz.html">Admin'e yazın</a>
            <a href="/admin/index.html">Admin Kontrol Paneli</a>
            <a href="#">Kullanıcılar</a> <br/><br/>
        </div>
        <div class="header">
            <h1>Kadim TFL Halkının Düşünceleri</h1>
        </div>
    </header>
    <div class="filtreler">
        <label for="sinif">Sınıf:</label>
        <select id="sinif" name="sinif" onchange="filtrele()">
            <option value="">Hepsi</option>
            <option value="9" <?php echo ($sinif == '9') ? 'selected' : ''; ?>>9. Sınıf</option>
            <option value="10" <?php echo ($sinif == '10') ? 'selected' : ''; ?>>10. Sınıf</option>
            <option value="11" <?php echo ($sinif == '11') ? 'selected' : ''; ?>>11. Sınıf</option>
            <option value="12" <?php echo ($sinif == '12') ? 'selected' : ''; ?>>12. Sınıf</option>
        </select>

        <label for="cinsiyet">Cinsiyet:</label>
        <select id="cinsiyet" name="cinsiyet" onchange="filtrele()">
            <option value="">Hepsi</option>
            <option value="erkek" <?php echo ($cinsiyet == 'erkek') ? 'selected' : ''; ?>>Erkek</option>
            <option value="kadın" <?php echo ($cinsiyet == 'kadın') ? 'selected' : ''; ?>>Kadın</option>
        </select>
    </div>

    <div class="mesajlar">
        <?php
        $sayfa_sayisi = ceil(count($mesajlar) / 30); // 30 mesajdan fazlaysa sayfa sayısını hesapla
        $sayfa = $_GET['sayfa'] ?? 1; // Aktif sayfayı al, belirtilmemişse varsayılan olarak 1

        $baslangic = ($sayfa - 1) * 30; // Gösterilecek mesajların başlangıç indeksi
        $bitis = $baslangic + 29; // Gösterilecek mesajların bitiş indeksi

        for ($i = $baslangic; $i <= $bitis && $i < count($mesajlar); $i++) {
            $mesaj = $mesajlar[$i];
            echo "<div class='mesaj'>";
            echo "<div class='mesaj-baslik'>ID: {$mesaj['id']}</div>";
            echo "<div class='mesaj-bilgi'>{$mesaj['isim']} ({$mesaj['cinsiyet']}) - Sınıf: {$mesaj['sinif']} - Tarih: {$mesaj['tarih']} - Saat: {$mesaj['saat']}</div>";
            echo "<div class='mesaj-icerik'>{$mesaj['mesaj']}</div>";
            echo "</div>";
        }
        ?>
    </div>

    <div class="sayfalama">
        <?php
        for ($sayfa_no = 1; $sayfa_no <= $sayfa_sayisi; $sayfa_no++) {
            echo "<a href='mesajlar.php?sinif=$sinif&cinsiyet=$cinsiyet&sayfa=$sayfa_no'>$sayfa_no</a>";
        }
        ?>
    </div>
</body>
</html>
