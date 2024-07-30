<?php
// データベース接続情報を設定
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "database_name";

// データベース接続を確立
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("接続に失敗しました: " . $conn->connect_error);
}

// クエリの構築
$conditions = [];
$params = [];

if (isset($_GET['category'])) {
    $conditions[] = "category = ?";
    $params[] = $_GET['category'];
}

if (isset($_GET['searchTarget']) && isset($_GET['searchText'])) {
    if ($_GET['searchTarget'] == '商品コード') {
        $conditions[] = "code LIKE ?";
    } else if ($_GET['searchTarget'] == '商品名') {
        $conditions[] = "name LIKE ?";
    }
    $params[] = '%' . $_GET['searchText'] . '%';
}

if (isset($_GET['公開状態'])) {
    $conditions[] = "status = ?";
    $params[] = $_GET['公開状態'];
}

$sql = "SELECT * FROM products";
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("クエリの準備に失敗しました: " . $conn->error);
}

// パラメータをバインド
if (count($params) > 0) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>