<?php
require_once 'c:/xampp/htdocs/ITS/config/Connect_DB.php';

$orderCode = 'DHB2B4E';

$sql = "
    SELECT * FROM reviews WHERE order_id = 48
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($result);
