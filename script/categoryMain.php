<?php
session_start();
require_once('utilConnDB.php');
require_once('storeSQL.php');

$utilConnDB = new UtilConnDB();
$storeSQL = new StoreSQL();
$pdo = $utilConnDB->connect();

if (!$pdo) {
    die('データベース接続に失敗しました。');
}

if (!isset($_GET['categoryNumber']) || !is_numeric($_GET['categoryNumber'])) {
    die('カテゴリ番号が正しく指定されていません。');
}

$parentCategoryNumber = intval($_GET['categoryNumber']);

// 親カテゴリの取得
$parentCategory = $storeSQL->categorySelectById($pdo, $parentCategoryNumber);

if (!$parentCategory) {
    die('指定されたカテゴリが存在しません。');
}

// 子カテゴリの取得
$childCategories = $storeSQL->selectChildCategories($pdo, $parentCategoryNumber);

// 商品の取得
$categoryIds = empty($childCategories) ? [$parentCategoryNumber] : array_merge([$parentCategoryNumber], array_column($childCategories, 'categoryNumber'));

// 商品データと画像データの取得
$sql = "
    SELECT p.productNumber, p.productName, p.price, p.categoryNumber, p.stockQuantity, p.productDescription, p.dateAdded, p.releaseDate, p.storeNumber, p.pageDisplayStatus, i.imageHash, i.imageName
    FROM product p
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    WHERE p.categoryNumber IN (" . implode(',', array_fill(0, count($categoryIds), '?')) . ")
";
$stmt = $pdo->prepare($sql);
$stmt->execute($categoryIds);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 商品データを整理
$productsById = [];
foreach ($results as $row) {
    $productNumber = $row['productNumber'];
    if (!isset($productsById[$productNumber])) {
        $productsById[$productNumber] = [
            'productNumber' => $productNumber,
            'productName' => $row['productName'],
            'price' => $row['price'],
            'categoryNumber' => $row['categoryNumber'],
            'stockQuantity' => $row['stockQuantity'],
            'productDescription' => $row['productDescription'],
            'dateAdded' => $row['dateAdded'],
            'releaseDate' => $row['releaseDate'],
            'storeNumber' => $row['storeNumber'],
            'pageDisplayStatus' => $row['pageDisplayStatus'],
            'images' => []
        ];
    }
    if ($row['imageName']) {
        $productsById[$productNumber]['images'][] = $row['imageName'];
    }
}

// セッションにデータを保存
$_SESSION['parentCategory'] = $parentCategory;
$_SESSION['childCategories'] = $childCategories;
$_SESSION['products'] = $productsById; 
$_SESSION['parentCategories'] = $storeSQL->categorySelectParent($pdo);
$_SESSION['category'] = $storeSQL->getCategories($pdo);

// リダイレクト先にカテゴリ番号を追加
header('Location: category.php?categoryNumber=' . $parentCategoryNumber);
exit(); // リダイレクト後の処理を終了
?>
