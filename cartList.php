<?php
$cartList = 0;
$couponNumber = 0;
$price = 0;

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
        'name' => 'コカ・コーラ　やかんの麦茶　ｆｒｏｍ　爽健美茶　６５０ｍｌ　ペットボトル　１セット（４８本：２４本×２ケース）',
        'price' => 4717,
        'shipping' => '送料〇〇円',
        'image' => 'https://item-shopping.c.yimg.jp/i/j/tanomail_9628030_i_20240321100443',
        'url' => '商品詳細URL',
        'store' => '店舗名',
        'store_url' => '店舗名URL'
    ],
];
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
            <?php
            switch($cartList){
                case 0:
            ?>
                <a href="店に飛ぶリンク">店の名前</a>
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
                        <?php $index = 0; ?>
                        <?php foreach ($products as $product): ?>
                                <tr class="productList">
                                    <td class="productName">
                                        <div class="productImage">
                                            <div class="image">
                                                <a href="<?php echo $product[$index]['url']; ?>" class="proImage">
                                                    <img src="<?php echo $product[$index]['image']; ?>" 
                                                    alt="画像の説明" width="120" height="120" class="style_BasketItems__itemImage__N7etN">
                                                </a>
                                            </div>
                                            <div class="productDetail">
                                                <a href="<?php echo $product[$index]['url']; ?>" class="proDetail">
                                                    <span class="productaa"><?php echo $product[$index]['name']; ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="price">
                                        <p class="priceNumber"><?php echo $product[$index]['price']; ?>円</p>
                                    </td>
                                    <td class="amount">
                                        <div class="priceDelete">
                                            <input type="text" name="quantity" class="textFild"
                                            autocapitalize="off" autocorrect="off" autocomplete="off" maxlength="3">
                                            <button type="button" class="deletBtn">
                                                <span>削除</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php $price += $product[$index]['price']; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    switch($couponNumber){
                        case 1:
                    ?>
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
                    <?php
                            break;
                        case 0:
                    ?>
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
                            <?php
                            break;
                    }
                     ?>
                    <div class="order_pleaseNoteGroup">
                        <div class="orderConfirm">
                            <div class="promotion"></div>
                            <div class="amoment">
                                <div class="totalAmount">
                                    合計金額　<?php print($price); ?>円
                                </div>
                                <!--<p class="couponAmount">クーポン適用価格</p>-->
                            </div>
                            <form class="order" action="ご注文手続きの画面" methot="post">
                                <input type="submit" class="orderBtn" value="ご注文手続きへ"></input>
                            </form>
                        </div>
                        <div class="pleaseNote">
                        <p>ご注意 表示よりも実際の付与数・付与率が少ない場合があります（付与上限、未確定の付与等）</p>
                        <details class="detailView" style>
                            <summary>詳細を見る</summary>
                            <li class="note">
                                「PayPayステップ」は、付与率の基準となる他のお取引についてキャンセル等をされたことで、付与条件が未達成となる場合があります。また、PayPay残高とPayPayポイントを併用してお支払いされた場合、付与ポイントがそれぞれ計算されます。
                                これらの場合、表示された付与数・付与率では付与されない場合があります。計算方法の詳細についてはPayPayステップ、Yahoo!ショッピングでのPayPayステップの扱いについてはヘルプページでご確認ください。
                            </li>
                            <li class="note">
                            LINEヤフー株式会社またはPayPay株式会社が、不正行為のおそれがあると判断した場合（複数のYahoo! JAPAN IDによるお一人様によるご注文と判断した場合を含みますがこれに限られません）
                            には、表示された付与数・付与率では付与されない場合があります。
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
                        </dIV>
                        <p class="text">原則税抜価格が対象です。特典詳細は内訳でご確認ください。</p>
            <?php
                    break;
                case 1:
            ?>
                    <div class="cartNone">
                        カートに商品が入っていません
                        <p class="syopping">
                        <a href="トップページのURL" class="Button ButtonFilled shopping"><span>買い物を続ける</span></a>
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
            <?php
                    break;
            }
            ?>
        </div>
    </body>
</html>