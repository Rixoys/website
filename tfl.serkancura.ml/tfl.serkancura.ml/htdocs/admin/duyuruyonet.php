<?php
include '../baglanti.php'; // Veritabanı bağlantı kodunu dahil et
date_default_timezone_set('Europe/Istanbul');

// Duyuru ekleme
if (isset($_POST['duyuru_metni'])) {
    $duyuru_metni = $_POST['duyuru_metni'];
    $tarih = date('d-m-Y');
    $saat = date('H:i:s');
    $sql_insert = "INSERT INTO duyuru (tarih, saat, metin) VALUES ('$tarih', '$saat', '$duyuru_metni')";
    if ($conn->query($sql_insert) === TRUE) {
        echo "Duyuru başarıyla eklendi.";
    } else {
        echo "Duyuru eklenirken bir hata oluştu: " . $conn->error;
    }
}

// Duyuru silme
if (isset($_POST['duyuru_id'])) {
    $duyuru_id = $_POST['duyuru_id'];
    $sql_delete = "DELETE FROM duyuru WHERE id = '$duyuru_id'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Duyuru başarıyla silindi.";
    } else {
        echo "Duyuru silinirken bir hata oluştu: " . $conn->error;
    }
}

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>TFL - Duyuru Yönetimi</title>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LCJ4KSRQVZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LCJ4KSRQVZ');
</script>
    <title>Admin Sayfası</title>
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
                <h1>Hoşgeldin Kaptan. Burada Duyuruları Yönetebilirsin.</h1>
            </div>
        </div>
    </header>

    <div class="admin-form">
        <h2>Duyuru Ekle</h2>
        <form method="POST" action="">
            <label for="duyuru_metni">Duyuru Metni:</label>
            <textarea id="duyuru_metni" name="duyuru_metni" rows="5" required></textarea>
            <input type="submit" value="Duyuru Ekle">
        </form>
    </div>

    <div class="admin-form">
        <h2>Duyurular</h2>
        <?php
        $sql_select_duyurular = "SELECT id, tarih, saat, metin FROM duyuru ORDER BY tarih DESC, saat DESC";
        $result_duyurular = $conn->query($sql_select_duyurular);

        if ($result_duyurular->num_rows > 0) {
            while ($row_duyurular = $result_duyurular->fetch_assoc()) {
                $duyuru_id = $row_duyurular['id'];
                $duyuru_tarih = $row_duyurular['tarih'];
                $duyuru_saat = $row_duyurular['saat'];
                $duyuru_metin = $row_duyurular['metin'];

                echo "<div class='mesaj'>";
                echo "<div class='mesaj-baslik'>ID: $duyuru_id</div>";
                echo "<div class='mesaj-bilgi'>Tarih: $duyuru_tarih - Saat: $duyuru_saat</div>";
                echo "<div class='mesaj-icerik'>$duyuru_metin</div>";
                echo "<div class='sil-link'>";
                echo "<form method='POST' action=''>";
                echo "<input type='hidden' name='duyuru_id' value='$duyuru_id'>";
                echo "<input type='submit' value='Duyuruyu Sil'>";
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "Hiç duyuru bulunamadı.";
        }
        ?>
    </div>
</body>
</html>
