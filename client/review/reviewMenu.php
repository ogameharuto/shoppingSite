<?php
session_start();
// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 商品IDを取得
$productNumber = 1;

$customerNumber = 1;

// 商品情報を取得
$sqlProduct = 'SELECT p.productDescription, i.imageName 
               FROM product p
               JOIN images i ON p.imageNumber = i.imageNumber
               WHERE p.productNumber = :productNumber';
$stmtProduct = $pdo->prepare($sqlProduct);
$stmtProduct->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
$stmtProduct->execute();
$product = $stmtProduct->fetch();

// 顧客が投稿したレビューを取得
$sqlReviews = 'SELECT r.reviewNumber, p.productDescription, i.imageName, r.reviewText, r.evaluation 
               FROM review r
               JOIN product p ON r.productNumber = p.productNumber
               JOIN images i ON p.imageNumber = i.imageNumber
               WHERE r.customerNumber = :customerNumber';
$stmtReviews = $pdo->prepare($sqlReviews);
$stmtReviews->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
$stmtReviews->execute();
$reviews = $stmtReviews->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品レビュー</title>
    <link rel="stylesheet" type="text/css" href="reviewMenu.css" />
</head>
<body>
    <div class="product-info">
        <?php if ($product): ?>
            <img src="../uploads/<?= htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($product['productDescription'], ENT_QUOTES, 'UTF-8') ?>" width="150" height="150">
            <p class="product-name"><?= htmlspecialchars($product['productDescription'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php else: ?>
            <p>商品情報が見つかりません。</p>
        <?php endif; ?>
    </div>
    
    <h2>レビューを投稿する</h2>
    <form action="reviewMain.php" method="post">
        <input type="hidden" name="productNumber" value="<?= htmlspecialchars($productNumber, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="evaluation" id="evaluation" value="">
        <div>
            <label for="stars">評価:</label>
            <div class="stars" id="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="star" data-value="<?= $i ?>">★</div>
                <?php endfor; ?>
            </div>
        </div>
        <div>
            <label for="reviewText">レビュー:</label>
            <textarea name="reviewText" id="reviewText" rows="4" maxlength="300" required></textarea>
        </div>
        <div>
            <button type="submit">レビューを投稿する</button>
        </div>
    </form>
    <h2>投稿したレビュー</h2>
    <div class="customer-reviews">
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <img src="../uploads/<?= htmlspecialchars($review['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($review['productDescription'], ENT_QUOTES, 'UTF-8') ?>" width="100" height="100">
                    <p class="product-name"><?= htmlspecialchars($review['productDescription'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="evaluation">
                        評価:
                        <?php
                            $fullStars = floor($review['evaluation']);
                            $halfStar = ($review['evaluation'] - $fullStars) >= 0.5;
                            echo str_repeat('★', $fullStars);
                            if ($halfStar) {
                                echo '☆'; 
                            }
                            echo str_repeat('☆', 5 - ceil($review['evaluation']));
                        ?>
                    </p>
                    <p><?= htmlspecialchars($review['reviewText'], ENT_QUOTES, 'UTF-8') ?></p>
                    <div class="review-actions">
                        <form action="deleteReview.php" method="post">
                            <input type="hidden" name="reviewNumber" value="<?= htmlspecialchars($review['reviewNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" onclick="return confirm('このレビューを削除してもよろしいですか？')">削除</button>
                        </form>
                        <form action="editReview.php" method="post">
                            <input type="hidden" name="reviewNumber" value="<?= htmlspecialchars($review['reviewNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit">編集</button>
                        </form>
                    </div>             
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>投稿したレビューがありません。</p>
        <?php endif; ?>
    </div>
    <script>
        const stars = document.querySelectorAll('.star');
        const evaluationInput = document.getElementById('evaluation');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = parseFloat(star.getAttribute('data-value'));
                evaluationInput.value = value;
                highlightStars(value);
            });
            star.addEventListener('mouseout', () => {
                highlightStars(parseFloat(evaluationInput.value));
            });
        });

        function highlightStars(value) {
            stars.forEach(star => {
                const starValue = parseFloat(star.getAttribute('data-value'));
                if (starValue <= value) {
                    star.classList.add('full');
                } else {
                    star.classList.remove('full');
                }
            });
        }
    </script>
</body>
</html>
