<?php
$products[] = [
    [
        'name' => '【卒業記念品】時計 卒業 記念品 お祝い 名入れ 無料 卒団 卒部 部活 卒業式 卒園式 置き時計 木製 名前入れ メッセージ みんながつがる記念品kizuna',
        'price' => 4000,
        'shipping' => '送料〇〇円',
        'image' => 'https://item-shopping.c.yimg.jp/i/j/kinokurashi-gift_200-3?resolution=2x',
        'url' => '商品詳細URL',
        'store' => '店舗名',
        'store_url' => '店舗名URL'
    ],
];
$products[] = [
    [
        'name' => '【卒業記念品】時計 卒業 記念品 お祝い 名入れ 無料 卒団 卒部 部活 卒業式 卒園式 置き時計 木製 名前入れ メッセージ みんながつがる記念品kizuna',
        'price' => 4000,
        'shipping' => '送料〇〇円',
        'image' => 'https://item-shopping.c.yimg.jp/i/j/kinokurashi-gift_200-3?resolution=2x',
        'url' => '商品詳細URL',
        'store' => '店舗名',
        'store_url' => '店舗名URL'
    ],
];
$searchNumber;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="productSearchList.css" />
    <title>商品検索一覧</title>
</head>
<body>
    <div class="header">
        <div class="CenteredContainer">
            <div class="whole"><?php require_once("header.php"); ?></div>
            <div class="searchResults">
                <h1 class="searchText">時計</h1>
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
                            <p class="searchNumber"><?php echo count($products);; ?></p>
                            <div class="select">
                                <div class="recommendedOrder">
                                    <select id="prodctSelect">
                                        <option>おすすめ順</option>
                                        <option>価格が安い順</option>
                                        <option>価格が高い順</option>
                                        <option>価格＋送料が安い順</option>
                                        <option>価格＋送料が高い順</option>
                                        <option>レビュー件数順</option>
                                        <option>レビュー点順</option>
                                        <option>割引率の高い順</option>
                                    </select>
                                </div>
                                <div class="sortPrice">
                                    <select id="priceSelect">
                                        <option>商品価格</option>
                                        <option>今すぐ利用価格</option>
                                        <option>実質価格</option>
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
                    <div class="productList">
                        <?php $index = 0; ?>
                        <?php foreach ($products as $product): ?>
                        <div class="product">
                            <div class="width">
                                <img src="<?php echo $product[$index]['image']; ?>" class="productImage"></img>
                                <p><a href="<?php echo $product[$index]['url']; ?>" class="text"><?php echo $product[$index]['name']; ?></a></p>
                                <p>
                                    <span class="price"><?php echo $product[$index]['price']; ?>円</span>
                                    <span class="postage">＋<?php echo $product[$index]['shipping']; ?></span>
                                </p>
                                <p>
                                    <a href="<?php echo $product[$index]['store_url']; ?>" class="store">
                                        <span><?php echo $product[$index]['store']; ?></span>
                                    </a>
                                </p>
                                <button class="favoriteBtn">
                                    <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true" class="Symbol">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M39.4 11.57a8.94 8.94 0 0 0-12.55 0L24 14.4l-2.85-2.82a8.94 8.94 0 0 0-12.55 0 8.7 8.7 0 0 0 0 12.4l2.85 2.83 12.2 12.05c.2.2.51.2.7 0l1.05-1.02L36.55 26.8l2.85-2.82a8.7 8.7 0 0 0 0-12.4Z"></path>
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
    <script src="productSearchList.js"></script>
</body>
</html>
