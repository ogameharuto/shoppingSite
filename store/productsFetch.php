<?php
// セッション開始
session_start();
$storeNumber = $_SESSION['store']['storeNumber'];

// データベース接続
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリパスを取得
$categoryPath = $_GET['category'] ?? '';

// カテゴリ名からカテゴリ番号を取得する関数
function getStoreCategoryNumber($categoryPath, $pdo)
{
    $categoryNames = explode('/', $categoryPath);
    $categoryName = end($categoryNames);
    $stmt = $pdo->prepare("SELECT storeCategoryNumber FROM storeCategory WHERE storeCategoryName = :storeCategoryName");
    $stmt->execute([':storeCategoryName' => $categoryName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['storeCategoryNumber'] : null;
}

$categoryNumber = getStoreCategoryNumber($categoryPath, $pdo);

// SQLクエリを準備
$sql = "SELECT p.productNumber, p.productName, p.pageDisplayStatus, i.imageName
        FROM product p
        LEFT JOIN images i ON p.imageNumber = i.imageNumber
        WHERE p.storeNumber = :storeNumber";

// カテゴリ番号が存在する場合はWHERE句に追加
if ($categoryNumber !== null) {
    $sql .= " AND p.storeCategoryNumber = :storeCategoryNumber";
}

$stmt = $pdo->prepare($sql);

$params = ['storeNumber' => $storeNumber];

if ($categoryNumber !== null) {
    $params['storeCategoryNumber'] = $categoryNumber;
}

$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// デバッグ用ログ
error_log('Fetched products: ' . json_encode($products));

// JSONとして商品データを返す
header('Content-Type: application/json');
echo json_encode($products);
?>