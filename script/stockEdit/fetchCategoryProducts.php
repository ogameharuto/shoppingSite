<?php
session_start();
require_once('../../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if (isset($_POST['categoryName'])) {
    $categoryName = $_POST['categoryName'];
    $storeNumber = $_SESSION['store']['storeNumber'];

    // カテゴリ名に基づいてcategoryNumberを取得
    $sql = "SELECT categoryNumber FROM category WHERE categoryName = :categoryName";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    $products = []; // 商品リストの初期化

    if ($category) {
        $categoryNumber = $category['categoryNumber'];

        // 指定されたカテゴリに基づいて商品を取得
        $sql = "
        SELECT 
            p.productNumber, 
            p.productName, 
            p.price, 
            p.stockQuantity, 
            p.productDescription, 
            p.dateAdded, 
            p.releaseDate, 
            p.storeNumber, 
            p.pageDisplayStatus, 
            i.imageNumber,
            i.imageHash, 
            i.imageName,
            c.categoryNumber, 
            c.categoryName
        FROM product p
        LEFT JOIN images i ON p.imageNumber = i.imageNumber
        LEFT JOIN category c ON p.categoryNumber = c.categoryNumber
        WHERE p.storeNumber = :storeNumber AND c.categoryNumber = :categoryNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT); 
        $stmt->bindParam(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // カテゴリが見つからない場合、全カテゴリの商品を取得
        $sql = "
        SELECT 
            p.productNumber, 
            p.productName, 
            p.price, 
            p.stockQuantity, 
            p.productDescription, 
            p.dateAdded, 
            p.releaseDate, 
            p.storeNumber, 
            p.pageDisplayStatus, 
            i.imageNumber,
            i.imageHash, 
            i.imageName,
            c.categoryNumber, 
            c.categoryName
        FROM product p
        LEFT JOIN images i ON p.imageNumber = i.imageNumber
        LEFT JOIN category c ON p.categoryNumber = c.categoryNumber
        WHERE p.storeNumber = :storeNumber
    ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT); 
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
    foreach ($categories as $cat) {
        $categoryMap[$cat['categoryNumber']] = $cat['categoryName'];
    }

    // 商品一覧のHTMLを生成
    $productListHTML = '';
    foreach ($products as $product) {
        $categoryName = $categoryMap[$product['categoryNumber']] ?? '不明';

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

        // 商品画像を追加
        $productImage = !empty($product['imageName']) ? "<img src='../uploads/{$product['imageName']}' alt='{$product['imageName']}' width='100'>" : '画像なし';

        $productListHTML .= "<tr>
            <td><input type='checkbox' name='product[]' value='{$product['productNumber']}'></td>
            <td>{$product['productNumber']}</td>
            <td>{$productImage}</td>
            <td>{$product['productName']}</td>
            <td>{$categoryName}</td>
            <td>{$product['stockQuantity']}</td>
            <td>{$status} $statusToggle</td>
        </tr>";
    }

    echo $productListHTML;
}
?>
