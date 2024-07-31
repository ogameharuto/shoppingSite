<?php
session_start();
$storeNumber = $_SESSION['store'];

// データベース接続設定
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// お客様番号に基づいて商品データを取得するクエリ
$sql = "SELECT productNumber, productName, categoryNumber, stockQuantity, pageDisplayStatus, productImageURL 
        FROM product 
        WHERE storeNumber = :storeNumber";
$statement = $pdo->prepare($sql);
$statement->bindParam(':storeNumber', $storeNumber['storeNumber'], PDO::PARAM_INT);
$statement->execute();

// 結果を取得
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
    $productImageURL = $product['productImageURL'] ? $product['productImageURL'] : 'default-image.jpg';

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
        <td><img src='{$productImageURL}' alt='Product Image' style='width: 50px; height: auto;'></td>
        <td>{$product['productName']}</td>
        <td>{$categoryName}</td>
        <td>{$status}$statusToggle</td>
    </tr>";
}

// 商品リストを含むHTMLを表示する
echo $productListHTML;
?>
