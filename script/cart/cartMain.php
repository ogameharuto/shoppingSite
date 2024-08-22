<?php
header('Content-Type: text/plain; charset=utf-8');

// インポート
require_once('../storeSQL.php');
require_once('../utilConnDB.php');

// インスタンス生成
$storeSQL = new StoreSQL();
$utilConnDB = new UtilConnDB();

// DB接続
$pdo = $utilConnDB->connect();
if (!$pdo) {
    die('データベース接続に失敗しました。');
}

// セッション開始
session_start();

// 顧客番号の取得
$customerNumber = $_SESSION['customer']['customerNumber'] ?? null;

// カートリストの取得
$cartList = [];
if ($customerNumber !== null) {
    try {
        $cartList = $storeSQL->selectCartItems($pdo, $customerNumber);
    } catch (Exception $e) {
        die('カートアイテムの取得に失敗しました。');
    }
} else {
    // 顧客番号がセッションに保存されていない場合の処理
    $cartList = [];
}

// 商品番号の抽出
$productNumbers = array_column($cartList, 'productNumber');

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

// DB切断
$utilConnDB->disconnect($pdo);

// データをセッションに保存
$_SESSION['cartList'] = $cartList;
$_SESSION['images'] = $imagesByProduct;

// 次に実行するモジュール
header('Location: cartList.php');
exit;
?>
