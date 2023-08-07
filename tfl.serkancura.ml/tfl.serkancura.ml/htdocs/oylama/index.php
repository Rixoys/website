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
    <link rel="stylesheet" href="../stylemain.css">
    <title>TFL - Oylama</title>
    <style>
        body {font-family: Arial; margin:0px;}
        .oylama-container {
            margin-bottom: 20px;
        }

        .oylama-baslik {
            font-weight: bold;
        }

        .secenek {
            margin-bottom: 10px;
        }
        main {margin:5%;}
    </style>
</head>
<body>
<header>
        <div class="topnav">
            <a href="../index.php" class="active">Ana Sayfa</a>
            <a href="../mesajlar.php">Mesajlar</a>
            <a href="../mesajyaz.html">Mesaj Yaz</a>
            <a href="index.php">Oylamalar</a>
            <a href="../admineyaz.html">Admin'e yazın</a>
            <a href="../admin/index.html">Admin Kontrol Paneli</a>
            <a href="#">Kullanıcılar</a><br/><br/>
            <div class="header">
                <h1>Oyların, Kaderindir. Oy kullanırken dikkatli ol!</h1>
            </div>
        </div>
    </header>
    <main>
    <?php
    include '../baglanti.php';

// Oylamaları çek
    $sql = "SELECT * FROM oylama";
    $result = $conn->query($sql);

    // Oylamaları listele
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $oylama_id = $row['id'];
            $oylama_baslik = $row['baslik'];

            // Çerez kontrolü
            $oylanmis_mi = false;
            if (isset($_COOKIE["oylama_$oylama_id"])) {
                $oylanmis_mi = true;
            }

            echo "<div class='oylama-container'>";
            echo "<h3 class='oylama-baslik'>$oylama_baslik</h3>";

            // Oylama seçeneklerini çek
            $sql_secenekler = "SELECT * FROM secenekler WHERE oylama_id = $oylama_id";
            $result_secenekler = $conn->query($sql_secenekler);

            // Seçenekleri listele
            if ($result_secenekler->num_rows > 0) {
                while ($row_secenekler = $result_secenekler->fetch_assoc()) {
                    $secenek_id = $row_secenekler['id'];
                    $secenek_adi = $row_secenekler['adi'];
                    $oy_sayisi = $row_secenekler['oy_sayisi'];

                    echo "<div class='secenek'>";
                    echo "<input type='radio' name='oylama_$oylama_id' value='$secenek_id' ";
                    echo ($oylanmis_mi) ? "disabled" : "";
                    echo "> $secenek_adi - Oy Sayısı: $oy_sayisi";
                    echo "</div>";
                }
            } else {
                echo "Hiç seçenek bulunamadı.";
            }

            echo "</div>";

            // Oy kullanma butonu
            echo "<button onclick='oylamaGonder($oylama_id)' ";
            echo ($oylanmis_mi) ? "disabled" : "";
            echo ">Oy Ver</button>";
        }
    } else {
        echo "Hiç oylama bulunamadı.";
    }

    $conn->close();
    ?>

    <script>
        function oylamaGonder(oylamaId) {
            var secenekler = document.querySelectorAll(`input[name='oylama_${oylamaId}']`);

            secenekler.forEach(function(secenek) {
                if (secenek.checked) {
                    // AJAX isteği ile oy verilerini PHP'ye gönder
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'oy_kaydet.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            console.log(xhr.responseText);
                        }
                    }
                    xhr.send(`oylama_id=${oylamaId}&secenek_id=${secenek.value}`);

                    // Çerez oluştur (oylama için bir daha oy kullanmamasını sağlar)
                    document.cookie = `oylama_${oylamaId}=1; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/`;
                    window.location.reload(false);
                }
            });
        }
    </script>
</body>
</html>