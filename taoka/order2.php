<?php
session_start();
/* インポート */
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();

/*
 * 社員（syain）データベース作成
 */
$dbSW = $utilConnDB->createDB();  // false:not create

/*
 * 社員（syain）データベースに接続
 */
$pdo = $utilConnDB->connect();   // null:not found

// フォームデータのサニタイズ
$firstname = htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'utf-8');
$lastname = htmlspecialchars($_POST['lastname'], ENT_QUOTES, 'utf-8');
$firstname_kana = htmlspecialchars($_POST['firstname_kana'], ENT_QUOTES, 'utf-8');
$lastname_kana = htmlspecialchars($_POST['lastname_kana'], ENT_QUOTES, 'utf-8');
$postal_code = htmlspecialchars($_POST['postal_code'], ENT_QUOTES, 'utf-8');
$prefecture = htmlspecialchars($_POST['prefecture'], ENT_QUOTES, 'utf-8');
$city = htmlspecialchars($_POST['city'], ENT_QUOTES, 'utf-8');
$address = htmlspecialchars($_POST['address'], ENT_QUOTES, 'utf-8');
$building = htmlspecialchars($_POST['building'], ENT_QUOTES, 'utf-8');
$phone = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'utf-8');

$billingAddress = htmlspecialchars($_POST['billingAddress'], ENT_QUOTES, 'utf-8');
$payment = htmlspecialchars($_POST['payment'], ENT_QUOTES, 'utf-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'utf-8');
$deliveryMethod = htmlspecialchars($_POST['deliveryMethod'], ENT_QUOTES, 'utf-8');
$desiredDeliveryDate = htmlspecialchars($_POST['desiredDeliveryDate'], ENT_QUOTES, 'utf-8');
$desiredDeliveryTime = htmlspecialchars($_POST['desiredDeliveryTime'], ENT_QUOTES, 'utf-8');

// セッションデータの初期化
$_SESSION['checkOut'] = [];
$totalPrice = $_SESSION['totalPrice'] ?? 0;

// 配送先情報の保存
$_SESSION['checkOut']['deliveryName'] = $firstname . " " . $lastname;
$_SESSION['checkOut']['deliveryNameKana'] = $firstname_kana . " " . $lastname_kana;
$_SESSION['checkOut']['deliveryAddress'] = $prefecture . $city . $address . " " . $building;
$_SESSION['checkOut']['deliveryPostCode'] = $postal_code;
$_SESSION['checkOut']['deliveryPhone'] = $phone;

// 請求先住所の保存
if ($billingAddress == "その他住所を入力") {
    $billing_firstname = htmlspecialchars($_POST['hidden_firstname'], ENT_QUOTES, 'utf-8');
    $billing_lastname = htmlspecialchars($_POST['hidden_lastname'], ENT_QUOTES, 'utf-8');
    $billing_firstname_kana = htmlspecialchars($_POST['hidden_firstname_kana'], ENT_QUOTES, 'utf-8');
    $billing_lastname_kana = htmlspecialchars($_POST['hidden_lastname_kana'], ENT_QUOTES, 'utf-8');
    $billing_postal_code = htmlspecialchars($_POST['hidden_postal_code'], ENT_QUOTES, 'utf-8');
    $billing_prefecture = htmlspecialchars($_POST['hidden_prefecture'], ENT_QUOTES, 'utf-8');
    $billing_city = htmlspecialchars($_POST['hidden_city'], ENT_QUOTES, 'utf-8');
    $billing_address = htmlspecialchars($_POST['hidden_address'], ENT_QUOTES, 'utf-8');
    $billing_building = htmlspecialchars($_POST['hidden_building'], ENT_QUOTES, 'utf-8');
    $billing_phone = htmlspecialchars($_POST['hidden_phone'], ENT_QUOTES, 'utf-8');

    $_SESSION['checkOut']['billingName'] = $billing_firstname . " " . $billing_lastname;
    $_SESSION['checkOut']['billingNameKana'] = $billing_firstname_kana . " " . $billing_lastname_kana;
    $_SESSION['checkOut']['billingAddress'] = $billing_prefecture . $billing_city . $billing_address . " " . $billing_building;
    $_SESSION['checkOut']['billingPostCode'] = $billing_postal_code;
    $_SESSION['checkOut']['billingPhone'] =  $billing_phone;

} else {
    $_SESSION['checkOut']['billingName'] = $firstname . " " . $lastname;
    $_SESSION['checkOut']['billingNameKana'] = $firstname_kana . " " . $lastname_kana;
    $_SESSION['checkOut']['billingAddress'] = $prefecture . $city . $address . " " . $building;
    $_SESSION['checkOut']['billingPostCode'] = $postal_code;
    $_SESSION['checkOut']['billingPhone'] =  $phone;
}

// その他情報の保存
$_SESSION['checkOut']['deliveryMethod'] = $deliveryMethod;
$_SESSION['checkOut']['desiredDeliveryDateTime'] = $desiredDeliveryDate.$desiredDeliveryTime;
$_SESSION['checkOut']['payment'] = $payment;
$_SESSION['checkOut']['email'] = $email;
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="order.css">
</head>

<body>
    <?php include "../script/header.php"; ?>
    <form action="order3.php" method="post" class="orderbody">
        <h1>ご注文内容の確認</h1>
        <hr color="#d3d3d3">
        <p class="center">注意：ご注文は確定していません</p>
        <h2>ご注文内容</h2>
        <hr>
        <div class="flex">
            <div class="contents1">
                <h3>お届け情報</h3>
                <label>
                    <h4>お届け先</h4>
                    <?php echo htmlspecialchars($firstname, ENT_QUOTES, 'utf-8'), " ", htmlspecialchars($lastname, ENT_QUOTES, 'utf-8'); ?>
                    <br>
                    <?php echo htmlspecialchars($firstname_kana, ENT_QUOTES, 'utf-8'), " ", htmlspecialchars($lastname_kana, ENT_QUOTES, 'utf-8'); ?>
                    <br>
                    <?php echo htmlspecialchars($postal_code, ENT_QUOTES, 'utf-8'); ?>
                    <br>
                    <?php echo htmlspecialchars($prefecture, ENT_QUOTES, 'utf-8'), htmlspecialchars($city, ENT_QUOTES, 'utf-8'), htmlspecialchars($address, ENT_QUOTES, 'utf-8'), htmlspecialchars($building, ENT_QUOTES, 'utf-8'); ?>
                </label>
                <label>
                    <h4>お届け方法</h4>
                    <?php echo htmlspecialchars($deliveryMethod, ENT_QUOTES, 'utf-8'); ?>
                </label>
                <label>
                    <h4>お届け日時</h4>
                    <?php 
                    echo htmlspecialchars($desiredDeliveryDate, ENT_QUOTES, 'utf-8');
                    echo '<br>';
                    echo htmlspecialchars($desiredDeliveryTime, ENT_QUOTES, 'utf-8'); 
                    ?>
                </label>
            </div>
            <div class="contents2">
                <h3>ご請求情報</h3>
                <label>
                    <h4>ご請求先</h4>
                    <?php
                    if ($billingAddress == "お届け先と同じ") {
                        echo htmlspecialchars($billingAddress, ENT_QUOTES, 'utf-8');
                    } elseif ($billingAddress == "その他住所を入力") {
                        echo htmlspecialchars($billing_firstname, ENT_QUOTES, 'utf-8'), " ", htmlspecialchars($billing_lastname, ENT_QUOTES, 'utf-8');
                        echo "<br>";
                        echo htmlspecialchars($billing_firstname_kana, ENT_QUOTES, 'utf-8'), " ", htmlspecialchars($billing_lastname_kana, ENT_QUOTES, 'utf-8');
                        echo "<br>";
                        echo htmlspecialchars($billing_postal_code, ENT_QUOTES, 'utf-8');
                        echo "<br>";
                        echo htmlspecialchars($billing_prefecture, ENT_QUOTES, 'utf-8'), htmlspecialchars($billing_city, ENT_QUOTES, 'utf-8'), htmlspecialchars($billing_address, ENT_QUOTES, 'utf-8'), htmlspecialchars($billing_building, ENT_QUOTES, 'utf-8');
                    }
                    ?>
                    <br>
                    <?php echo htmlspecialchars($email, ENT_QUOTES, 'utf-8'); ?>
                </label>
                <label>
                    <h4>支払い方法</h4>
                    <?php
                    if ($payment == "新規クレジットカード") {
                        $cardNumber = htmlspecialchars($_POST['cardNumber4'], ENT_QUOTES, 'utf-8');
                        $expiryDate = htmlspecialchars($_POST['expiryDate'], ENT_QUOTES, 'utf-8');
                        $securityCode = htmlspecialchars($_POST['securityCode'], ENT_QUOTES, 'utf-8');
                        echo "下四桁 ", htmlspecialchars($cardNumber, ENT_QUOTES, 'utf-8');
                        echo "<br>";
                        echo htmlspecialchars($expiryDate, ENT_QUOTES, 'utf-8');
                        echo "<br>";
                        echo htmlspecialchars($securityCode, ENT_QUOTES, 'utf-8');
                    } elseif ($payment == "代引き") {
                        echo $payment;
                    }
                    ?>
                </label>
            </div>
            <div class="contents3">
                <h3>ご請求金額</h3>
                <label>
                    <h4>ご請求明細</h4>
                    <p>合計金額:</p>
                    <?php echo htmlspecialchars($totalPrice, ENT_QUOTES, 'utf-8'); ?>
                </label>
                <div class="btn">
                    <input type="submit" value="ご注文を確定する">
                </div>
            </div>
        </div>
    </form>
</body>
</html>