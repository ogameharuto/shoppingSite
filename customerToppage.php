<?php
session_start();
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品データと画像データの取得
$sql = "
    SELECT p.productNumber, p.productName, p.price, p.categoryNumber, p.stockQuantity, p.productDescription, p.dateAdded, p.releaseDate, p.storeNumber, p.pageDisplayStatus, i.imageHash, i.imageName
    FROM product p
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    WHERE p.pageDisplayStatus = 1
";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリデータの取得
$categoryStmt = $pdo->prepare("SELECT * FROM category");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

// セッションに商品番号を追加する処理
if (isset($_GET['productNumber'])) {
    $productNumber = intval($_GET['productNumber']);
    if (!isset($_SESSION['viewed_products'])) {
        $_SESSION['viewed_products'] = [];
    }
    if (!in_array($productNumber, $_SESSION['viewed_products'])) {
        $_SESSION['viewed_products'][] = $productNumber;
    }
    header("Location: index.php");
    exit;
}

// 顧客名の取得
$sql = "SELECT customerName FROM customer WHERE customerNumber = :customerNumber";
$stmt = $pdo->prepare($sql);
$stmt->execute([':customerNumber' => $_SESSION['customer']['customerNumber'] ?? null]);
$customerName = $stmt->fetch(PDO::FETCH_ASSOC);

// ゲスト処理
if (!isset($_SESSION['customer']) || empty($_SESSION['customer']['customerNumber'])) {
    if (!isset($_SESSION['customer']) || $_SESSION['customer']['customerName'] != 'ゲスト') {
        $mailAddress = "random_email_" . uniqid() . "@example.com";

        try {
            // ゲスト顧客の追加
            $sql = "
                INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) 
                VALUES('ゲスト', 'ゲスト', 'なし', 'なし', '1980-01-01', :mailAddress, 'なし', 'なし')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':mailAddress' => $mailAddress]);

            // コミット
            $pdo->commit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $pdo->rollBack();
            exit;
        }

        try {
            // 登録されたcustomerNumberを取得
            $sql = "SELECT customerNumber FROM customer WHERE mailAddress = :mailAddress";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':mailAddress' => $mailAddress]);
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($customer) {
                $customerNumber = intval($customer['customerNumber']);
                $_SESSION['customer'] = [
                    'customerNumber' => $customerNumber,
                    'customerName' => 'ゲスト'
                ];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
    $_SESSION['login'] = null;
} else {
    $_SESSION['login'] = "true";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="css/customerToppage.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<?php include "customer/header.php"; ?>
<div class="container">
    <div class="sidebar">
        <h2>カテゴリから探す</h2>
        <ul class="parent-categories">
            <?php foreach ($categories as $category): ?>
                <?php if ($category['parentCategoryNumber'] == 0): ?>
                    <li class="parent-category">
                        <a href="customer/category/categoryMain.php?categoryNumber=<?= htmlspecialchars($category['categoryNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                        <?php
                        $childCategories = array_filter($categories, function($cat) use ($category) {
                            return $cat['parentCategoryNumber'] == $category['categoryNumber'];
                        });
                        ?>
                        <?php if (!empty($childCategories)): ?>
                            <ul class="child-categories">
                                <?php foreach ($childCategories as $childCategory): ?>
                                    <li>
                                        <a href="customer/category/categoryMain.php?categoryNumber=<?= htmlspecialchars($childCategory['categoryNumber'], ENT_QUOTES, 'UTF-8') ?>">
                                            <?= htmlspecialchars($childCategory['categoryName'], ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="main-content">
        <div class="product-list-container">
            <h2 class="product-list-title">商品一覧</h2>
            <div class="product-list-wrapper">
                <button class="slide-buttonP left">&lt;</button>
                <div class="product-list">
                    <?php foreach ($products as $product): ?>
                        <div class="product">
                            <a href="customer/productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <?php if (!empty($product['imageHash'])): ?>
                                <img src="uploads/<?= htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8') ?>">
                            <?php else: ?>
                                <img src="default-image.png" alt="商品画像がありません">
                            <?php endif; ?>
                                <p>価格: <?= number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')) ?>円</p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="slide-buttonP right">&gt;</button>
            </div>
        </div>
        <div class="product-list-container">
            <?php foreach ($categories as $category): ?>
                <?php
                // 現在のカテゴリ内の商品を取得
                $categoryProducts = array_filter($products, function($product) use ($category) {
                    return $product['categoryNumber'] == $category['categoryNumber'];
                });
                ?>
                <?php if (!empty($categoryProducts)): ?>
                    <div class="category-products">
                        <h2 class="product-list-title"><?= htmlspecialchars($category['categoryName'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <div class="product-list-wrapper">
                            <button class="slide-buttonC left">&lt;</button>
                            <div class="product-list">
                                <?php foreach ($categoryProducts as $product): ?>
                                    <div class="product">
                                        <a href="customer/productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
                                            <?php if (!empty($product['imageHash'])): ?>
                                                <img src="uploads/<?= htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8') ?>">
                                            <?php else: ?>
                                                <img src="default-image.png" alt="商品画像がありません">
                                            <?php endif; ?>
                                            <p>価格: <?= number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')) ?>円</p>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="slide-buttonC right">&gt;</button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttonsP = document.querySelectorAll('.slide-buttonP');
        buttonsP.forEach(button => {
            button.addEventListener('click', function() {
                const isLeftButton = this.classList.contains('left');
                const productListWrapper = this.nextElementSibling || this.previousElementSibling;
                const scrollAmount = 500;

                if (isLeftButton) {
                    productListWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    productListWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            });
        });

        const buttonsC = document.querySelectorAll('.slide-buttonC');
        buttonsC.forEach(button => {
            button.addEventListener('click', function() {
                const isLeftButton = this.classList.contains('left');
                const productListWrapper = this.nextElementSibling || this.previousElementSibling;
                const scrollAmount = 500;

                if (isLeftButton) {
                    productListWrapper.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                } else {
                    productListWrapper.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            });
        });
    });
</script>
</body>
</html>
