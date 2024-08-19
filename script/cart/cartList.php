<?php
// セッションを開始
session_start();

// セッションからカート情報を取得
$cartList = $_SESSION['cartList'] ?? [];
$couponNumber = $_SESSION['couponNumber'] ?? 0;
$images = isset($_SESSION['images']) ? $_SESSION['images'] : [];

unset($_SESSION['cartList']);
unset($_SESSION['couponNumber']);
$price = 0;
// 商品がカートにあるか確認
$hasItems = count($cartList) > 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="cartList.css" />
    <title>カート一覧</title>
</head>
<body>
    <div class="whole">
        <div class="advertisement">
            お得情報表示
        </div>
        <div class="cartListText">
            <h1 class="topTitle">ショッピングカート一覧</h1>
        </div>
        <div class="storName"></div>
        <div class="Delivery"></div>
        
        <?php if ($hasItems): ?>
            <div class="shipping">
                3日以内に発送（メーカー在庫）
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
                        <?php foreach ($cartList as $item): ?>
                            <tr class="productList">
                                <td class="productName">
                                    <div class="productImage">
                                    <div class="image">
                                            <?php
                                            // Debugging: Print the $images array
                                            if (isset($images[$item['productNumber']])) {
                                                foreach ($images[$item['productNumber']] as $image): ?>
                                                    <a href="<?= htmlspecialchars($item['productName'], ENT_QUOTES, 'UTF-8') ?>" class="proImage">
                                                        <img src="../imageIns/uploads/<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($image['imageName'], ENT_QUOTES, 'UTF-8') ?>" width="120" height="120">
                                                    </a>
                                                <?php endforeach;
                                            } else { ?>
                                                <p>画像がありません。</p>
                                            <?php }
                                            ?>
                                        </div>
                                        <div class="productDetail">
                                            <a href="http://localhost/shopp/script/productDetails/productDetails.php?productNumber=<?= urlencode($item['productNumber']) ?>" class="proDetail">
                                                <span class="productaa"><?= htmlspecialchars($item['productDescription'], ENT_QUOTES, 'UTF-8') ?></span>
                                            </a>
                                        </div>
                                </td>
                                <td class="price">
                                    <p class="priceNumber"><?php echo htmlspecialchars($item['price']); ?>円</p>
                                </td>
                                <td class="amount">
                                    <!-- 数量を入力できるフォーム -->
                                    <form id="updateForm-<?php echo htmlspecialchars($item['productNumber']); ?>" method="POST" action="updateCart.php" style="display:inline;">
                                        <input type="hidden" name="productNumber" value="<?php echo htmlspecialchars($item['productNumber']); ?>">
                                        <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" class="quantityInput" min="1" oninput="toggleUpdateButton('<?php echo htmlspecialchars($item['productNumber']); ?>')">
                                        <button type="submit" name="action" value="update" class="updateBtn" style="display:none;">再計算</button>
                                    </form>
                                    <!-- 削除フォーム -->
                                    <form method="GET" action="deleteFromCart.php" style="display:inline;" onclick="confirmDeletion(event)">
                                        <input type="hidden" name="productNumber" value="<?php echo urlencode($item['productNumber']); ?>">
                                        <button type="submit" name="action" value="delete" class="deleteBtn">削除</button>
                                    </form>
                                </td>
                            </tr>
                            <?php 
                            $price += $item['price'] * $item['quantity']; 
                            $_SESSION['totalPrice'] = $price;
                            ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if ($couponNumber): ?>
                    <div class="couponList">
                        <div class="couponReflection">
                            <p>以下のクーポンを適用します</p>
                            <button type="button" class="couponBtn">
                                <span>クーポンを変更する</span>
                            </button>
                        </div>
                        <div class="coupoList">
                            <div class="slick-track" style="width: 956px; opacity: 1; transform: translate3d(0px, 0px, 0px);">
                                <a href="クーポンの詳細URL" target="_blank" rel="noopener" data-cl-params="_cl_vmodule:coupon;_cl_link:cp;_cl_position:1;" class="couponItem" data-cl_cl_index="10">
                                    <span class="couponDetail">
                                        <span class="couponTitle">タイトル</span>
                                        <p><span class="deadline">期間</span></p>
                                        <p><span class="explanation">説明</span></p>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="couponList">
                        <div class="couponReflection">
                            <p>以下のクーポンを適用します</p>
                            <button type="button" class="couponBtn">
                                <span>クーポンを変更する</span>
                            </button>
                        </div>
                        <div class="coupoNone">
                            <p>適用されているクーポンはありません</p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="order_pleaseNoteGroup">
                    <div class="orderConfirm">
                        <div class="promotion"></div>
                        <div class="amoment">
                            <div class="totalAmount">
                                合計金額 <?php echo htmlspecialchars($price); ?>円
                            </div>
                        </div>
                        <form class="order" action="../../taoka/order1.php" method="post">
                            <input type="submit" class="orderBtn" value="ご注文手続きへ">
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
        <?php else: ?>
            <div class="cartNone">
                カートに商品が入っていません
                <p class="syopping">
                <a href="http://localhost/shopp/script/clientToppage.php" class="Button ButtonFilled shopping"><span>買い物を続ける</span></a>
                </p>
            </div>
            <div class="topick">
                <div class="topic">
                    Yahoo!ショッピングからのおすすめ商品
                    <div class="topicList">
                        おすすめ商品表示
                    </div>
                    <div class="topicLook">
                        おすすめ商品をもっと見る
                    </div>
                </div>
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
        event.preventDefault(); // 削除をキャンセル
    }
}
</script>

</body>
</html>
