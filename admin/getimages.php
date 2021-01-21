<?php
require_once __DIR__."/../pdo.php";

$stmt = $pdo->query("SELECT `file_name` FROM images");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows, JSON_PRETTY_PRINT);