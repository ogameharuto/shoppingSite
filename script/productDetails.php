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
                        <div class="mdItemName">
                           <p class="elCatchCopy" style="display: none;">やかんの麦茶</p>
                           <p class="elName">やかんの麦茶 FROM 爽健美茶ラベルレス PET ( 650ml*48本セット )/ やかんの麦茶 ( お茶 )</p>
                        </div>
                        <div class="mdRankingBadge" id="itmrnk" style="display: none;">
                           <p class="elText">
                              <span class="elRanking" id="shp_ranking_summary_rank"></span>
                              <a class="elLink" id="shp_ranking_summary_category" href="" data-sci-param="shp_pc_store-item_itmrnk"></a>
                           </p>
                        </div>
                        <div class="mdReviewSummary" id="itmrvw">
                           <div class="elContents">
                              <p class="elReview">
                                 <a class="elReviewLink" href="#anchor-reviewData" data-libAnchor data-ylk="slk:rvwlok;pos:0;" data-hash-anhor="anchor-reviewData">
                                 <span class="elReviewStar elRate50">
                                 <span class="elStar1"></span>
                                 <span class="elStar2"></span>
                                 <span class="elStar3"></span>
                                 <span class="elStar4"></span>
                                 <span class="elStar5"></span>
                                 </span>
                                 <span class="elReviewValue">4.83</span>
                                 <span class="elReviewCount">（64件）</span>
                                 </a>
                              </p>
                           </div>
                        </div>
                        <div class="mdItemPrice" id="prcdsp" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                           <p class="elPriceName">通常価格（税込）</p>
                           <div class="elPriceArea">
                              <div class="elItemPriceInner">
                                 <p><span class="elPriceNumber"  itemprop="price">4,752</span><span class="elPriceUnit">円</span></p>
                              </div>
                              <p class="elPostageFree">送料無料<span class="elPostagePref">（東京都）</span></p>
                           </div>
                           <div class="elPostageArea">
                              <p class="elPostageNotice">条件により送料が異なる場合があります。</p>
                           </div>
                        </div>
                        <div class="mdItemCoupon" style="display:none" id="coup_ex"></div>
                        <div class="mdDeliveryInformation" id="delinfo">
                           <div class="elContents">
                              <p class="elDeliveryScheduleInfo">
                                 <span class="elDeliveryScheduleText">通常1-2日で発送予定（〜8/2までに発送）</span>
                              </p>
                              <p class="elOptionInfo">
                                 <span class="elSelectableDeliveryText">お届け日指定可</span>
                              </p>
                           </div>
                        </div>
                        <div class="mdMultipleVariations" data-multipleVariations id="ctlg_vri">
                        </div>
                        <!-- ItemComment -->
                        <div class="mdItemComment" data-itemComment>
                           <div class="elHeaderTitle">ストアコメント</div>
                           <div class="elContentWrapper" data-itemComment-parts="base">
                              <!-- freeSpace -->
                              <div class="mdFreeSpace isLoading">
                                 <div class="elContent">
                                    <script type="text/template" data-templateIframe>
                                       やかんの麦茶 FROM 爽健美茶ラベルレス PET/ラベルを剥がすプチストレスがないラベルレスボトル        
                                    </script>
                                 </div>
                              </div>
                              <!-- /freeSpace -->
                              <p class="elExpandMore">
                                 <button type="button" class="elMoreButton" data-itemComment-parts="button">
                                 <span class="elMoreButtonText">もっと見る</span>
                                 </button>
                              </p>
                           </div>
                        </div>
                     </div>
                     <!-- /gd3ColumnItemA2 -->
                  </div>
                  <div class="price">
                     <!-- cartSummary -->
                     <div class="uiCartSummary" data-libSticky data-libSticky-id="cartSummary">
                        <div class="mdCartSummary" id="upcart" data-cartSummary itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                           <form class="elItemInfo" name="addCart" action="https://order.shopping.yahoo.co.jp/cgi-bin/cart-form?crumb=Ar5komYA6P2EG_H5ZPPefSi4yyrXxUwgEKd85IJA7xU1WVIpy7WkfRyr5IMmOnvfn9Yd7bDwe8Bky3MjmQhM85PftTRYHlpzsSrHe9JCIft-In-YIf5Wa364mQ49uMKQJFYZFykR" method="post" onsubmit="return false;" data-cartSummary-parts="summaryInner">
                              <input name="seller_managed_item_id" type="hidden" value="533474">
                              <input name="seller_id" type="hidden" value="soukaidrink">
                              <input name="add_item_options" value="" type="hidden">
                              <input name="is_social_gift" value="1" type="hidden" disabled>        
                              <div class="elPriceArea">
                                 <div class="elPriceWrap">
                                    <p class="elPriceTitle">通常価格（税込）</p>
                                    <p class="elPriceData">
                                       <span class="elPrice" itemprop="price">4,752<span class="elUnit">円</span></span>
                                    </p>
                                 </div>
                                 <p class="elPostageWrap isFree">
                                    <span class="elPostage">送料無料</span>
                                    <span class="elPref">（東京都）</span>
                                 </p>
                              </div>
                              <div class="elItemOptionsArea">
                                 <div class="elItemOptionsAreaInner" data-cartsummary-parts="scrollWrapper">
                                    <dl class="elScrollItem" data-cartsummary-parts="scrollItem">
                                       <dt class="elItemOptionsTitle">
                                          <p class="elTitle">確認事項</p>
                                          <a href="javascript:void(0);" class="elChange" data-cartdialog-show="confirmations" data-ylk="slk:optchg;pos:0;">変更</a>            
                                       </dt>
                                       <dd class="elItemOptionsDetails">
                                          <dl class="elItemOptionsDetail">
                                             <dt class="elName">発送可能時期</dt>
                                             <dd class="elChoice"><a href="javascript:void(0);" class="elDialogLink" data-cartdialog-show="confirmations" data-sync-cart-option="発送可能時期">通常1-2日で発送予定</a></dd>
                                          </dl>
                                       </dd>
                                    </dl>
                                 </div>
                                 <div class="elShadow" data-cartsummary-parts="scrollShadow"></div>
                              </div>
                              <div class="elQuantityArea" data-quantity data-quantity-id="cartSummary" data-quantity-parameter="minValue:1,maxValue:100">
                                 <div class="elSelectQuantity">
                                    <p class="elQuantityTitle">数量</p>
                                    <div class="elInputWrap">
                                       <input type="text" name="quantity" class="elQuantityInput" value="1" pattern="^[0-9０-９]+$" data-quantity-parts="input" maxlength="3">
                                    </div>
                                 </div>
                                 <ul class="elQuantityConditions">
                                    <li class="elQuantityCondition">お一人さま、100点限り</li>
                                 </ul>
                              </div>
                              <div class="elActionsArea">
                                 <div class="elAction">
                                    <button
                                       class="elAddCart"
                                       data-addCart="normal"             data-cartDialog-show             data-ylk="slk:addcart;pos:0;"            data-sci-param="shp_pc_store-item_upcart">
                                    カートに入れる        </button>
                                    <div class="elFavorite">
                                       <a aria-label="お気に入り追加"
                                          href="javascript:void(0)"
                                          class="elFavoriteButton rapid-noclick-resp"
                                          data-libdialog-show="favoriteDialog"
                                          data-storeId="soukaidrink"
                                          data-pageKey="533474"
                                          data-libDialog-show="favoriteDialog"
                                          data-favoriteButton
                                          data-moduleType="cartSummaryFavorite"
                                          data-ylk="sec:upcart;slk:addfav;pos:0"></a>
                                    </div>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <!-- /cartSummary -->
                  </div>
            </div>
            <div class="others"></div>
        </div>
    </body>
</html>