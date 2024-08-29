<?php
// セッションを開始
session_start();

// セッションからカート情報を取得
$cartList = $_SESSION['cartList'] ?? [];
$couponNumber = $_SESSION['couponNumber'] ?? 0;
$images = isset($_SESSION['images']) ? $_SESSION['images'] : [];
$userName = $_SESSION['customer'] ?? null;

unset($_SESSION['couponNumber']);
$totalPrice = 0;

$groupedCartList = [];

foreach ($cartList as $item) {
    $storeName = $item['storeName'];
    if (!isset($groupedCartList[$storeName])) {
        $groupedCartList[$storeName] = [];
    }
    $groupedCartList[$storeName][] = $item;
    
}
// 商品がカートにあるか確認
$hasItems = count($cartList) > 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="cartList.css" />
    <link rel="stylesheet" type="text/css" href="../header.css" />
    <title>カート一覧</title>
</head>
<body>
    <div class="whole">
        <div class="top-bar topheader">
            <div class="logo">
                <a href="http://localhost/shopp/script/clientToppage.php">
                    <img src="http://localhost/shopp/taoka/Yahoo_Syopping_Logo.png" alt="Yahoo! JAPAN" onclick="location.reload()">
                </a>
            </div>
            <div class="user-info">
                <p>ようこそ、<?php echo htmlspecialchars($userName['customerName'] ?? 'ゲスト', ENT_QUOTES, 'UTF-8'); ?> さん <a href="https://www.google.com/">LYPプレミアム会員登録</a> (合計3,000円相当プレゼント！最大3ヶ月無料でお試し)</p>
            </div>
            <div class="top-links">
                <a href="https://www.google.com/">Yahoo! JAPAN 無料でお店を開こう！</a>
                <a href="USup01.php?userId=<?php echo urlencode($userId); ?>">ヘルプ</a>
            </div>
        </div>
        <div class="advertisement">
            お得情報表示
        </div>
        <?php if ($hasItems): ?>
        <div class="cartListText">
            <h1 class="topTitle">ショッピングカート一覧</h1>
        </div>
        <?php foreach ($groupedCartList as $storeName => $items): ?>
        <div class="storName">
        <span class="productaa"><?= htmlspecialchars($storeName, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <div class="Delivery"></div>
        
            <div class="shipping">
                1週間以内に発送
            </div>
            <div class="aa">
            <table class="product">
                <thead>
                    <tr>
                        <th class="pro">商品名</th>
                        <th class="pri">価格</th>
                        <th class="amo">数量</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $storeTotal = 0;
                    foreach ($items as $item): 
                        $itemSubtotal = $item['price'] * $item['quantity'];
                        $storeTotal += $itemSubtotal;
                    ?>
                        <tr class="productList">
                            <td class="productName">
                            <div class="productImage">
                                <div class="image">
                                    <?php if (isset($images[$item['productNumber']])): ?>
                                        <?php foreach ($images[$item['productNumber']] as $image): ?>
                                            <a href="http://localhost/shopp/script/productDetails/productDetailsMain.php?productNumber=<?= htmlspecialchars($item['productNumber'], ENT_QUOTES, 'UTF-8') ?>">
                                                <img src="../uploads/<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>" width="120" height="120">
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>画像がありません。</p>
                                    <?php endif; ?>
                                </div>
                                <div class="productDetail">
                                    <a href="http://localhost/shopp/script/productDetails/productDetailsMain.php?productNumber=<?= urlencode($item['productNumber']) ?>" class="proDetail">
                                        <span class="productaa"><?= htmlspecialchars($item['productDescription'], ENT_QUOTES, 'UTF-8') ?></span>
                                    </a>
                                </div>
                            </div>
                            </td>
                            <td class="price">
                                <p class="priceNumber"><?= number_format(htmlspecialchars($item['price'], ENT_QUOTES, 'UTF-8')) ?>円</p>
                            </td>
                            <td class="amount">
                                <form id="updateForm-<?= htmlspecialchars($item['productNumber']) ?>" method="POST" action="updateCart.php" style="display:inline;">
                                    <input type="hidden" name="productNumber" value="<?= htmlspecialchars($item['productNumber']) ?>">
                                    <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" class="quantityInput" min="1" oninput="toggleUpdateButton('<?= htmlspecialchars($item['productNumber']) ?>')">
                                    <button type="submit" name="action" value="update" class="updateBtn" style="display:none;">再計算</button>
                                </form>
                                <form method="GET" action="deleteFromCart.php" style="display:inline;" onclick="confirmDeletion(event)">
                                    <input type="hidden" name="productNumber" value="<?= urlencode($item['productNumber']) ?>">
                                    <button type="submit" name="action" value="delete" class="deleteBtn">削除</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php 
            $_SESSION['totalPrice'] = $storeTotal;
            ?>
        <div class="order_pleaseNoteGroup">
            <div class="orderConfirm">
                <div class="promotion"></div>
                <div class="amoment">
                    <div class="totalAmount">
                        合計金額 <?php echo number_format(htmlspecialchars($storeTotal)); ?>円
                    </div>
                </div>
                <form class="order" action="../../taoka/order1.php" method="post">
                    <input type="submit" class="orderBtn" value="ご注文手続きへ">
                    <input type="hidden" name="totalPrice" value="<?= htmlspecialchars($storeTotal, ENT_QUOTES, 'UTF-8') ?>">
                    <!-- 商品情報を含める -->
                    <?php foreach ($groupedCartList as $storeName => $items): ?>
                        <?php foreach ($items as $item): ?>
                            <input type="hidden" name="products[]" value="<?= htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8') ?>">
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </form>
            </div>
            <div class="pleaseNote">
                <p>ご注意 表示よりも実際の付与数・付与率が少ない場合があります（付与上限、未確定の付与等）</p>
                <details class="detailView">
                    <summary>詳細を見る</summary>
                    <li class="note">
                        「PayPayステップ」は、付与率の基準となる他のお取引についてキャンセル等をされたことで、付与条件が未達成となる場合があります。また、PayPay残高とPayPayポイントを併用してお支払いされた場合、付与ポイントがそれぞれ計算されます。
                        これらの場合、表示された付与数・付与率では付与されない場合があります。計算方法の詳細についてはPayPayステップ、Yahoo!ショッピングでのPayPayステップの扱いについてはヘルプページでご確認ください。
                    </li>
                    <li class="note">
                        LINEヤフー株式会社またはPayPay株式会社が、不正行為のおそれがあると判断した場合（複数のYahoo! JAPAN IDによるお一人様によるご注文と判断した場合を含みますがこれに限られません）には、表示された付与数・付与率では付与されない場合があります。
                    </li>
                    <li class="note">
                        各特典に設定された「付与上限」を考慮した数字を表示できないケースがございます。その場合、実際の付与数・付与率は表示よりも低くなります。
                        各特典の付与上限は、各特典の詳細ページをご確認ください。
                        なお「VIP特典」は、他の特典付与と合算し注文金額の56.5％を超えた場合、超過分は付与されません。詳細はVIPスタンプ説明ページをご確認ください。
                    </li>
                    <li class="note">
                        付与数は算定過程で切り捨て計算されている場合があります。付与数と付与率に齟齬がある場合、付与数の方が正確な数字になります。
                    </li>
                </details>
            </div>
            <p class="text">原則税抜価格が対象です。特典詳細は内訳でご確認ください。</p>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="cartNone">
                カートに商品が入っていません
                <p class="syopping">
                <a href="http://localhost/shopp/script/clientToppage.php" class="Button ButtonFilled shopping"><span>買い物を続ける</span></a>
                </p>
            </div>
        <?php endif; ?>
    </div>
    <script>
function toggleUpdateButton(productNumber) {
    var input = document.querySelector(`#updateForm-${productNumber} .quantityInput`);
    var button = document.querySelector(`#updateForm-${productNumber} .updateBtn`);
    if (input.value > 0) {
        button.style.display = 'inline-block';
    } else {
        button.style.display = 'none'; 
    }
}
function confirmDeletion(event) {
    if (!confirm('このアイテムを削除してもよろしいですか？')) {
        event.preventDefault();
    }
}
</script>
</body>
</html>