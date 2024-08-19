<?php
session_start();
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if (isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    $storeNumber = $_SESSION['store']['storeNumber'];  // 修正: 直接値を取得

    // カテゴリ名に基づいてcategoryNumberを取得
    $sql = "SELECT categoryNumber FROM category WHERE categoryName = :categoryName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($category) {
        $categoryNumber = $category['categoryNumber'];

        // 指定されたカテゴリに基づいて商品を取得
        $sql = "SELECT productNumber, productName, categoryNumber, stockQuantity, pageDisplayStatus 
                FROM product 
                WHERE storeNumber = :storeNumber AND categoryNumber = :categoryNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);  // 修正: 直接値を取得
        $stmt->bindParam(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // カテゴリが見つからない場合、全カテゴリの商品を取得
        $sql = "SELECT productNumber, productName, categoryNumber, stockQuantity, pageDisplayStatus 
                FROM product 
                WHERE storeNumber = :storeNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);  // 修正: 直接値を取得
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // カテゴリ情報を取得
    $sql = "SELECT categoryNumber, categoryName FROM category";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        $statusToggle = $product['pageDisplayStatus'] ? 
            "<form method='POST' action='toggleStatus.php' style='display:inline;'>
                <input type='hidden' name='productNumber' value='{$product['productNumber']}'>
                <button type='submit' name='action' value='hide'>非公開</button>
            </form>" :
            "<form method='POST' action='toggleStatus.php' style='display:inline;'>
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

    echo $productListHTML;
}
?>
