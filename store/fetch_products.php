<?php
// セッション開始
session_start();

// データベース接続
require_once('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリパスを取得
$categoryPath = isset($_GET['category']) ? trim($_GET['category']) : '';

// カテゴリ名からカテゴリ番号を取得する関数
function getCategoryNumber($categoryPath, $pdo) {
    // パスが空または無効な場合はnullを返す
    if (empty($categoryPath)) {
        return null;
    }

    $categoryNames = explode('/', $categoryPath);
    $categoryName = end($categoryNames);

    // SQLインジェクション対策済みクエリ
    $stmt = $pdo->prepare("SELECT categoryNumber FROM category WHERE categoryName = :categoryName");
    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['categoryNumber'] : null;
    } catch (PDOException $e) {
        // エラーログ出力
        error_log('Database error: ' . $e->getMessage());
        return null;
    }
}

$categoryNumber = getCategoryNumber($categoryPath, $pdo);

try {
    if ($categoryNumber !== null) {
        // 商品データを取得
        $stmt = $pdo->prepare("SELECT productNumber, productName, pageDisplayStatus FROM product WHERE categoryNumber = :categoryNumber");
        $stmt->bindParam(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $products = [];
    }

    // JSONとして商品データを返す
    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    // エラーログ出力
    error_log('Database error: ' . $e->getMessage());

    // エラーレスポンスを返す
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error']);
}
?>
