<?php
require_once('../../utilConnDB.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// 検索条件の取得
$productName = $_GET['productName'] ?? '';
$customerNumber = $_GET['customerNumber'] ?? null;

// 注文履歴を取得するクエリ
$sql = "SELECT co.orderNumber, co.orderDateTime, co.orderStatus, co.deliveryName, co.deliveryFurigana,
               co.deliveryAddress, co.deliveryPostCode, co.deliveryPhone, co.deliveryDateTime,
               co.paymentMethodStatus, co.billingName, co.billingFurigana, co.billingAddress,
               co.billingPostCode, co.billingPhone, od.productNumber, od.quantity, od.price,
               p.productName, i.imageName
        FROM customer_orders co
        JOIN orderDetail od ON co.orderNumber = od.orderNumber
        JOIN product p ON od.productNumber = p.productNumber
        JOIN images i ON p.imageNumber = i.imageNumber
        WHERE co.customerNumber = :customerNumber";

if ($productName) {
    $sql .= " AND p.productName LIKE :productName";
}

$sql .= " ORDER BY co.orderDateTime DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
if ($productName) {
    $productName = "%$productName%";
    $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
}
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 注文履歴をグループ化
$orderList = [];
foreach ($orders as $order) {
    $orderList[$order['orderNumber']]['orderDetails'][] = $order;
    $orderList[$order['orderNumber']]['orderInfo'] = [
        'orderDateTime' => $order['orderDateTime'],
        'orderStatus' => $order['orderStatus'],
        'deliveryName' => $order['deliveryName'],
        'deliveryFurigana' => $order['deliveryFurigana'],
        'deliveryAddress' => $order['deliveryAddress'],
        'deliveryPostCode' => $order['deliveryPostCode'],
        'deliveryPhone' => $order['deliveryPhone'],
        'deliveryDateTime' => $order['deliveryDateTime'],
        'paymentMethodStatus' => $order['paymentMethodStatus'],
        'billingName' => $order['billingName'],
        'billingFurigana' => $order['billingFurigana'],
        'billingAddress' => $order['billingAddress'],
        'billingPostCode' => $order['billingPostCode'],
        'billingPhone' => $order['billingPhone']
    ];
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文履歴</title>
    <link rel="stylesheet" type="text/css" href="../../css/orderHistory.css" />
</head>
<body>
    <h1>注文履歴一覧</h1>

    <!-- 検索フォーム -->
    <form method="GET" action="">
        <input type="text" name="productName" placeholder="商品名" value="<?= htmlspecialchars($productName) ?>">
        <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber) ?>">
        <button type="submit">検索</button>
    </form>

    <?php if (empty($orderList)): ?>
        <p>注文履歴がありません。</p>
    <?php else: ?>
        <?php foreach ($orderList as $orderNumber => $order): ?>
            <div class="order-history">
                <h2>注文日: <?= htmlspecialchars($order['orderInfo']['orderDateTime']) ?></h2>
                <p>注文状況: <?= htmlspecialchars($order['orderInfo']['orderStatus']) ?></p>

                <?php foreach ($order['orderDetails'] as $item): ?>
                    <div class="order-item">
                        <img src="<?= htmlspecialchars('../../uploads/' . $item['imageName']) ?>" alt="商品画像">
                        <div>
                            <p>商品名: <?= htmlspecialchars($item['productName']) ?></p>
                            <p>数量: <?= htmlspecialchars($item['quantity']) ?></p>
                            <p>価格: ￥<?= htmlspecialchars(number_format($item['price'])) ?></p>
                        </div>
                        <div class="order-actions">
                            <form method="GET" action="../review/reviewMenu.php">
                                <input type="hidden" name="customerNumber" value="<?= htmlspecialchars($customerNumber) ?>">
                                <input type="hidden" name="productNumber" value="<?= htmlspecialchars($item['productNumber']) ?>">
                                <button type="submit">レビューを書く</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="../../customerToppage.php" class="back-to-top">トップページに戻る</a>
</body>
</html>
