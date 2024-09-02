<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="../../css/newRegistrationMenu.css">
</head>
<body>
    <h1>新規登録</h1>
    <form id="registrationForm" action="clientSignUpMain.php" method="post">
        <label for="customerName">顧客名: <span class="required">必須</span></label>
        <input type="text" id="customerName" name="customerName" placeholder="例: 山田 太郎" required><br>
        
        <label for="furigana">フリガナ: <span class="required">必須</span></label>
        <input type="text" id="furigana" name="furigana" placeholder="例: ヤマダ タロウ" required pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" title="カタカナのみを入力してください。"><br>
        
        <label for="address">住所: <span class="required">必須</span></label>
        <input type="text" id="address" name="address" placeholder="例: 東京都千代田区1-1" required><br>
        
        <label for="postCode">郵便番号: <span class="required">必須</span></label>
        <input type="text" id="postCode" name="postCode" placeholder="例: 100-0001" required pattern="\d{3}-?\d{4}" title="数字のみを入力してください。"><br>
        
        <label for="dateOfBirth">誕生日: <span class="required">必須</span></label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required><br>
        
        <label for="mailAddress">メールアドレス: <span class="required">必須</span></label>
        <input type="email" id="mailAddress" name="mailAddress" placeholder="例: example@example.com" required><br>
        
        <label for="telephoneNumber">電話番号: <span class="required">必須</span></label>
        <input type="tel" id="telephoneNumber" name="telephoneNumber" placeholder="例: 03-1234-5678" required pattern="\d{2,4}-?\d{2,4}-?\d{3,4}" title="数字のみを入力してください。"><br>
        
        <label for="password">パスワード: <span class="required">必須</span></label>
        <input type="password" id="password" name="password" placeholder="例: ********" required><br>
        
        <button type="submit">登録</button>
    </form>
</body>
</html>
