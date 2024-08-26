<?php
session_start();
/* インポート */
require_once('../utilConnDB.php');
require_once('../script/storeSQL.php');
$cartDAO = new StoreSQL();
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$orderProductNumber = $_SESSION['orderProductNumber'];
$orderStatus = '注文完了';

$deliveryName = $_SESSION['checkOut']['deliveryName'];
$deliveryFurigana = $_SESSION['checkOut']['deliveryNameKana'];
$deliveryAddress = $_SESSION['checkOut']['deliveryAddress'];
$deliveryPostCode = $_SESSION['checkOut']['deliveryPostCode'];
$deliveryPhone = $_SESSION['checkOut']['deliveryPhone'];

$billingName = $_SESSION['checkOut']['billingName'];
$billingFurigana = $_SESSION['checkOut']['billingNameKana'];
$billingAddress = $_SESSION['checkOut']['billingAddress'];
$billingPostCode = $_SESSION['checkOut']['billingPostCode'];
$billingPhone = $_SESSION['checkOut']['billingPhone'];

$paymentMethodStatus = $_SESSION['checkOut']['payment'];

$sql = "INSERT INTO customer_orders 
(customerNumber, orderDateTime, orderStatus, deliveryName, deliveryFurigana, deliveryAddress,
deliveryPostCode, deliveryPhone, paymentMethodStatus, billingName, billingFurigana,
billingAddress, billingPostCode, billingPhone
) 
VALUES
(:customerNumber, :orderDateTime, :orderStatus, :deliveryName, :deliveryFurigana, :deliveryAddress,
:deliveryPostCode, :deliveryPhone, :paymentMethodStatus, :billingName, :billingFurigana,
:billingAddress, :billingPostCode, :billingPhone);";
$params[':customerNumber'] = $_SESSION['customer']['customerNumber'];
$params[':orderDateTime'] = date("Y-m-d H:i:s");
$params[':orderStatus'] = $orderStatus;
$params[':deliveryName'] = $deliveryName;
$params[':deliveryFurigana'] = $deliveryFurigana;
$params[':deliveryAddress'] = $deliveryAddress;
$params[':deliveryPostCode'] = $deliveryPostCode;
$params[':deliveryPhone'] = $deliveryPhone;
$params[':paymentMethodStatus'] = $paymentMethodStatus;
$params[':billingName'] = $billingName;
$params[':billingFurigana'] = $billingFurigana;
$params[':billingAddress'] = $billingAddress;
$params[':billingPostCode'] = $billingPostCode;
$params[':billingPhone'] = $billingPhone;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if ($stmt) {
    $customerNumber = $_SESSION['customer']['customerNumber'];
    $productNumber = $orderProductNumber;
    $result = $cartDAO->deleteCartItem($pdo, $customerNumber, $productNumber);
    if ($result) {
        unset($_SESSION['cartList']);
        unset($_SESSION['checkOut']);
        unset($_SESSION['orderProductNumber']);
        $utilConnDB->commit($pdo);
    } else {
        throw new Exception("削除が失敗しました。");
    }
} else {
    $utilConnDB->rollback($pdo);
}

//DB切断
$utilConnDB->disconnect($pdo);
header('Location: order4.php');
?>