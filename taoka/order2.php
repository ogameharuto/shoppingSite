<?php
session_start();
/* インポート */
require_once('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();

/*
 * 社員（syain）データベース作成
 */
$dbSW  = $utilConnDB->createDB();  // false:not create
/*
 * 社員（syain）データベースに接続
 */
$pdo   = $utilConnDB->connect();   // null:not found

$firstname = htmlspecialchars($_POST['firstname'],ENT_QUOTES, 'utf-8');
$lastname = htmlspecialchars($_POST['lastname'],ENT_QUOTES, 'utf-8');
$firstname_kana = htmlspecialchars($_POST['firstname_kana'],ENT_QUOTES, 'utf-8');
$lastname_kana = htmlspecialchars($_POST['lastname_kana'],ENT_QUOTES, 'utf-8');
$postal_code = htmlspecialchars($_POST['postal_code'],ENT_QUOTES, 'utf-8');
$prefecture = htmlspecialchars($_POST['prefecture'],ENT_QUOTES, 'utf-8');
$city = htmlspecialchars($_POST['city'],ENT_QUOTES, 'utf-8');
$address = htmlspecialchars($_POST['address'],ENT_QUOTES, 'utf-8');
$building = htmlspecialchars($_POST['building'],ENT_QUOTES, 'utf-8');
$phone = htmlspecialchars($_POST['phone'],ENT_QUOTES, 'utf-8');

$billingAddress = htmlspecialchars($_POST['billingAddress'],ENT_QUOTES, 'utf-8');
$payment = htmlspecialchars($_POST['payment'],ENT_QUOTES, 'utf-8');
$email = htmlspecialchars($_POST['email'],ENT_QUOTES, 'utf-8');

$totalPrice = $_SESSION['totalPrice'];

unset($_SESSION['totalPrice']);
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
<form action="cartDel.php" method="post" class="orderbody">
    <h1>ご注文内容の確認</h1>
    <hr color="#d3d3d3">
    <p class="center">注意：ご注文は確定していません</p>
    <h2>ご注文内容</h2>
    <hr>
    <div class="flex">
        <div class="contents1">
            <h3>お届け情報</h3>
            <label>
            <nobr><h4>お届け先</h4></nobr>
                <?php echo $firstname," ",$lastname ?>
                <br>
                <?php echo $firstname_kana," ",$lastname_kana ?>
                <br>
                <?php echo $postal_code ?>
                <br>
                <?php echo $prefecture,$city,$address,$building ?>
            </label>
            <label>
                <h4>お届け方法</h4>
            </label>
            <label>
               <h4>お届け日時</h4> 
            </label>
        </div>
        <div class="contents2">
        <h3>ご請求情報</h3>
            <label>
                <h4>ご請求先</h4>
                <?php
                if($billingAddress == "お届け先と同じ"){
                    echo $billingAddress;
                }
                elseif($billingAddress == "その他住所を入力"){
                    $hidden_firstname = htmlspecialchars($_POST['hidden_firstname'],ENT_QUOTES, 'utf-8');
                    $hidden_lastname = htmlspecialchars($_POST['hidden_lastname'],ENT_QUOTES, 'utf-8');
                    $hidden_firstname_kana = htmlspecialchars($_POST['hidden_firstname_kana'],ENT_QUOTES, 'utf-8');
                    $hidden_lastname_kana = htmlspecialchars($_POST['hidden_lastname_kana'],ENT_QUOTES, 'utf-8');
                    $hidden_postal_code = htmlspecialchars($_POST['hidden_postal_code'],ENT_QUOTES, 'utf-8');
                    $hidden_prefecture = htmlspecialchars($_POST['hidden_prefecture'],ENT_QUOTES, 'utf-8');
                    $hidden_city = htmlspecialchars($_POST['hidden_city'],ENT_QUOTES, 'utf-8');
                    $hidden_address = htmlspecialchars($_POST['hidden_address'],ENT_QUOTES, 'utf-8');
                    $hidden_building = htmlspecialchars($_POST['hidden_building'],ENT_QUOTES, 'utf-8');
                    $hidden_phone = htmlspecialchars($_POST['hidden_phone'],ENT_QUOTES, 'utf-8');
                    echo $hidden_firstname," ",$hidden_lastname;
                    echo "<br>";
                    echo $hidden_firstname_kana," ",$hidden_lastname_kana;
                    echo "<br>";
                    echo $hidden_postal_code;
                    echo "<br>";
                    echo $hidden_prefecture,$hidden_city,$hidden_address,$hidden_building;
                }
                ?>
                <br>
                <?php echo $email ?>
            </label>
            <label>
                <h4>支払い方法</h4>
                <?php
                if($payment == "新規クレジットカード"){
                    $cardNumber = htmlspecialchars($_POST['cardNumber4'],ENT_QUOTES, 'utf-8');
                    $expiryDate = htmlspecialchars($_POST['expiryDate'],ENT_QUOTES, 'utf-8');
                    $securityCode = htmlspecialchars($_POST['securityCode'],ENT_QUOTES, 'utf-8');
                    echo "下四桁",$cardNumber;
                    echo "<br>";
                    echo $expiryDate;
                    echo "<br>";
                    echo $securityCode;
                }
                elseif($payment == "ゆっくりお支払い"){
                    echo "ゆっくりお支払い";
                }
                ?>
            </label>
        </div>
        <div class="contents3">
        <h3>ご請求金額</h3>
            <label>
                <h4>ご請求明細</h4>
                <p>合計金額:</p>
                <?php echo $totalPrice ?>
            </label>
            <div class="btn">
                <input type="submit" value="ご注文を確定する">
            </div>
        </div>
    </div>
</form>
</body>
</html>