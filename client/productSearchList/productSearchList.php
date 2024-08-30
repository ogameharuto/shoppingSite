<?php
session_start(); // セッション開始
require_once('../../utilConnDB.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// セッションから検索結果を取得
$products = $_SESSION['products'] ?? [];
$query = $_SESSION['searchTerm'] ?? '';
$images = $_SESSION['images'] ?? [];
$customerNumber = $_SESSION['customer']['customerNumber'];

// セッションデータの削除
unset($_SESSION['products']);
unset($_SESSION['searchTerm']);
unset($_SESSION['images']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="productSearchList.css" />
    <link rel="stylesheet" type="text/css" href="../header.css" />
    <title>商品検索一覧</title>
</head>
<body>
    <div class="header">
        <div class="CenteredContainer">
            <div class="whole">
                <?php require_once("../header.php"); ?>
            </div>
            <div class="searchResults">
                <h1 class="searchText"><?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></h1>
                <span class="results">の検索結果</span>
            </div>
        </div>
    </div>
    <main class="pageFrame">
        <div class="CenteredContainer">
            <div class="searchTemplate">
                <div class="searchList_Left">
                    <span class="">絞り込み</span>
                </div>
                <div class="searchList">
                    <div class="displayOption">
                        <div class="search">
                            <p class="searchNumber"><?php echo count($products); ?></p>
                            <div class="select">
                                <div class="recommendedOrder">
                                    <select id="productSelect" onchange="sortProducts()">
                                        <option value="">おすすめ順</option>
                                        <option value="priceLow">価格が安い順</option>
                                        <option value="priceHigh">価格が高い順</option>
                                        <option value="priceShippingLow">価格＋送料が安い順</option>
                                        <option value="priceShippingHigh">価格＋送料が高い順</option>
                                        <option value="reviewCount">レビュー件数順</option>
                                        <option value="reviewScore">レビュー点順</option>
                                        <option value="discount">割引率の高い順</option>
                                    </select>
                                </div>
                                <div class="sortPrice">
                                    <select id="priceSelect" onchange="sortProducts()">
                                        <option value="">商品価格</option>
                                        <option value="immediateUse">今すぐ利用価格</option>
                                        <option value="actual">実質価格</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="displayInformation">
                            <span class="informationText">
                                表示情報について｜ポイント等は原則税抜価格を基準に付与されます｜ポイント・支払額等の正確な情報（付与条件・上限等）はカートをご確認ください
                            </span>
                        </div>
                    </div>
                    <div class="productList" id="productList">
                        <?php foreach ($products as $product): ?>
                        <div class="product">
                            <div class="width">
                                <?php
                                // 商品ごとの画像を表示する
                                if (isset($images[$product['productNumber']])) {
                                    foreach ($images[$product['productNumber']] as $image) {
                                        echo '<img src="../uploads/' . htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') . '" width="150" height="150">';
                                    }
                                } else {
                                    echo '<p>画像がありません。</p>';
                                }
                                
                                // お気に入りに追加されているか確認
                                $favoriteActive = false;
                                $sql = "SELECT COUNT(*) FROM favoriteProducts WHERE customerNumber = :customerNumber AND productNumber = :productNumber";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
                                $stmt->bindParam(':productNumber', $product['productNumber'], PDO::PARAM_INT);
                                $stmt->execute();
                                
                                $count = $stmt->fetchColumn();
                                if ($count > 0) {
                                    $favoriteActive = true;
                                }
                                ?>
                                <p><a href="http://localhost/shopp/script/productDetails/productDetailsMain.php?productNumber=<?php echo htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>" class="text"><?php echo htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                                <p>
                                    <span class="price"><?php echo number_format(htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8')); ?>円</span>
                                </p>
                                <button class="favorite-button <?php echo $favoriteActive ? 'active' : ''; ?>"
                                    data-product-number="<?php echo htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    data-customer-number="<?php echo htmlspecialchars($customerNumber, ENT_QUOTES, 'UTF-8'); ?>">&#9829;
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favoriteButtons = document.querySelectorAll('.favorite-button');

            favoriteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const productNumber = this.getAttribute('data-product-number');
                    const customerNumber = this.getAttribute('data-customer-number');
                    const isActive = this.classList.contains('active');

                    // ボタンの色を変更
                    this.classList.toggle('active');

                    // AJAXリクエストで商品番号と顧客番号をサーバーに送信
                    fetch('../productDetails/toggleFavorite.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ productNumber: productNumber, customerNumber: customerNumber, isActive: isActive })

                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('お気に入りリストが更新されました。');
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
</body>
</html>
