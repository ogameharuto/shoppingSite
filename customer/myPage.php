<?php
session_start();
$customer = $_SESSION['customer'] ?? null;
$userId = $customer['customerNumber'] ?? null;
$userName = $customer['customerName'] ?? null;

// ログイン確認
if ($userName == "ゲスト") {
    print($userName);
    header("Location: account/customerLoginMenu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ</title>
    <link rel="stylesheet" href="../css/myPage.css">
    <link rel="stylesheet" href="../css/header.css">
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        function navigateToOrderHistory(customerNumber) {
            const url = `orderHistory/orderHistoryMenu.php?customerNumber=${customerNumber}`;
            navigateTo(url);
        }
    </script>
</head>
<body>
<?php include "header.php"; ?>
    <h2>マイページ</h2>

    <nav>
        <div class="left-side">
            <h4 class="box">
                <a href="information/customerInformation.php?userId=<?php echo urlencode($userId); ?>">会員情報を見る</a>
            </h4>
        </div>
        <div class="right-side">
            <ul>
                <li><button onclick="navigateToOrderHistory(<?php echo htmlspecialchars($userId); ?>)">注文履歴</button></li>
            </ul>
        </div>
    </nav>
    <footer>
        
    </footer>
</body>
</html>
