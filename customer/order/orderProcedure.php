<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="../../css/order.css">
    <script src="order.js"></script>
</head>

<body>
    <div class="orderbody">
        <form id="orderForm" method="post" action="orderConfirmation.php">
            <h1>ご注文手続き</h1>
            <hr color="#d3d3d3">
            <h2>お届け先</h2>
            <hr>
            <div class="form-group">
                <label for="firstname">お名前 <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="firstname" name="firstname" placeholder="素十阿" required>
                <input type="text" id="lastname" name="lastname" placeholder="太郎" required>
            </div>
            <div class="form-group">
                <label for="firstname_kana">お名前(カナ) <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="firstname_kana" name="firstname_kana" placeholder="ストア" required
                    pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
                <input type="text" id="lastname_kana" name="lastname_kana" placeholder="タロウ" required
                    pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
            </div>
            <div class="form-group">
                <label for="postal_code">郵便番号 <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="postal_code" name="postal_code" placeholder="123-4567" pattern="\d{3}-?\d{4}"
                    required data-error-message="123-4567 の形式で入力してください">
            </div>
            <div class="form-group">
                <label for="prefecture">都道府県 <nobr><span>（必須）</span></nobr></label>
                <select id="prefecture" name="prefecture" required>
                    <option value="" selected>都道府県を選択</option>
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                </select>
            </div>
            <div class="form-group">
                <label for="city">市区町村 <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="city" name="city" placeholder="おおお市" required>
            </div>
            <div class="form-group">
                <label for="address">町名・番地 <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="address" name="address" placeholder="六本木1-5-3" required>
            </div>
            <div class="form-group">
                <label for="building">ビル・マンション名</label>
                <input type="text" id="building" name="building" placeholder="〇〇ハケオベテ10号">
            </div>
            <div class="form-group">
                <label for="phone">電話番号 <nobr><span>（必須）</span></nobr></label>
                <input type="tel" id="phone" name="phone" placeholder="ハイフンなし" pattern="\d{10,11}" required
                    data-error-message="ハイフンなしで10または11桁の数字を入力してください">
            </div>

            <h2>ご請求先</h2>
            <hr>
            <div class="form-group">
                <label for="addressee">ご請求先 <nobr><span>（必須）</span></nobr></label>
                <select id="addressee" name="billingAddress" required>
                    <option value="お届け先と同じ" selected>お届け先と同じ</option>
                    <option value="その他住所を入力">その他住所を入力</option>
                </select>
            </div>
            <div id="billingAddress" class="hidden">
                <div class="form-group">
                    <label for="billing_firstname">お名前 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="billing_firstname" name="hidden_firstname" placeholder="素十阿">
                    <input type="text" id="billing_lastname" name="hidden_lastname" placeholder="太郎">
                </div>
                <div class="form-group">
                    <label for="billing_firstname_kana">お名前(カナ) <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="billing_firstname_kana" name="hidden_firstname_kana" placeholder="ストア"
                        pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
                    <input type="text" id="billing_lastname_kana" name="hidden_lastname_kana" placeholder="タロウ"
                        pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
                </div>
                <div class="form-group">
                    <label for="billing_postal_code">郵便番号 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="billing_postal_code" name="hidden_postal_code" placeholder="123-4567"
                        pattern="\d{3}-?\d{4}" data-error-message="123-4567 の形式で入力してください">
                </div>
                <div class="form-group">
                    <label for="billing_prefecture">都道府県 <nobr><span>（必須）</span></nobr></label>
                    <select id="billing_prefecture" name="hidden_prefecture">
                        <option value="" selected>都道府県を選択</option>
                        <option value="北海道">北海道</option>
                        <option value="青森県">青森県</option>
                        <option value="岩手県">岩手県</option>
                        <option value="宮城県">宮城県</option>
                        <option value="秋田県">秋田県</option>
                        <option value="山形県">山形県</option>
                        <option value="福島県">福島県</option>
                        <option value="茨城県">茨城県</option>
                        <option value="栃木県">栃木県</option>
                        <option value="群馬県">群馬県</option>
                        <option value="埼玉県">埼玉県</option>
                        <option value="千葉県">千葉県</option>
                        <option value="東京都">東京都</option>
                        <option value="神奈川県">神奈川県</option>
                        <option value="新潟県">新潟県</option>
                        <option value="富山県">富山県</option>
                        <option value="石川県">石川県</option>
                        <option value="福井県">福井県</option>
                        <option value="山梨県">山梨県</option>
                        <option value="長野県">長野県</option>
                        <option value="岐阜県">岐阜県</option>
                        <option value="静岡県">静岡県</option>
                        <option value="愛知県">愛知県</option>
                        <option value="三重県">三重県</option>
                        <option value="滋賀県">滋賀県</option>
                        <option value="京都府">京都府</option>
                        <option value="大阪府">大阪府</option>
                        <option value="兵庫県">兵庫県</option>
                        <option value="奈良県">奈良県</option>
                        <option value="和歌山県">和歌山県</option>
                        <option value="鳥取県">鳥取県</option>
                        <option value="島根県">島根県</option>
                        <option value="岡山県">岡山県</option>
                        <option value="広島県">広島県</option>
                        <option value="山口県">山口県</option>
                        <option value="徳島県">徳島県</option>
                        <option value="香川県">香川県</option>
                        <option value="愛媛県">愛媛県</option>
                        <option value="高知県">高知県</option>
                        <option value="福岡県">福岡県</option>
                        <option value="佐賀県">佐賀県</option>
                        <option value="長崎県">長崎県</option>
                        <option value="熊本県">熊本県</option>
                        <option value="大分県">大分県</option>
                        <option value="宮崎県">宮崎県</option>
                        <option value="鹿児島県">鹿児島県</option>
                        <option value="沖縄県">沖縄県</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="billing_city">市区町村 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="billing_city" name="hidden_city" placeholder="おおお市">
                </div>
                <div class="form-group">
                    <label for="billing_address">町名・番地 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="billing_address" name="hidden_address" placeholder="六本木1-5-3">
                </div>
                <div class="form-group">
                    <label for="billing_building">ビル・マンション名</label>
                    <input type="text" id="billing_building" name="hidden_building" placeholder="〇〇ハケオベテ10号">
                </div>
                <div class="form-group">
                    <label for="billing_phone">電話番号 <nobr><span>（必須）</span></nobr></label>
                    <input type="tel" id="billing_phone" name="hidden_phone" placeholder="ハイフンなし" pattern="\d{10,11}"
                        data-error-message="ハイフンなしで10または11桁の数字を入力してください">
                </div>
            </div>
            <div class="form-group">
                <label for="email">メールアドレス <nobr><span>（必須）</span></nobr></label>
                <input type="email" id="email" name="email" placeholder="〇〇〇@yahoo.co.jp" required>
            </div>

            <h2>お支払い方法の選択</h2>
            <hr>
            <div class="buttom">
                <label for="cashOnDelivery" class="radiolabel">
                    <input type="radio" id="cashOnDelivery" name="payment" value="代引き" checked>
                    代引き
                </label>
            </div>
            <div class="buttom">
                <label for="newCard" class="radiolabel">
                    <input type="radio" id="newCard" name="payment" value="新規クレジットカード">
                    新規クレジットカード
                    <div id="newCardFields" data-required="newCard">
                        <h3>新規クレジットカード</h3>
                        <div class="form-group">
                            <label for="cardNumber">カード番号 <nobr><span>（必須）</span></nobr></label>
                            <input type="text" id="cardNumber" name="cardNumber1" placeholder="1234" pattern="\d{4}"
                                required data-error-message="4ケタの半角数字で入力してください">
                            <input type="text" id="cardNumber" name="cardNumber2" placeholder="5678" pattern="\d{4}"
                                required data-error-message="4ケタの半角数字で入力してください">
                            <input type="text" id="cardNumber" name="cardNumber3" placeholder="9012" pattern="\d{4}"
                                required data-error-message="4ケタの半角数字で入力してください">
                            <input type="text" id="cardNumber" name="cardNumber4" placeholder="3456" pattern="\d{4}"
                                required data-error-message="4ケタの半角数字で入力してください">
                        </div>
                        <div class="form-group">
                            <label for="expiryDate">有効期限 <nobr><span>（必須）</span></nobr></label>
                            <div id="expiryDate" class="flex">
                                <select id="expiryMonth" name="expiryMonth" required>
                                    <option value="" disabled selected>月</option>
                                    <?php for ($month = 1; $month <= 12; $month++): ?>
                                        <option value="<?= str_pad($month, 2, '0', STR_PAD_LEFT) ?>">
                                            <?= str_pad($month, 2, '0', STR_PAD_LEFT) ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <select id="expiryYear" name="expiryYear" required>
                                    <option value="" disabled selected>年</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year <= $currentYear + 13; $year++):
                                        ?>
                                        <option value="<?= $year ?>"><?= $year ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="securityCode">セキュリティコード <nobr><span>（必須）</span></nobr></label>
                            <input type="text" id="securityCode" name="securityCode" placeholder="123" pattern="\d{3}"
                                required data-error-message="3桁の数字を入力してください">
                        </div>
                    </div>
                </label>
            </div>
            <h2>お届け情報</h2>
            <hr>
            <h3>お届け方法</h3>
            <label for="deliveryMethod" class="radiolabel">
                <input type="radio" id="deliveryMethod" name="deliveryMethod" value="宅配便" checked>
                宅配便
            </label>
            <h3>お届け希望日(翌日から一週間後まで)</h3>
            <?php
            // 現在の日付を取得
            $currentDate = new DateTime();
            $currentDate->modify('+1 day');

            // 1週間分の日付をラジオボタンで表示
            for ($i = 0; $i < 7; $i++) {
                // 日付をフォーマットして表示
                $dateString = $currentDate->format('Y年m月d日');
                echo '<label class="radiolabel">';
                echo '<input type="radio" name="desiredDeliveryDate" value="' . $dateString . '"';
                if ($i == 0) {
                    echo 'checked> ' . $dateString;
                } else {
                    echo '> ' . $dateString;
                }
                echo '</label>';

                // 次の日に進める
                $currentDate->modify('+1 day');
            }
            ?>
            <h3>お届け希望時刻</h3>
            <label class="radiolabel">
                <input type="radio" name="desiredDeliveryTime" value="06:00~09:00" checked>06:00~09:00
            </label>
            <label class="radiolabel">
                <input type="radio" name="desiredDeliveryTime" value="09:00~12:00">09:00~12:00
            </label>
            <label class="radiolabel">
                <input type="radio" name="desiredDeliveryTime" value="12:00~15:00">12:00~15:00
            </label>
            <label class="radiolabel">
                <input type="radio" name="desiredDeliveryTime" value="15:00~18:00">15:00~18:00
            </label>
            <label class="radiolabel">
                <input type="radio" name="desiredDeliveryTime" value="18:00~21:00">18:00~21:00
            </label>
            <button type="submit">確認画面へ進む</button>
        </form>
    </div>
</body>

</html>