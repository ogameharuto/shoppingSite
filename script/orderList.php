<?php
// セッション開始
session_start();

// ログイン確認
if (!isset($_SESSION['store'])) {
    $_SESSION['message'] = "ログインが必要です。";
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}

// データベース接続
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// ログイン中の店舗情報を取得
$store = $_SESSION['store'];
$storeNumber = $store['storeNumber'];

// メッセージ変数の初期化
$message = "";

// 注文ステータスの更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderNumber'], $_POST['orderStatus'])) {
    $orderNumber = $_POST['orderNumber'];
    $orderStatus = $_POST['orderStatus'];

    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $updateSql = "UPDATE `orderTable` SET orderStatus = :orderStatus WHERE orderNumber = :orderNumber";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':orderStatus' => $orderStatus,
            ':orderNumber' => $orderNumber
        ]);

        $pdo->commit();
        $_SESSION['message'] = "ステータスが正常に更新されました。";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } catch (Exception $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $_SESSION['message'] = "ステータスの更新中にエラーが発生しました: " . $e->getMessage();
    }
}

// セッションからメッセージを取得してクリア
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// フィルタリングと検索のための注文データを取得
$orderNumber = $_GET['orderNumber'] ?? '';
$orderDateFrom = $_GET['orderDateFrom'] ?? '';
$orderDateTo = $_GET['orderDateTo'] ?? '';
$paymentMethodStatus = $_GET['paymentMethodStatus'] ?? '';

// 店舗に関連する注文を取得
$sql = "
    SELECT 
        o.orderNumber, o.customerNumber, c.customerName, o.orderDateTime, o.orderStatus, 
        o.deliveryAddress, o.paymentMethodStatus, o.billingName, o.billingAddress,
        p.productName, od.quantity
    FROM 
        `orderTable` o
    JOIN 
        `orderDetail` od ON o.orderNumber = od.orderNumber
    JOIN 
        `product` p ON od.productNumber = p.productNumber
    JOIN 
        `customer` c ON o.customerNumber = c.customerNumber
    WHERE 
        p.storeNumber = :storeNumber
";

$params = [':storeNumber' => $storeNumber];

if ($orderNumber) {
    $sql .= " AND o.orderNumber LIKE :orderNumber";
    $params[':orderNumber'] = "%$orderNumber%";
}

if ($orderDateFrom && $orderDateTo) {
    $sql .= " AND o.orderDateTime BETWEEN :orderDateFrom AND :orderDateTo";
    $params[':orderDateFrom'] = $orderDateFrom;
    $params[':orderDateTo'] = $orderDateTo;
}

if ($paymentMethodStatus) {
    $sql .= " AND o.paymentMethodStatus = :paymentMethodStatus";
    $params[':paymentMethodStatus'] = $paymentMethodStatus;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文管理 - 新規注文一覧</title>
    <link rel="stylesheet" href="orderList.css">
</head>
<body>
    <h1>注文管理 - 新規注文一覧</h1>
    <?php if (!empty($message)): ?>
        <script>
            alert("<?php echo $message; ?>");
        </script>
    <?php endif; ?>
    <form method="GET">
        <div>
            <label for="orderNumber">注文番号: </label>
            <input type="text" id="orderNumber" name="orderNumber" value="<?php echo htmlspecialchars($orderNumber); ?>">
        </div>
        <div>
            <label for="orderDateFrom">注文日時: </label>
            <input type="date" id="orderDateFrom" name="orderDateFrom" value="<?php echo htmlspecialchars($orderDateFrom); ?>">
            ～
            <input type="date" id="orderDateTo" name="orderDateTo" value="<?php echo htmlspecialchars($orderDateTo); ?>">
        </div>
        <div>
            <label for="paymentMethodStatus">お支払い方法: </label>
            <select id="paymentMethodStatus" name="paymentMethodStatus">
                <option value="">選択</option>
                <option value="クレジットカード" <?php if ($paymentMethodStatus == 'クレジットカード') echo 'selected'; ?>>クレジットカード</option>
                <option value="銀行振込" <?php if ($paymentMethodStatus == '銀行振込') echo 'selected'; ?>>銀行振込</option>
                <option value="代引き" <?php if ($paymentMethodStatus == '代引き') echo 'selected'; ?>>代引き</option>
            </select>
        </div>
        <div class="action-buttons">
            <button type="submit">検索</button>
            <a href="<?php echo $_SERVER['PHP_SELF']; ?>">検索条件クリア</a>
        </div>
    </form>

    <table>
        <thead>
            <tr>
                <th>注文番号</th>
                <th>顧客番号</th>
                <th>顧客名</th>
                <th>注文日時</th>
                <th>注文ステータス</th>
                <th>お届け先住所</th>
                <th>支払い方法ステータス</th>
                <th>ご請求先名前</th>
                <th>ご請求先住所</th>
                <th>商品名</th>
                <th>数量</th>
                <th>アクション</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['orderNumber']); ?></td>
                    <td><?php echo htmlspecialchars($order['customerNumber']); ?></td>
                    <td><?php echo htmlspecialchars($order['customerName']); ?></td>
                    <td><?php echo htmlspecialchars($order['orderDateTime']); ?></td>
                    <td><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                    <td><?php echo htmlspecialchars($order['deliveryAddress']); ?></td>
                    <td><?php echo htmlspecialchars($order['paymentMethodStatus']); ?></td>
                    <td><?php echo htmlspecialchars($order['billingName']); ?></td>
                    <td><?php echo htmlspecialchars($order['billingAddress']); ?></td>
                    <td><?php echo htmlspecialchars($order['productName']); ?></td>
                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                    <td>
                        <form method="post" style="display:inline-block;">
                            <input type="hidden" name="orderNumber" value="<?php echo htmlspecialchars($order['orderNumber']); ?>">
                            <select name="orderStatus">
                                <option value="受注済み" <?php if ($order['orderStatus'] == '受注済み') echo 'selected'; ?>>受注済み</option>
                                <option value="配送中" <?php if ($order['orderStatus'] == '配送中') echo 'selected'; ?>>配送中</option>
                                <option value="配送完了" <?php if ($order['orderStatus'] == '配送完了') echo 'selected'; ?>>配送完了</option>
                            </select>
                            <button type="submit">更新</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12">注文が見つかりませんでした。</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
