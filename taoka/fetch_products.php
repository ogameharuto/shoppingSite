<?php
// セッション開始
session_start();

// データベース接続
require_once ('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリパスを取得
$categoryPath = $_GET['category'] ?? '';

// カテゴリ名からカテゴリ番号を取得する関数
function getCategoryNumber($categoryPath, $pdo) {
    $categoryNames = explode('/', $categoryPath);
    $categoryName = end($categoryNames);
    $stmt = $pdo->prepare("SELECT categoryNumber FROM category WHERE categoryName = :categoryName");
    $stmt->execute([':categoryName' => $categoryName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['categoryNumber'] : null;
}

$categoryNumber = getCategoryNumber($categoryPath, $pdo);

if ($categoryNumber !== null) {
    // 商品データを取得
    $stmt = $pdo->prepare("SELECT productNumber, productName, pageDisplayStatus FROM product WHERE categoryNumber = :categoryNumber");
    $stmt->execute([':categoryNumber' => $categoryNumber]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $products = [];
}

// JSONとして商品データを返す
header('Content-Type: application/json');
echo json_encode($products);
?>