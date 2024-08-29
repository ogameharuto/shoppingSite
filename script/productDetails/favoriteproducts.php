<?php
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// GETパラメータからproductNumberを取得
$productNumber = json_decode(file_get_contents('php://input'), true);
$customerNumber = 2;

try {
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }
    
    // データの抽出
    $sql = "SELECT customerNumber FROM customer";
    $stmt = $pdo->query($sql);

    // データの挿入
    $insertSql = "INSERT INTO favoriteproducts (customerNumber, productNumber, addeddate) 
                  VALUES (:customerNumber, :productNumber, :addeddate)";
    $insertStmt = $pdo->prepare($insertSql);

    // 現在の日時を取得
    $addeddate = date('Y-m-d H:i:s');

    // 各顧客に対してデータを挿入
//    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $insertStmt->execute([
            ':customerNumber' => $customerNumber,
            ':productNumber' => $productNumber['productNumber'],
            ':addeddate' => $addeddate
        ]);
  //  }

    $pdo->commit(); // トランザクションのコミット
    /*echo 'Data inserted successfully.';*/

    // 挿入されたデータを取得して表示するためのクエリ
    $productsSql = "
        SELECT fp.productNumber, fp.customerNumber,  p.productName, p.price, p.storeNumber ,i.imageNumber,i.imageName
        FROM favoriteproducts fp
        JOIN product p ON fp.productNumber = p.productNumber
        JOIN images i ON p.imageNumber = i.imageNumber
        WHERE fp.customerNumber = :customerNumber

    ";
    $productsStmt = $pdo->prepare($productsSql);
    $productsStmt->execute([
                            ':customerNumber' => $customerNumber,]);
    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $pdo->rollBack(); // エラー発生時にロールバック
    echo 'Error: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お気に入り</title>
    <link rel="stylesheet" href="kokyakutouroku.css">
</head>
<body>
    <h1>お気に入り</h1>
    <table>
        <thead>
            <tr>

                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>ストア名</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><img src="../uploads/<?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="
                            <?php echo htmlspecialchars($product['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100"></td>
                        <td><?php echo htmlspecialchars($product['productName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($product['storeNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">お気に入りした商品がありません。</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
