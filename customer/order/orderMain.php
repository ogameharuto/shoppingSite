<?php
date_default_timezone_set('Asia/Tokyo');
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
$deliveryDateTime = $_SESSION['checkOut']['desiredDeliveryDateTime'];

$billingName = $_SESSION['checkOut']['billingName'];
$billingFurigana = $_SESSION['checkOut']['billingNameKana'];
$billingAddress = $_SESSION['checkOut']['billingAddress'];
$billingPostCode = $_SESSION['checkOut']['billingPostCode'];
$billingPhone = $_SESSION['checkOut']['billingPhone'];

$paymentMethodStatus = $_SESSION['checkOut']['payment'];

$sql = "INSERT INTO customer_orders 
(customerNumber, orderDateTime, orderStatus, deliveryName, deliveryFurigana, deliveryAddress,
deliveryPostCode, deliveryPhone, deliveryDateTime, paymentMethodStatus, billingName, 
billingFurigana, billingAddress, billingPostCode, billingPhone
) 
VALUES
(:customerNumber, :orderDateTime, :orderStatus, :deliveryName, :deliveryFurigana, :deliveryAddress,
:deliveryPostCode, :deliveryPhone, :deliveryDateTime, :paymentMethodStatus, :billingName, 
:billingFurigana, :billingAddress, :billingPostCode, :billingPhone);";
$params[':customerNumber'] = $_SESSION['customer']['customerNumber'];
$params[':orderDateTime'] = date("Y-m-d H:i:s");
$params[':orderStatus'] = $orderStatus;
$params[':deliveryName'] = $deliveryName;
$params[':deliveryFurigana'] = $deliveryFurigana;
$params[':deliveryAddress'] = $deliveryAddress;
$params[':deliveryPostCode'] = $deliveryPostCode;
$params[':deliveryPhone'] = $deliveryPhone;
$params[':deliveryDateTime'] = $deliveryDateTime;
$params[':paymentMethodStatus'] = $paymentMethodStatus;
$params[':billingName'] = $billingName;
$params[':billingFurigana'] = $billingFurigana;
$params[':billingAddress'] = $billingAddress;
$params[':billingPostCode'] = $billingPostCode;
$params[':billingPhone'] = $billingPhone;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if ($stmt) {
    $orderNumber = $pdo->lastInsertId();
    $customerNumber = $_SESSION['customer']['customerNumber'];
    $productNumber = $orderProductNumber;
    $cartList = $_SESSION['cartList'];

    foreach ($cartList as $item) {
        $productNumber = $item['productNumber'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        // 在庫の確認
        $sql = "SELECT stockQuantity FROM product WHERE productNumber = :productNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':productNumber' => $productNumber]);
        $currentStock = $stmt->fetchColumn();

        if ($currentStock < $quantity) {
            // 在庫が不足している場合
            throw new Exception("商品番号 $productNumber の在庫が不足しています。");
        }
        
        $sql = "INSERT INTO orderdetail 
    (orderNumber, productNumber, quantity, price) 
    VALUES
    (:orderNumber, :productNumber, :quantity, :price);";

        $params = [
            ':orderNumber' => $orderNumber,
            ':productNumber' => $productNumber,
            ':quantity' => $quantity,
            ':price' => $price
        ];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
    // 在庫数の更新
    $sql = "UPDATE product 
        SET stockQuantity = stockQuantity - :quantity 
        WHERE productNumber = :productNumber;";
    
    $params = [
        ':quantity' => $quantity,
        ':productNumber' => $productNumber
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $result = $cartDAO->deleteCartItem($pdo, $customerNumber, $productNumber);
    if ($result) {
        unset($_SESSION['cartList']);
        unset($_SESSION['checkOut']);
        unset($_SESSION['orderProductNumber']);
        $_SESSION['orderNumber'] = $orderNumber;
        $pdo->commit();
    } else {
        throw new Exception("削除が失敗しました。");
    }
} else {
    $pdo->rollback();
}

//DB切断
$utilConnDB->disconnect($pdo);
header('Location: order4.php');
?>