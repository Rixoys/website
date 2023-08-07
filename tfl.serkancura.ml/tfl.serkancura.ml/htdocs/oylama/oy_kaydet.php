<?php
include '../baglanti.php';

if (isset($_POST['oylama_id']) && isset($_POST['secenek_id'])) {
    $oylama_id = $_POST['oylama_id'];
    $secenek_id = $_POST['secenek_id'];

    // Seçeneğin oy sayısını güncelle
    $sql_guncelle = "UPDATE secenekler SET oy_sayisi = oy_sayisi + 1 WHERE id = $secenek_id";
    if ($conn->query($sql_guncelle) === TRUE) {
        echo "Oyunuz başarıyla kaydedildi.";
    } else {
        echo "Hata: " . $conn->error;
    }

    $conn->close();
}
?>
