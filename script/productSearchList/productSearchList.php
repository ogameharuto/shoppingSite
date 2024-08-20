<?php
session_start(); // セッション開始

// セッションから検索結果を取得
$products = $_SESSION['products'] ?? [];
$query = $_SESSION['searchTerm'] ?? '';
$images = $_SESSION['images'] ?? [];

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
                                        echo '<img src="../imageIns/uploads/' . htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') . '" width="150" height="150">';
                                    }
                                } else {
                                    echo '<p>画像がありません。</p>';
                                }
                                ?>
                                <p><a href="http://localhost/shopp/script/productDetails/productDetailsMain.php?productNumber=<?php echo htmlspecialchars($product['productNumber'], ENT_QUOTES, 'UTF-8'); ?>" class="text"><?php echo htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?></a></p>
                                <p>
                                    <span class="price"><?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>円</span>
                                    <span class="postage">＋送料</span>
                                </p>
                                <p>
                                    <a href="<?php echo htmlspecialchars($product['storeName'], ENT_QUOTES, 'UTF-8'); ?>" class="store">
                                        <span><?php echo htmlspecialchars($product['storeName'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    </a>
                                </p>
                                <button class="favoriteBtn">
                                    <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true" class="Symbol">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.4 11.57a8.94 8.94 0 0 0-12.55 0L24 14.4l-2.85-2.82a8.94 8.94,0 0 0-12.55 0 8.7 8.7 0 0 0 0 12.4l2.85 2.83 12.2 12.05c.2.2.51.2.7 0l1.05-1.02L36.55 26.8l2.85-2.82a8.7 8.7 0 0 0 0-12.4Z"></path>
                                    </svg>
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
        function sortProducts() {
            const productSort = document.getElementById('productSelect').value;
            const priceSort = document.getElementById('priceSelect').value;

            fetch('fetchProducts.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    productSort: productSort,
                    priceSort: priceSort
                })
            })
            .then(response => response.json())
            .then(data => {
                renderProducts(data);
            })
            .catch(error => console.error('Error:', error));
        }

        function renderProducts(products) {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';

            products.forEach(product => {
                const productDiv = document.createElement('div');
                productDiv.classList.add('product');
                productDiv.innerHTML = `
                    <div class="width">
                        ${product.images.map(image => `<img src="../imageIns/uploads/${image.imageName}" alt="${image.imageName}" width="120" height="120">`).join('') || '<p>画像がありません。</p>'}
                        <p><a href="productDetailsMain.php?productNumber=${product.productNumber}" class="text">${product.productName}</a></p>
                        <p>
                            <span class="price">${product.price}円</span>
                            <span class="postage">＋送料</span>
                        </p>
                        <p>
                            <a href="${product.storeName}" class="store">
                                <span>${product.storeName}</span>
                            </a>
                        </p>
                        <button class="favoriteBtn">
                            <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true" class="Symbol">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M39.4 11.57a8.94 8.94 0 0 0-12.55 0L24 14.4l-2.85-2.82a8.94 8.94,0 0 0-12.55 0 8.7 8.7 0 0 0 0 12.4l2.85 2.83 12.2 12.05c.2.2.51.2.7 0l1.05-1.02L36.55 26.8l2.85-2.82a8.7 8.7 0 0 0 0-12.4Z"></path>
                            </svg>
                        </button>
                    </div>
                `;

                productList.appendChild(productDiv);
            });
        }
    </script>
</body>
</html>
