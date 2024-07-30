<?php
session_start();
$storeNumber = $_SESSION['store'];

// データベース接続設定
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品データを取得するクエリ
$sql = "SELECT productNumber, productName, categoryNumber, stockQuantity, pageDisplayStatus 
        FROM product 
        WHERE storeNumber = :storeNumber";
$statement = $pdo->prepare($sql);
$statement->bindParam(':storeNumber', $storeNumber['storeNumber'], PDO::PARAM_INT);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

// カテゴリ情報を取得
$sql = "SELECT categoryNumber, categoryName FROM category";
$categoryStatement = $pdo->prepare($sql);
$categoryStatement->execute();
$categories = $categoryStatement->fetchAll(PDO::FETCH_ASSOC);

// カテゴリ情報を連想配列に変換
$categoryMap = [];
foreach ($categories as $category) {
    $categoryMap[$category['categoryNumber']] = $category['categoryName'];
}

// 商品一覧のHTMLを生成
$productListHTML = '';
foreach ($products as $product) {
    $categoryName = isset($categoryMap[$product['categoryNumber']]) ? $categoryMap[$product['categoryNumber']] : '不明';
    $status = $product['pageDisplayStatus'] ? '公開中' : '非公開';

    // ステータスの変更フォーム
    $statusToggle = $product['pageDisplayStatus'] ? 
        "<form method='POST' action='toggleStatus.php'>
            <input type='hidden' name='productNumber' value='{$product['productNumber']}'>
            <button type='submit' name='action' value='hide'>非公開</button>
        </form>" :
        "<form method='POST' action='toggleStatus.php'>
            <input type='hidden' name='productNumber' value='{$product['productNumber']}'>
            <button type='submit' name='action' value='show'>公開</button>
        </form>";

    $productListHTML .= "<tr>
        <td><input type='checkbox' name='product[]' value='{$product['productNumber']}'></td>
        <td>{$product['productNumber']}</td>
        <td>{$product['productName']}</td>
        <td>{$categoryName}</td>
        <td>{$product['stockQuantity']}</td>
        <td>{$status} $statusToggle</td>
    </tr>";
}

// 商品リストを含むHTMLを表示する
echo $productListHTML;
?>
