<?php
include '../baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');

// Mesaj silme
if (isset($_GET['delete_id'])) {
    $mesaj_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM mesajlar WHERE id = '$mesaj_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Mesaj başarıyla silindi.";
    } else {
        echo "Mesaj silinirken bir hata oluştu: " . $conn->error;
    }
}

// Sayfalama için gerekli değişkenler
$mesajlar_sayfa_basina = 10; // Her sayfada gösterilecek mesaj sayısı
$aktif_sayfa = isset($_GET['sayfa']) ? $_GET['sayfa'] : 1; // Aktif sayfa numarası

// Toplam mesaj sayısını al
$sql_mesaj_sayisi = "SELECT COUNT(*) as toplam_mesaj FROM mesajlar";
$result_mesaj_sayisi = $conn->query($sql_mesaj_sayisi);
$row_mesaj_sayisi = $result_mesaj_sayisi->fetch_assoc();
$toplam_mesaj = $row_mesaj_sayisi['toplam_mesaj'];

// Toplam sayfa sayısını hesapla
$sayfa_sayisi = ceil($toplam_mesaj / $mesajlar_sayfa_basina);

// Geçerli sayfanın başlangıç ve bitiş indislerini hesapla
$baslangic_indis = ($aktif_sayfa - 1) * $mesajlar_sayfa_basina;
$bitis_indis = $baslangic_indis + $mesajlar_sayfa_basina;

?>

<html>
<head>
<title>TFL - Mesaj Yönetimi</title>
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
    <style type="text/css">
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
                <h1>Hoşgeldin Kaptan. Burada Mesajları Yönetebilirsin.</h1>
            </div>
        </div>
    </header>

    <div class="mesajlar">
        <h2>Mesajlar</h2>
        <?php
        $sql_select_mesajlar = "SELECT id, tarih, isim, cinsiyet, sinif, mesaj FROM mesajlar ORDER BY tarih DESC, saat DESC LIMIT $baslangic_indis, $mesajlar_sayfa_basina";
        $result_mesajlar = $conn->query($sql_select_mesajlar);

        if ($result_mesajlar->num_rows > 0) {
            while ($row_mesajlar = $result_mesajlar->fetch_assoc()) {
                $mesaj_id = $row_mesajlar['id'];
                $mesaj_tarih = $row_mesajlar['tarih'];
                $mesaj_isim = $row_mesajlar['isim'];
                $mesaj_cinsiyet = $row_mesajlar['cinsiyet'];
                $mesaj_sinif = $row_mesajlar['sinif'];
                $mesaj_metin = $row_mesajlar['mesaj'];

                echo "<div class='mesaj'>";
                echo "<div class='mesaj-baslik'>ID: $mesaj_id</div>";
                echo "<div class='mesaj-bilgi'>$mesaj_isim ($mesaj_cinsiyet) - Sınıf: $mesaj_sinif - Tarih: $mesaj_tarih</div>";
                echo "<div class='mesaj-icerik'>$mesaj_metin</div>";
                echo "<div class='sil-link'><a href='mesajyonet.php?delete_id=$mesaj_id'>Mesajı Sil</a></div>";
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
            echo "<a href='mesajyonet.php?sayfa=$sayfa'" . ($aktif_sayfa == $sayfa ? " class='active'" : "") . ">$sayfa</a>";
        }
        ?>
    </div>

</body>
</html>
