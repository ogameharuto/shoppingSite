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
$shoppCategory = htmlspecialchars($_POST['shoppCategory'], ENT_QUOTES, 'utf-8');
$storeCategory = htmlspecialchars($_POST['storeCategory'], ENT_QUOTES, 'utf-8');
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
        exit; // `return` ではなく `exit` を使用してスクリプトの実行を停止します
    }

    // ディレクトリが存在しない場合は作成
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // 0777 はフルアクセス権限を意味します
    }

    $imageData = file_get_contents($imageTmpName);
    $imageHash = hash('sha256', $imageData);

    try {
        // トランザクション開始
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $checkSql = "SELECT COUNT(*) FROM images WHERE storeNumber = :storeNumber AND imageHash = :imageHash";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            ':storeNumber' => $storeNumber,
            ':imageHash' => $imageHash
        ]);
        $imageExists = $checkStmt->fetchColumn();

        if ($imageExists == 0) { // 画像が存在しない場合のみ保存
            $uploadFile = $targetDir . basename($imageName);

            if (move_uploaded_file($imageTmpName, $uploadFile)) {
                $insertSql = "INSERT INTO images (storeNumber, imageName, imageHash, addedDate) VALUES (:storeNumber, :imageName, :imageHash, NOW())";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([
                    ':storeNumber' => $storeNumber,
                    ':imageName' => $imageName,
                    ':imageHash' => $imageHash
                ]);
                $_SESSION['insImageHash'] = $imageHash;
            } else {
                // ファイルの移動に失敗した場合、ロールバック
                $pdo->rollBack();
                echo "画像のアップロードに失敗しました。";
                exit;
            }
        } else {
            // 画像がすでに存在する場合、ロールバック
            $pdo->rollBack();
            echo "指定された画像はすでに他の商品で使用されています。";
            exit;
        }
        
        // 画像の番号を取得
        $imageNumberSql = "SELECT imageNumber FROM images WHERE imageHash = :imageHash";
        $imageNumberStmt = $pdo->prepare($imageNumberSql);
        $imageNumberStmt->execute([':imageHash' => $_SESSION['insImageHash']]);
        $imageNumber = $imageNumberStmt->fetchColumn();

        // 画像のハッシュ値が他の商品で使用されているか確認
        $checkProductSql = "SELECT COUNT(*) FROM product WHERE storeNumber = :storeNumber AND imageNumber = :imageNumber";
        $checkProductStmt = $pdo->prepare($checkProductSql);
        $checkProductStmt->execute([
            ':storeNumber' => $storeNumber,
            ':imageNumber' => $imageNumber
        ]);
        $imageUsed = $checkProductStmt->fetchColumn();

        if ($imageUsed > 0) {
            // 画像がすでに他の商品で登録されている場合、ロールバック
            $pdo->rollBack();
            echo "指定された画像はすでに他の商品で使用されています。商品を登録できません。";
            exit;
        }

        // 商品をデータベースに挿入
        $productInsertSql = "INSERT INTO product (
            productName, price, categoryNumber, storeCategoryNumber, stockQuantity, 
            productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus, imageNumber
        ) VALUES (
            :productName, :price, :categoryNumber, :storeCategoryNumber, :stockQuantity,
            :productDescription, :dateAdded, :releaseDate, :storeNumber, :pageDisplayStatus, :imageNumber
        )";
        $productInsertStmt = $pdo->prepare($productInsertSql);
        $result = $productInsertStmt->execute([
            ':productName' => $productName,
            ':price' => $price,
            ':categoryNumber' => $shoppCategory,
            ':storeCategoryNumber' => $storeCategory,
            ':stockQuantity' => $stock,
            ':productDescription' => $productDescription,
            ':dateAdded' => date("Y-m-d"),
            ':releaseDate' => $releaseDate,
            ':storeNumber' => $storeNumber,
            ':pageDisplayStatus' => $pageDisplayStatus,
            ':imageNumber' => $imageNumber
        ]);

        if ($result) {
            $pdo->commit();
            $_SESSION['message'] = '登録が完了しました。';
            header('Location: productManagerMenu.php');
            exit;
        } else {
            // 商品登録に失敗した場合、ロールバック
            $pdo->rollBack();
            echo "商品登録に失敗しました。";
            exit;
        }

    } catch (Exception $e) {
        // 例外が発生した場合、ロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "エラーが発生しました: " . $e->getMessage();
        exit;
    }
} else {
    echo "画像が選択されていません。";
    exit;
}

// DB切断
$utilConnDB->disconnect($pdo);
?>