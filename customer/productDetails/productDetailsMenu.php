<?php
session_start();
require_once('../../utilConnDB.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$product = isset($_SESSION['product']) ? $_SESSION['product'] : null;
$categoryTreeHTML = isset($_SESSION['categoryTreeHTML']) ? $_SESSION['categoryTreeHTML'] : '';
$reviews = isset($_SESSION['reviews']) ? $_SESSION['reviews'] : [];
$stores = isset($_SESSION['stores']) ? $_SESSION['stores'] : null;
$images = isset($_SESSION['image']) ? $_SESSION['image'] : [];
$customerNumber = isset($_SESSION['customer']['customerNumber']) ? $_SESSION['customer']['customerNumber'] : null;
$customerName = $_SESSION['customer']['customerName'] ?? 'ゲスト';
if (!$product || !$stores) {
    echo "表示するデータがありません。";
    exit;
}

$favoriteActive = false;

if ($customerNumber) {
    $sql = "SELECT COUNT(*) FROM favoriteProducts WHERE customerNumber = :customerNumber AND productNumber = :productNumber";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
    $stmt->bindParam(':productNumber', $product['productNumber'], PDO::PARAM_INT);
    $stmt->execute();
    
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        $favoriteActive = true; 
    }
}

function renderStars($rating) {
    $totalStars = 5;
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = $totalStars - $fullStars - ($halfStar ? 1 : 0);

    $stars = '';
    for ($i = 1; $i <= $fullStars; $i++) {
        $stars .= '<span class="star full">&#9733;</span>'; // ★
    }
    if ($halfStar) {
        $stars .= '<span class="star half">&#9733;</span>'; // ★
    }
    for ($i = 1; $i <= $emptyStars; $i++) {
        $stars .= '<span class="star empty">&#9733;</span>'; // ★
    }

    return $stars;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/productDetails.css" />
    <link rel="stylesheet" type="text/css" href="../../css/header.css" />
    <title>商品詳細</title>
</head>
<body>
    <div class="main">
        <div class="header">
            <?php include "../header.php"; ?>
        </div>
        <div class="storeInfmation">
            <span><?= htmlspecialchars($stores["storeName"], ENT_QUOTES, 'UTF-8'); ?></span>
            <div class="storeMenu">
                <div class="top-section">
                <a href="../storeInformation/storeInformation.php?storeNumber=<?= htmlspecialchars($product['storeNumber'], ENT_QUOTES, 'UTF-8') ?>">会社概要</a>
                </div>
            </div>
        </div>
        <div class="productList">
            <div class="product">
            <div class="image">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $image): ?>
                        <div class="image-wrapper">
                            <img src="../../uploads/<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>">
                            <button class="favorite-button <?= $favoriteActive ? 'active' : '' ?>"
                                    data-product-number="<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?>" 
                                    data-customer-number="<?= htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8') ?>"
                                    data-customer-name="<?= htmlspecialchars($customerName, ENT_QUOTES, 'UTF-8') ?>">&#9829;
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>画像がありません。</p>
                <?php endif; ?>
            </div>
                <div class="detail">
                    <div class="mdItemName">
                        <p class="elName"><?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="mdItemPrice" id="prcdsp" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <p class="elPriceName">通常価格（税込）</p>
                        <div class="elPriceArea">
                            <div class="elItemPriceInner">
                                <p><span class="elPriceNumber" itemprop="price"><?= number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')) ?></span><span class="elPriceUnit">円</span></p>
                            </div>
                            <p class="elPostageFree">送料無料<span class="elPostagePref">（東京都）</span></p>
                        </div>
                        <div class="elPostageArea">
                            <p class="elPostageNotice">条件により送料が異なる場合があります。</p>
                        </div>
                    </div>
                    <div class="mdDeliveryInformation" id="delinfo">
                        <div class="elContents">
                            <p class="elDeliveryScheduleInfo">
                                <span class="elDeliveryScheduleText"></span>
                            </p>
                            <p class="elOptionInfo">
                                <span class="elSelectableDeliveryText">お届け日指定可</span>
                            </p>
                        </div>
                    </div>
                    <div class="mdItemComment" data-itemComment>
                        <div class="elHeaderTitle">ストアコメント</div>
                        <div class="elContentWrapper" data-itemComment-parts="base">
                            <div class="mdFreeSpace isLoading">
                                <div class="elContent">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review">
                <div class="reviews">
                    <div class="reviewCount">
                        <h2>この商品のレビュー</h2>
                        <span class="count">（<?php echo (count($reviews)); ?>件の商品レビュー）</span>
                    </div>
                    <?php if (count($reviews) > 0): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="stars">
                                    <?= renderStars((float) htmlspecialchars($review['evaluation'], ENT_QUOTES, 'UTF-8')) ?>
                                    <span class="evaluationCount"><?= htmlspecialchars($review['evaluation'], ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <p class="reviewUser"><?= htmlspecialchars($review['customerName'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="reviewText"><?= htmlspecialchars($review['reviewText'], ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>レビューはまだありません。</p>
                    <?php endif; ?>
                </div>
                <div class="others">
                    <span></span>
                </div>
            </div>
            <div class="productInformation">
                <div class="productInf">
                    <h2>商品情報</h2><br>
                    <p class="productName"><?= htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8')  ?></p><br><br>
                    <h2>商品説明</h2><br><br>
                    <p class="productDescri"><?= htmlspecialchars($product['productDescription'], ENT_QUOTES, 'UTF-8') ?></p><br><br>
                    <p class="productCategory">商品カテゴリ&emsp;<?= htmlspecialchars($categoryTreeHTML, ENT_QUOTES, 'UTF-8') ?></p><br>
                    <p class="productNumber">商品コード&emsp;&emsp;<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?></p><br>
                </div>
            </div>
            <div class="storeInformation">
                <div class="storeInf">
                    <h2>ストア情報</h2><br>
                    <p><?= htmlspecialchars($stores['storeName'], ENT_QUOTES, 'UTF-8') ?><p>
                </div>
            </div>
            <div class="price">
                <div class="uiCartSummary" data-libSticky data-libSticky-id="cartSummary">
                    <div class="mdCartSummary" id="upcart" data-cartSummary itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <form class="elItemInfo" name="addCart" action="addCart.php" method="post" data-cartSummary-parts="summaryInner">
                            <input name="productNumber" type="hidden" value="<?= htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="elPriceArea">
                                <div class="elPriceWrap">
                                    <p class="elPriceTitle">通常価格（税込）</p>
                                    <p class="elPriceData">
                                        <span class="elPrice" itemprop="price"><?= number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')) ?><span class="elUnit">円</span></span>
                                    </p>
                                </div>
                                <p class="elPostageWrap isFree">
                                    <span class="elPostage">送料無料</span>
                                </p>
                            </div>
                            <div class="elItemOptionsArea">
                                <div class="elItemOptionsAreaInner" data-cartsummary-parts="scrollWrapper">
                                    <dl class="elScrollItem" data-cartsummary-parts="scrollItem">
                                    </dl>
                                </div>
                            </div>
                            <div class="elQuantityArea" data-quantity data-quantity-id="cartSummary" data-quantity-parameter="minValue:1,maxValue:100">
                                <div class="elSelectQuantity">
                                    <p class="elQuantityTitle">数量</p>
                                    <div class="elInputWrap">
                                        <input type="text" name="quantity" class="elQuantityInput" value="1" pattern="^[0-9０-９]+$" data-quantity-parts="input" maxlength="3">
                                    </div>
                                </div>
                                <ul class="elQuantityConditions">
                                    <li class="elQuantityCondition">残り在庫数<?= htmlspecialchars($product['stockQuantity'], ENT_QUOTES, 'UTF-8') ?></li>
                                </ul>
                            </div>
                            <div class="elActionsArea">
                                <div class="elAction">
                                    <button class="elAddCart" type="submit">カートに入れる</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.favorite-button');

    favoriteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productNumber = this.getAttribute('data-product-number');
            const customerNumber = this.getAttribute('data-customer-number');
            const customerName = this.getAttribute('data-customer-name');
            const isActive = this.classList.contains('active');

            if (customerName === 'ゲスト') {
                alert('ログインしてください。');
                return;
            }

            // ボタンの色を変更
            this.classList.toggle('active');

            // AJAXリクエストで商品番号と顧客番号をサーバーに送信
            fetch('../favorite/toggleFavorite.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productNumber: productNumber, customerNumber: customerNumber, isActive: isActive })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('商品がお気に入りに追加されました。');
                } else {
                    console.log('エラーが発生しました:', data.message);
                }
            })
            .catch(error => {
                console.error('エラーが発生しました:', error);
            });
        });
    });
});
        </script>
    </div>
</body>
</html>
