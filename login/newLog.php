<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社情報登録 - ストアクリエイターPro</title>
    <link rel="stylesheet" href="newLog.css">
</head>
<body>
    <div class="container">
        <h2>社情報登録</h2>
        <form action="com.php" method="post">
            <div class="form-group">
                <label for="company_name">会社名<span class="required">必須</span></label>
                <input type="text" id="company_name" name="company_name" placeholder="例）矢風商事" required>
            </div>
            <div class="form-group">
                <label for="postal_code">会社郵便番号<span class="required">必須</span></label>
                <input type="text" id="postal_code" name="postal_code" placeholder="例）102-8282" required>
            </div>
            <div class="form-group">
                <label for="prefecture">都道府県<span class="required">必須</span></label>
                <input type="text" id="prefecture" name="prefecture" placeholder="例）東京都">
            </div>
            <div class="form-group">
                <label for="city">市区町村<span class="required">必須</span></label>
                <input type="text" id="city" name="city" placeholder="例）千代田区" required>
            </div>
            <div class="form-group">
                <label for="town">町・字名<span class="required">必須</span></label>
                <input type="text" id="town" name="town" placeholder="例）紀尾井町" required>
            </div>
            <div class="form-group">
                <label for="street_address">丁目・番地・号<span class="required">必須</span></label>
                <input type="text" id="street_address" name="street_address" placeholder="例）1-3" required>
            </div>
            <div class="form-group">
                <label for="representativeName">会社代表者<span class="required">必須</span></label>
                <input type="text" id="representativeName" name="representativeName" placeholder="例）太郎" required>
            </div>
            <div class="form-group">
                <label for="storeName">店舗名<span class="required">必須</span></label>
                <input type="text" id="storeName" name="storeName" placeholder="例">
            </div>
            <div class="form-group">
                <label for="storeNameFurigana">店舗名(フリガナ)<span class="required">必須</span></label>
                <input type="text" id="storeNameFurigana" name="storeNameFurigana" placeholder="例">
            </div>
            <div class="form-group">
                <label for="phone_number">電話番号<span class="required">必須</span></label>
                <input type="text" id="phone_number" name="phone_number" placeholder="例）03-1234-5678" required>
            </div>
            <div class="form-group">
                <label for="mailAddres">メールアドレス<span class="required">必須</span></label>
                <input type="email" id="mailAddres" name="mailAddres" placeholder="例）aaaaa@gmail.com">
            </div>
            <div class="form-group">
                <label for="establishment_date">開店年月<span class="required">必須</span></label>
                <div class="date-container">
                    <div class="date-item">
                        <label for="establishment_year">年</label>
                        <select id="establishment_year" name="establishment_year" required>
                            <option value="" selected="selected">年を選択してください</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = $currentYear; $year >= 1900; $year--) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="date-item">
                        <label for="establishment_month">月</label>
                        <select id="establishment_month" name="establishment_month" required>
                            <option value="" selected="selected">月を選択してください</option>
                            <?php
                            for ($month = 1; $month <= 12; $month++) {
                                $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
                                echo "<option value=\"$monthFormatted\">$monthFormatted</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="storeIntroduction">店舗紹介文<span class="optional">任意</span></label>
                <input type="text" id="storeIntroduction" class="storeIntroduction"></input>
            </div>
            <div class="form-group">
                <label for="storeImageURl"><span class="required"></label>
            </div>
            <button type="submit">登録する</button>
        </form>
    </div>
    <script src="addressAutoFill.js"></script>
</body>
</html>

