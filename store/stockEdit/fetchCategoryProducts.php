<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// エラーハンドリングの追加
if (!$pdo) {
    echo json_encode(['error' => 'データベース接続エラー']);
    exit();
}

// ストア番号を取得
$storeNumber = $_SESSION['store']['storeNumber'] ?? null;

if (!$storeNumber) {
    echo json_encode(['error' => 'ストア番号が設定されていません']);
    exit();
}

// カテゴリパラメータの取得
$category = $_GET['category'] ?? '';

// 商品データを取得するSQLクエリ
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
        sc.storeCategoryNumber, 
        sc.storeCategoryName
    FROM product p
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    LEFT JOIN storecategory sc ON p.storeCategoryNumber = sc.storeCategoryNumber
    WHERE p.storeNumber = :storeNumber
";

$params = [':storeNumber' => $storeNumber];

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // データが存在するか確認
    if (!$products) {
        echo json_encode(['error' => '商品データが存在しません']);
        exit();
    }

    // カテゴリ名からカテゴリ番号を取得する関数
    function getCategoryNumber($categoryPath, $pdo) {
        $categoryNames = explode('/', $categoryPath);
        $categoryName = end($categoryNames);
        $stmt = $pdo->prepare("SELECT storeCategoryNumber FROM storecategory WHERE storeCategoryName = :categoryName");
        $stmt->execute([':categoryName' => $categoryName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['storeCategoryNumber'] : null;
    }

    // カテゴリによるフィルタリング
    if ($category && $category !== 'ストアトップ') {
        $categoryNumber = getCategoryNumber($category, $pdo);
        if ($categoryNumber) {
            // カテゴリ番号でフィルタリング
            $filteredProducts = array_filter($products, function($product) use ($categoryNumber) {
                return $product['storeCategoryNumber'] == $categoryNumber;
            });
        } else {
            // カテゴリ番号が見つからない場合
            $filteredProducts = [];
        }
    } else {
        $filteredProducts = $products;
    }

    header('Content-Type: application/json');
    echo json_encode(array_values($filteredProducts)); // 配列形式に変換
} catch (PDOException $e) {
    echo json_encode(['error' => 'SQLエラー: ' . $e->getMessage()]);
} finally {
    $utilConnDB->disconnect($pdo);
}
?>
