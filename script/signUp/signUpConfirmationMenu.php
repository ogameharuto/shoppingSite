<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録確認</title>
    <link rel="stylesheet" href="signUpMenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>登録内容確認</h2>
        <form action="signUpMain.php" method="post">
            <div class="group">
                <label for="companyName">会社名</label>
                <p><?php echo htmlspecialchars($_POST['companyName']); ?></p>
                <input type="hidden" name="companyName" value="<?php echo htmlspecialchars($_POST['companyName']); ?>">
            </div>
            <div class="group">
                <label for="postalCode">会社郵便番号</label>
                <p><?php echo htmlspecialchars($_POST['postalCode']); ?></p>
                <input type="hidden" name="postalCode" value="<?php echo htmlspecialchars($_POST['postalCode']); ?>">
            </div>
            <div class="group">
                <label for="fullAddress">住所</label>
                <p><?php echo htmlspecialchars($_POST['fullAddress']); ?></p>
                <input type="hidden" name="fullAddress" value="<?php echo htmlspecialchars($_POST['fullAddress']); ?>">
            </div>
            <div class="group">
                <label for="representativeName">会社代表者</label>
                <p><?php echo htmlspecialchars($_POST['representativeName']); ?></p>
                <input type="hidden" name="representativeName" value="<?php echo htmlspecialchars($_POST['representativeName']); ?>">
            </div>
            <div class="group">
                <label for="storeName">店舗名</label>
                <p><?php echo htmlspecialchars($_POST['storeName']); ?></p>
                <input type="hidden" name="storeName" value="<?php echo htmlspecialchars($_POST['storeName']); ?>">
            </div>
            <div class="group">
                <label for="storeNameFurigana">店舗名(フリガナ)</label>
                <p><?php echo htmlspecialchars($_POST['storeNameFurigana']); ?></p>
                <input type="hidden" name="storeNameFurigana" value="<?php echo htmlspecialchars($_POST['storeNameFurigana']); ?>">
            </div>
            <div class="group">
                <label for="phoneNumber">電話番号</label>
                <p><?php echo htmlspecialchars($_POST['phoneNumber']); ?></p>
                <input type="hidden" name="phoneNumber" value="<?php echo htmlspecialchars($_POST['phoneNumber']); ?>">
            </div>
            <div class="group">
                <label for="mailAddres">メールアドレス</label>
                <p><?php echo htmlspecialchars($_POST['mailAddres']); ?></p>
                <input type="hidden" name="mailAddres" value="<?php echo htmlspecialchars($_POST['mailAddres']); ?>">
            </div>
            <div class="group">
                <label for="storeIntroduction">店舗紹介文</label>
                <p><?php echo htmlspecialchars($_POST['storeIntroduction']); ?></p>
                <input type="hidden" name="storeIntroduction" value="<?php echo htmlspecialchars($_POST['storeIntroduction']); ?>">
            </div>
            <div class="group">
                <label for="storeImageURl">店舗画像URL</label>
                <p><?php echo htmlspecialchars($_POST['storeImageURL']); ?></p>
                <input type="hidden" name="storeImageURL" value="<?php echo htmlspecialchars($_POST['storeImageURL']); ?>">
            </div>
            <div class="group">
                <label for="storeAdditionalInfo">店舗情報補足</label>
                <p><?php echo htmlspecialchars($_POST['storeAdditionalInfo']); ?></p>
                <input type="hidden" name="storeAdditionalInfo" value="<?php echo htmlspecialchars($_POST['storeAdditionalInfo']); ?>">
            </div>
            <div class="group">
                <label for="operationsManager">運営責任者</label>
                <p><?php echo htmlspecialchars($_POST['operationsManager']); ?></p>
                <input type="hidden" name="operationsManager" value="<?php echo htmlspecialchars($_POST['operationsManager']); ?>">
            </div>
            <div class="group">
                <label for="contactAddress">お問い合わせ先住所</label>
                <p><?php echo htmlspecialchars($_POST['contactAddress']); ?></p>
                <input type="hidden" name="contactAddress" value="<?php echo htmlspecialchars($_POST['contactAddress']); ?>">
            </div>
            <div class="group">
                <label for="contactPostalCode">お問い合わせ先郵便番号</label>
                <p><?php echo htmlspecialchars($_POST['contactPostalCode']); ?></p>
                <input type="hidden" name="contactPostalCode" value="<?php echo htmlspecialchars($_POST['contactPostalCode']); ?>">
            </div>
            <div class="group">
                <label for="contactPhoneNumber">お問い合わせ先電話番号</label>
                <p><?php echo htmlspecialchars($_POST['contactPhoneNumber']); ?></p>
                <input type="hidden" name="contactPhoneNumber" value="<?php echo htmlspecialchars($_POST['contactPhoneNumber']); ?>">
            </div>
            <div class="group">
                <label for="contactEmailAddress">お問い合わせ先メールアドレス</label>
                <p><?php echo htmlspecialchars($_POST['contactEmailAddress']); ?></p>
                <input type="hidden" name="contactEmailAddress" value="<?php echo htmlspecialchars($_POST['contactEmailAddress']); ?>">
            </div>
            <div class="group">
                <label for="pass">パスワード</label>
                <p><?php echo htmlspecialchars($_POST['pass']); ?></p>
                <input type="hidden" name="pass" value="<?php echo htmlspecialchars($_POST['pass']); ?>">
            </div>
            <button type="submit">登録を確定する</button>
        </form>
        <form action="signUpMenu.php" method="post">
            <?php
            foreach ($_POST as $key => $value) {
                echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
            }
            ?>
            <button type="submit">修正する</button>
        </form>
</body>
</html>
