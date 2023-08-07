<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $oylama_id = $_GET["id"];

    include '../baglanti.php';
    
    // Oylamayı sil
    $sql = "DELETE FROM oylama WHERE id = $oylama_id";
    if ($conn->query($sql) === TRUE) {
        echo "Oylama başarıyla silindi.";
    } else {
        echo "Hata: " . $conn->error;
    }
    $conn->close();
}
?>
<meta http-equiv="refresh" content="0; url=oylama_admin.php">