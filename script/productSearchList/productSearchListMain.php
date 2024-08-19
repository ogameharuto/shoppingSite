<?php
session_start();
require_once('../utilConnDB.php');
require_once('../storeSQL.php');

$utilConnDB = new UtilConnDB();
$storeSQL = new StoreSQL();
$pdo = $utilConnDB->connect();

// 検索クエリの取得
$query = isset($_GET['query']) ? $_GET['query'] : '';

// 商品を検索
$products = $storeSQL->searchProducts($pdo, $query);

// 商品番号のリストを取得
$productNumbers = array_column($products, 'productNumber');

if (!empty($products)) {
    foreach ($products as $cartItem) {
        $productNumber = $cartItem['productNumber'] ?? null;
        if ($productNumber) {
            $images = $storeSQL->fetchProductDataAndImages($pdo, $productNumber);
            if (!empty($images)) {
                $productImages[$productNumber] = $images;
            }
        }
    }
}

echo '<pre>';
print_r($productImages);
echo '</pre>';
// セッションにデータを保存
$_SESSION['searchTerm'] = $query;
$_SESSION['products'] = $products;
$_SESSION['images'] = $productImages;

// 検索結果ページにリダイレクト
header('Location: productSearchList.php');
exit;
?>
