<?php
session_start();
$storeNumber = $_SESSION['store']['storeNumber'];

/* インポート */
require_once('../utilConnDB.php');

/* インスタンス生成 */
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

/* HTMLからデータを受け取る */
$productName = htmlspecialchars($_POST['productName'], ENT_QUOTES, 'utf-8');
$price = htmlspecialchars($_POST['price'], ENT_QUOTES, 'utf-8');
$category = htmlspecialchars($_POST['category'], ENT_QUOTES, 'utf-8');
$stock = htmlspecialchars($_POST['stock'], ENT_QUOTES, 'utf-8');
$productDescription = htmlspecialchars($_POST['productDescription'], ENT_QUOTES, 'utf-8');
$releaseDate = htmlspecialchars($_POST['releaseDate'], ENT_QUOTES, 'utf-8');
$pageDisplayStatus = htmlspecialchars($_POST['pageDisplayStatus'], ENT_QUOTES, 'utf-8');

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];

    $targetDir = "../script/uploads/"; // アップロードするディレクトリ
    $targetFile = $targetDir . basename($imageName);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // エラーチェックと条件を一度に確認し、エラーの場合は早期リターン
    if ($imageError !== 0 || !getimagesize($imageTmpName) || $imageSize > 500000 || !in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "アップロードに失敗しました。ファイルが画像でないか、許可されていない形式またはサイズが大きすぎます。";
        return;
    }

    // ディレクトリが存在しない場合は作成
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // 0777 はフルアクセス権限を意味します
    }

    $imageData = file_get_contents($imageTmpName);
    $imageHash = hash('sha256', $imageData);

    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $checkSql = "SELECT COUNT(*) FROM images WHERE storeNumber = :storeNumber AND imageHash = :imageHash";
        $params[':storeNumber'] = $storeNumber;
        $params[':imageHash'] = $imageHash;
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute($params);
        $imageExists = $checkStmt->fetchColumn();

        if (!$imageExists) { // 画像が存在しない場合のみ保存
            $uploadDir = '../script/uploads/';
            $uploadFile = $uploadDir . basename($imageName);

            if (move_uploaded_file($imageTmpName, $uploadFile)) {
                $insertSql = "INSERT INTO images (storeNumber, imageName, imageHash, addedDate) VALUES (:storeNumber, :imageName, :imageHash, NOW())";
                $params[':storeNumber'] = $storeNumber;
                $params[':imageName'] = $imageName;
                $params[':imageHash'] = $imageHash;
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute($params);
                $pdo->commit();
                $_SESSION['insImageHash'] = $imageHash;
            }
        }
    } catch (Exception $e) {
        $pdo->rollBack();
    }
}
else {
    echo "流れてないよ";
}

$sql = "SELECT imageNumber
        FROM images
        Where imageHash = :imageHash";
$params = [];
$params[':imageHash'] = $_SESSION['insImageHash'];
$stmt = $pdo->prepare($sql);
$imageNumber = $stmt->execute($params);

$sql = "INSERT INTO product (
            productName, price, categoryNumber, storeCategoryNumber, stockQuantity, 
            productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus,imageNumber
        ) VALUES (
            :productName, :price, :categoryNumber, :storeCategoryNumber, :stockQuantity,
            :productDescription, :dateAdded, :releaseDate, :storeNumber, :pageDisplayStatus, :imageNumber
        )";
$params = [];
$params[':productName'] = $productName;
$params[':price'] = $price;
$params[':categoryNumber'] = $category;
$params[':stockQuantity'] = $stock;
$params[':productDescription'] = $productDescription;
$params[':dateAdded'] = date("Y-m-d");
$params[':releaseDate'] = $releaseDate;
$params[':storeNumber'] = $storeNumber;
$params[':pageDisplayStatus'] = $pageDisplayStatus;
$params[':imageNumber'] = $imageNumber;
$params[':storeCategoryNumber'] = null;

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

if ($stmt == true) {
    $utilConnDB->commit($pdo);
    $_SESSION['message'] = '登録が完了しました。';
} else {
    $utilConnDB->rollback($pdo);
}

//DB切断
$utilConnDB->disconnect($pdo);

//次に実行するモジュール
header('Location: productManagerMenu.php')
?>