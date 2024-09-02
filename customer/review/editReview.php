<?php
session_start();
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// レビューIDと顧客番号を取得
$reviewNumber = $_POST['reviewNumber'] ?? null;
$customerNumber = $_POST['customerNumber'] ?? null;

if ($reviewNumber && $customerNumber) {
    // レビュー情報を取得
    $sql = 'SELECT r.reviewNumber, r.productNumber, r.reviewText, r.evaluation, p.productDescription 
            FROM review r
            JOIN product p ON r.productNumber = p.productNumber
            WHERE r.reviewNumber = :reviewNumber AND r.customerNumber = :customerNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':reviewNumber', $reviewNumber, PDO::PARAM_INT);
    $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch();
} else {
    echo 'レビューIDまたは顧客番号が指定されていません。';
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>レビューの編集</title>
    <link rel="stylesheet" type="text/css" href="../../css/reviewMenu.css" />
</head>
<body>
    <h2>レビューの編集</h2>
    <form action="updateReview.php" method="post">
        <input type="hidden" name="reviewNumber" value="<?= htmlspecialchars($review['reviewNumber'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="productNumber" value="<?= htmlspecialchars($review['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="evaluation" id="evaluation" value="<?= htmlspecialchars($review['evaluation'], ENT_QUOTES, 'UTF-8') ?>">
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
            <textarea name="reviewText" id="reviewText" rows="4" maxlength="300" required><?= htmlspecialchars($review['reviewText'], ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>
        <div>
            <button type="submit">レビューを更新する</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stars = document.querySelectorAll('.star');
            const evaluationInput = document.getElementById('evaluation');
            const currentEvaluation = parseFloat(evaluationInput.value);

            // 初期評価に基づいて星の色を設定
            highlightStars(currentEvaluation);

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const value = parseFloat(star.getAttribute('data-value'));
                    evaluationInput.value = value;
                    highlightStars(value);
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
        });
    </script>
</body>
</html>

