<?php 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="order.css">
</head>
<body>
<?php include "../script/header.php" ?>
<div class="orderbody">
    <form id="orderForm" method="post" action="order2.php">
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
            <input type="text" id="firstname_kana" name="firstname_kana" placeholder="ストア" required pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
            <input type="text" id="lastname_kana" name="lastname_kana" placeholder="タロウ" required pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
        </div>
        <div class="form-group">
            <label for="postal_code">郵便番号 <nobr><span>（必須）</span></nobr></label>
            <input type="text" id="postal_code" name="postal_code" placeholder="123-4567" pattern="\d{3}-?\d{4}" required data-error-message="123-4567 の形式で入力してください">
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
            <input type="tel" id="phone" name="phone" placeholder="ハイフンなし" pattern="\d{10,11}" required data-error-message="ハイフンなしで10または11桁の数字を入力してください">
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
                <input type="text" id="billing_firstname_kana" name="hidden_firstname_kana" placeholder="ストア" pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
                <input type="text" id="billing_lastname_kana" name="hidden_lastname_kana" placeholder="タロウ" pattern="[\u30A0-\u30FF]+" data-error-message="カタカナで入力してください">
            </div>
            <div class="form-group">
                <label for="billing_postal_code">郵便番号 <nobr><span>（必須）</span></nobr></label>
                <input type="text" id="billing_postal_code" name="hidden_postal_code" placeholder="123-4567" pattern="\d{3}-?\d{4}" data-error-message="123-4567 の形式で入力してください">
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
                <input type="tel" id="billing_phone" name="hidden_phone" placeholder="ハイフンなし" pattern="\d{10,11}" data-error-message="ハイフンなしで10または11桁の数字を入力してください">
            </div>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス <nobr><span>（必須）</span></nobr></label>
            <input type="email" id="email" name="email" placeholder="〇〇〇@yahoo.co.jp" required>
        </div>

        <h2>お支払い方法の選択</h2>
        <label for="newCard" class="radiolabel">
            <input type="radio" id="newCard" name="payment" value="新規クレジットカード" checked>
            新規クレジットカード
            <div id="newCardFields" data-required="newCard">
                <h3>新規クレジットカード</h3>
                <div class="form-group">
                    <label for="cardNumber">カード番号 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="cardNumber" name="cardNumber1" placeholder="1234" pattern="\d{4}" required data-error-message="4ケタの半角数字で入力してください">
                    <input type="text" id="cardNumber" name="cardNumber2" placeholder="5678" pattern="\d{4}" required data-error-message="4ケタの半角数字で入力してください">
                    <input type="text" id="cardNumber" name="cardNumber3" placeholder="9012" pattern="\d{4}" required data-error-message="4ケタの半角数字で入力してください">
                    <input type="text" id="cardNumber" name="cardNumber4" placeholder="3456" pattern="\d{4}" required data-error-message="4ケタの半角数字で入力してください">
                </div>
                <div class="form-group">
                    <label for="expiryDate">有効期限 <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" pattern="\d{2}/\d{2}" required data-error-message="MM/YY の形式で入力してください">
                </div>
                <div class="form-group">
                    <label for="securityCode">セキュリティコード <nobr><span>（必須）</span></nobr></label>
                    <input type="text" id="securityCode" name="securityCode" placeholder="123" pattern="\d{3}" required data-error-message="3桁の数字を入力してください">
                </div>
            </div>
        </label>
        <label for="payLater" class="radiolabel">
            <input type="radio" id="payLater" name="payment" value="ゆっくりお支払い">
            ゆっくりお支払い
            <div id="payLaterFields" data-required="payLater" class="hidden">
                <h3>ゆっくりお支払い</h3>
                <!-- ゆっくりお支払い用のフィールド -->
            </div>
        </label>
        <button type="submit">確認画面へ進む</button>
    </form>
</div>
<script src="order.js"></script>
</body>
</html>