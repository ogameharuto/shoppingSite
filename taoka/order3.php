<?php
session_start();
/* インポート */
require_once('../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
$orderStatus = '注文完了';
$deliveryAddress = $_SESSION['delivery_address'];
$billingAddress = $_SESSION['billing_address'];
$billingName = $_SESSION['delivery_name'];
$paymentMethodStatus = $_SESSION['payment'];

$sql = "INSERT INTO customer_orders (customerNumber, orderDateTime, orderStatus, deliveryAddress, paymentMethodStatus, billingName, billingAddress) VALUES
  (:customerNumber, :orderDateTime, :orderStatus, :deliveryAddress, :paymentMethodStatus, :billingName, :billingAddress);";
$params[':customerNumber'] = $_SESSION['customer']['customerNumber'];
$params[':orderDateTime'] = date("Y-m-d");
$params[':orderStatus'] = $orderStatus;
$params[':deliveryAddress'] = $deliveryAddress;
$params[':paymentMethodStatus'] = $paymentMethodStatus;
$params[':billingName'] = $billingName;
$params[':billingAddress'] = $billingAddress;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if($stmt == true){
    $utilConnDB->commit($pdo);
    $_SESSION['message'] = '登録が完了しました。';
}
else{
    $utilConnDB->rollback($pdo);
}

//DB切断
$utilConnDB->disconnect($pdo);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文完了</title>
    <link rel="stylesheet" href="orderComplete.css">
</head>
<body>
    <div class="orderComplete">
        <h1>注文が完了しました</h1>
        <p>ご注文いただき、ありがとうございます。</p>
        <p>ご注文番号: <?php echo htmlspecialchars($_SESSION['orderNumber'] ?? ''); ?></p>
        <a href="index.php">トップページへ戻る</a>
    </div>
</body>
</html>
