<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="productManeger.css">
</head>

<body>
    <?php include "header.php" ?>
    <main>
        <!-- コンテンツ -->
    </main>
    <div class="flex">
        <div class="leftWidht">
            <div class="productSearch">
                <form id="searchForm" name="商品管理" method="post">
                    <h3>商品検索</h3>
                    <div class="flex">
                        <label>
                            <p>検索対象</p>
                        </label>
                        <select name="searchTarget">
                            <option value="商品コード">商品コード</option>
                            <option value="商品名">商品名</option>
                        </select>
                    </div>
                    <div class="flex">
                        <label>
                            <p>検索文字</p>
                        </label>
                        <input type="text" name="searchText">
                    </div>
                    <div class="flex">
                        <label>
                            <p>公開状態</p>
                        </label>
                        <select name="公開状態">
                            <option value="公開中">公開中</option>
                            <option value="非公開">非公開</option>
                        </select>
                    </div>
                    <input type="button" id="searchButton" value="検索">
                </form>
            </div>
            <div id="categories" class="sitemap">
                <ul>
                    <li data-path="Home">Home
                        <ul>
                            <li data-path="Home/Electronics">Electronics
                                <ul>
                                    <li data-path="Home/Electronics/Phones">Phones</li>
                                    <li data-path="Home/Electronics/Computers">Computers</li>
                                </ul>
                            </li>
                            <li data-path="Home/Fashion">Fashion
                                <ul>
                                    <li data-path="Home/Fashion/Men">Men</li>
                                    <li data-path="Home/Fashion/Women">Women</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="productList">
            <h3>商品一覧</h3>
            <div id="products"></div>
            <div id="breadcrumb"></div>
        </div>
    </div>
    <script src="product.js"></script>
</body>

</html>