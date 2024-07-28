<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="newLog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>社情報登録</h2>
        <form action="com.php" method="post">
            <div class="group">
                <label for="companyName">会社名<span class="required">必須</span></label>
                <input type="text" id="companyName" name="companyName" required>
            </div>
            <div class="group">
                <label for="postalCode">会社郵便番号<span class="required">必須</span></label>
                <input type="text" id="postalCode" name="postalCode" required>
            </div>
            <div class="group">
                <label for="fullAddress">住所<span class="required">必須</span></label>
                <input type="text" id="fullAddress" name="fullAddress" required>
            </div>
            <div class="group">
                <label for="representativeName">会社代表者<span class="required">必須</span></label>
                <input type="text" id="representativeName" name="representativeName" required>
            </div>
            <div class="group">
                <label for="storeName">店舗名<span class="required">必須</span></label>
                <input type="text" id="storeName" name="storeName">
            </div>
            <div class="group">
                <label for="storeNameFurigana">店舗名(フリガナ)<span class="required">必須</span></label>
                <input type="text" id="storeNameFurigana" name="storeNameFurigana">
            </div>
            <div class="group">
                <label for="phoneNumber">電話番号<span class="required">必須</span></label>
                <input type="text" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="group">
                <label for="mailAddres">メールアドレス<span class="required">必須</span></label>
                <input type="email" id="mailAddres" name="mailAddres">
            </div>
            <div class="group">
                <label for="establishmentDate">開店年月<span class="required">必須</span></label>
                <div class="dateContainer">
                    <div class="dateItem">
                        <label for="establishmentYear">年</label>
                        <select id="establishmentYear" name="establishmentYear" required>
                            <option value="" selected="selected">年を選択してください</option>
                            <?php
                            $currentYear = date("Y");
                            for ($year = $currentYear; $year >= 1900; $year--) {
                                echo "<option value=\"$year\">$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="dateItem">
                        <label for="establishmentMonth">月</label>
                        <select id="establishmentMonth" name="establishmentMonth" required>
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
            <div class="group">
                <label for="storeIntroduction">店舗紹介文<span class="optional">任意</span></label>
                <input type="text" id="storeIntroduction" name="storeIntroduction" optional>
            </div>
            <div class="group">
                <label for="storeImageURl">店舗画像URL<span class="required">必須</spam></label>
                <input type="text" id="storeImageURL" name="storeImageURL" required>
            </div>
            <div class="group">
                <label for="storeAdditionalInfo">店舗情報補足<span class="optional">任意</spam></label>
                <input type="text" id="storeAdditionalInfo" name="storeAdditionalInfo" optional>
            </div>
            <div class="group">
                <label for="operationsManager">運営責任者<span class="optional">任意</spam></label>
                <input type="text" id="operationsManager" name="operationsManager" optional>
            </div>
            <div class="group">
                <label for="contactAddress">お問い合わせ先住所<span class="required">必須</spam></label>
                <input type="text" id="contactAddress" name="contactAddress" required>
            </div>
            <div class="group">
                <label for="contactPostalCode">お問い合わせ先郵便番号<span class="required">必須</spam></label>
                <input type="text" id="contactPostalCode" name="contactPostalCode" required>
            </div>
            <div class="group">
                <label for="contactPhoneNumber">お問い合わせ先電話番号<span class="required">必須</spam></label>
                <input type="text" id="contactPhoneNumber" name="contactPhoneNumber" required>
            </div>
            <div class="group">
                <label for="contactEmailAddress">お問い合わせ先メールアドレス<span class="required">必須</spam></label>
                <input type="text" id="contactEmailAddress" name="contactEmailAddress" required>
            </div>
            <div class="group passwordGroup">
                <label for="pass">パスワード<span class="required">必須</span></label>
                <div class="passwordContainer">
                    <input type="password" id="pass" name="pass" required>
                    <span class="togglePassword" onclick="togglePasswordVisibility()">
                        <i class="far fa-eye"></i>
                    </span>
                </div>
            </div>
            <button type="submit">登録する</button>
        </form>
        <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('pass');
            const toggleIcon = document.querySelector('.togglePassword i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        </script>
    </div>
    <script src="addressAutoFill.js"></script>
</body>
</html>

