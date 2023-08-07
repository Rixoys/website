<?php
include '../baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');

// Sayfalama için gerekli değişkenler
$mesajlar_sayfa_basina = 10; // Her sayfada gösterilecek mesaj sayısı
$aktif_sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1; // Aktif sayfa numarası

// Verileri çek ve sayfalama işlemini yap
$limit = ($aktif_sayfa - 1) * $mesajlar_sayfa_basina . ", " . $mesajlar_sayfa_basina;
$sql = "SELECT * FROM admin ORDER BY tarih DESC, saat DESC LIMIT $limit";
$result = $conn->query($sql);

// Toplam mesaj sayısını al
$sql_mesaj_sayisi = "SELECT COUNT(*) as toplam_mesaj FROM admin";
$result_mesaj_sayisi = $conn->query($sql_mesaj_sayisi);
$row_mesaj_sayisi = $result_mesaj_sayisi->fetch_assoc();
$toplam_mesaj = $row_mesaj_sayisi['toplam_mesaj'];

// Toplam sayfa sayısını hesapla
$sayfa_sayisi = ceil($toplam_mesaj / $mesajlar_sayfa_basina);

?>

<!DOCTYPE html>
<html>
<head>
    <title>TFL - Admin</title>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LCJ4KSRQVZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LCJ4KSRQVZ');
</script>
<link rel="stylesheet" type="text/css" href="admin.css">
<link rel="stylesheet" type="text/css" href="../stylemain.css">
    <title>Admin Mesajları</title>
    <style>
        .mesajlar {
            margin-bottom: 20px;
        }

        .mesaj {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .mesaj-baslik {
            font-weight: bold;
        }

        .mesaj-bilgi {
            font-size: 12px;
            color: #888;
        }

        .sayfalama {
            margin-top: 20px;
        }

        .sayfalama a {
            display: inline-block;
            padding: 5px 10px;
            background-color: #f1f1f1;
            color: #333;
            text-decoration: none;
            margin-right: 5px;
        }

        .sayfalama a.active {
            background-color: #4CAF50;
            color: #fff;
        }
        div{font-family: Arial;}
        body{margin:0px;}
    </style>
</head>
<body>
<header>
        <div class="topnav">
            <a href="../index.php" class="active">Ana Sayfa</a>
            <a href="../mesajlar.php">Mesajlar</a>
            <a href="../mesajyaz.html">Mesaj Yaz</a>
            <a href="../oylama/index.php">Oylamalar</a>
            <a href="../admineyaz.html">Admin'e yazın</a>
            <a href="index.html">Admin Kontrol Paneli</a>
            <a href="#">Kullanıcılar</a><br/><br/>
            <div class="header">
                <h1>Hoşgeldin Kaptan. Burada Burada Sana Gönderilen Mesajları Okuyabilirsin</h1>
            </div>
        </div>
    </header>
    <div class="mesajlar">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='mesaj'>";
                echo "<div class='mesaj-baslik'>ID: " . $row["id"] . "</div>";
                echo "<div class='mesaj-bilgi'>İsim: " . $row["isim"] . " - Cinsiyet: " . $row["cinsiyet"] . " - Sınıf: " . $row["sinif"] . " - Tarih: " . $row["tarih"] . " - Saat: " . $row["saat"] . "</div>";
                echo "<div class='mesaj-metin'>" . $row["mesaj"] . "</div>";
                echo "</div>";
            }
        } else {
            echo "Hiç mesaj bulunamadı.";
        }
        ?>
    </div>

    <div class="sayfalama">
        <?php
        for ($sayfa = 1; $sayfa <= $sayfa_sayisi; $sayfa++) {
            echo "<a href='adminmesaj.php?sayfa=$sayfa'" . ($aktif_sayfa == $sayfa ? " class='active'" : "") . ">$sayfa</a>";
        }
        ?>
    </div>

</body>
</html>
