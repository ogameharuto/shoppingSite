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

// 商品データと画像を取得
$productData = $storeSQL->fetchProductDataAndImages($pdo, $productNumbers);

// 商品ごとの画像データを整理
$imagesByProduct = [];
foreach ($productData as $data) {
    $productNumber = $data['productNumber'];
    if (!isset($imagesByProduct[$productNumber])) {
        $imagesByProduct[$productNumber] = [];
    }
    if ($data['imageName']) {
        $imagesByProduct[$productNumber][] = [
            'imageNumber' => $data['imageNumber'],
            'imageHash'   => $data['imageHash'],
            'imageName'   => $data['imageName']
        ];
    }
}
// セッションにデータを保存
$_SESSION['searchTerm'] = $query;
$_SESSION['products'] = $products;
$_SESSION['images'] = $imagesByProduct;

// 検索結果ページにリダイレクト
header('Location: productSearchList.php');
exit;
?>
