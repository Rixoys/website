<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $baslik = $_POST["baslik"];
    $secenekler = $_POST["secenek"];

    include '../baglanti.php';

    // Oylama ekleyerek oylama ID'sini al
    $sql_oylama_ekle = "INSERT INTO oylama (baslik) VALUES ('$baslik')";
    if ($conn->query($sql_oylama_ekle) === TRUE) {
        $oylama_id = $conn->insert_id;

        // Seçenekleri ekleyerek seçenek ID'lerini al
        $secenek_ids = array();
        foreach ($secenekler as $secenek) {
            $sql_secenek_ekle = "INSERT INTO secenekler (oylama_id, adi) VALUES ($oylama_id, '$secenek')";
            if ($conn->query($sql_secenek_ekle) === TRUE) {
                $secenek_ids[] = $conn->insert_id;
            } else {
                echo "Hata: " . $conn->error;
                exit;
            }
        }

        echo "Oylama başarıyla eklendi. Oylama ID: $oylama_id, Seçenek ID'ler: " . implode(", ", $secenek_ids);
    } else {
        echo "Hata: " . $conn->error;
    }

    $conn->close();
}
?>
<meta http-equiv="refresh" content="0; url=oylama_admin.php">