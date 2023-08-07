<?php
$servername = "sql304.epizy.com";
$username = "epiz_31199276";
$password = "ukdjhsOMAoGc";
$dbname = "epiz_31199276_forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız oldu: " . $conn->connect_error);
}
?>
