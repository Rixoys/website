<html>
<head>
    <title>TFL - Oylama Yönetimi</title>
</head>
<body>
<header>
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
    <style type="text/css">
        main {padding:5%;}
    </style>
        <div class="topnav">
            <a href="../index.php" class="active">Ana Sayfa</a>
            <a href="../mesajlar.php">Mesajlar</a>
            <a href="../mesajyaz.html">Mesaj Yaz</a>
            <a href="../oylama/index.php">Oylamalar</a>
            <a href="../admineyaz.html">Admin'e yazın</a>
            <a href="index.html">Admin Kontrol Paneli</a>
            <a href="#">Kullanıcılar</a><br/><br/>
            <div class="header">
                <h1>Hoşgeldin Kaptan. Burada Oylamaları Yönetebilirsin.</h1>
            </div>
        </div>
    </header>
    <main>
    <h2>Oylama Ekle</h2>
    <form action="oylama_kaydet.php" method="POST">
        <label for="baslik">Oylama Başlığı:</label>
        <input type="text" id="baslik" name="baslik" required>
        <h3>Seçenekler:</h3>
        <div id="secenekler">
            <div class="secenek">
                <input type="text" name="secenek[]" required>
                <button type="button" onclick="secenekEkle()">Yeni Seçenek Ekle</button>
            </div>
        </div>
        <button type="submit">Oylama Ekle</button>
    </form>

    <script>
        function secenekEkle() {
            var seceneklerDiv = document.getElementById("secenekler");
            var yeniSecenekDiv = document.createElement("div");
            yeniSecenekDiv.classList.add("secenek");
            yeniSecenekDiv.innerHTML = `
                <input type="text" name="secenek[]" required>
                <button type="button" onclick="secenekSil(this)">Seçeneği Sil</button>
            `;
            seceneklerDiv.appendChild(yeniSecenekDiv);
        }

        function secenekSil(button) {
            var secenekDiv = button.parentNode;
            secenekDiv.remove();
        }
    </script>

    <h2>Oylamaları Sil</h2>
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

            echo "<div>";
            echo "<span>$oylama_baslik</span>";
            echo "<a href='oylama_sil.php?id=$oylama_id'>Sil</a>";
            echo "</div>";
        }
    } else {
        echo "Hiç oylama bulunamadı.";
    }

    $conn->close();
    ?>
    </main>
</body>
</html>
