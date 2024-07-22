<?php
$couponNumber = 0;
 ?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="productDetails.css" />
        <title>商品詳細</title>
    </head>
    <body>
        <div class="main">
            <div class="header"></div>
            <div class="productList">
                <div class="product">
                    <div class="image">
                    <a href="<?php echo $product[$index]['url']; ?>" class="proImage">
                        <img src="https://item-shopping.c.yimg.jp/i/j/tanomail_9628030_i_20240321100443" 
                        alt="画像の説明" width="120" height="120" class="style_BasketItems__itemImage__N7etN">
                    </a>
                    </div>
                    <div class="detail">
                        <a href="" class="">爽健美茶</a>
                        <p class="text">コカ・コーラ　やかんの麦茶　ｆｒｏｍ　爽健美茶　６５０ｍｌ　ペットボトル　１セット（４８本：２４本×２ケース）</p>
                        <p class="priceList">
                            <span class="price">4717円</span>
                            <span class="postage">＋〇〇円</span>
                        </p>
                        <?php switch($couponNumber){
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
                    </div>
                </div>
                <div class="price">
                    aaaaaaa
                </div>
            </div>
            <div class="others"></div>
        </div>
    </body>
</html>