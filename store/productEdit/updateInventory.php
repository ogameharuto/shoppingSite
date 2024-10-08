<?php
session_start();

// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 'productImage' がセットされているか確認
    if (!isset($_FILES['productImage'])) {
        echo "ファイルがアップロードされていません。";
        exit;
    }

    $productImages = $_FILES['productImage'];
    $productNames = $_POST['productName'] ?? [];
    $specialPrices = $_POST['price'] ?? [];
    $startDates = $_POST['dateAdded'] ?? [];
    $endDates = $_POST['releaseDate'] ?? [];
    $storeCategoryNumbers = $_POST['storeCategoryNumber'] ?? [];
    $categoryNumbers = $_POST['categoryNumber'] ?? [];
    $pageDisplayStatuses = $_POST['pageDisplayStatus'] ?? [];

    // データ検証
    foreach ($specialPrices as $productNumber => $price) {
        if (!is_numeric($price)) {
            echo "特価は数値である必要があります。";
            exit;
        }
    }

    try {
        // トランザクションを開始
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        foreach ($productNames as $productNumber => $productName) {
            $price = $specialPrices[$productNumber] ?? null;
            $dateAdded = $startDates[$productNumber] ?? null;
            $releaseDate = $endDates[$productNumber] ?? null;
            $storeCategoryNumber = $storeCategoryNumbers[$productNumber] ?? null;
            $categoryNumber = $categoryNumbers[$productNumber] ?? null;
            $pageDisplayStatus = $pageDisplayStatuses[$productNumber] ?? null;

            // 画像のアップロード処理
            $imageNumber = null; // デフォルトでは null に設定
            if (isset($productImages['name'][$productNumber]) && !empty($productImages['name'][$productNumber])) {
                $targetDir = "../../uploads/";
                $targetFile = $targetDir . basename($productImages["name"][$productNumber]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // ディレクトリが存在しない場合は作成
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // 画像ファイルが実際の画像か確認
                $check = getimagesize($productImages["tmp_name"][$productNumber]);
                if ($check === false) {
                    echo "ファイルは画像ではありません。";
                    $uploadOk = 0;
                }

                // ファイルサイズを確認
                if ($productImages["size"][$productNumber] > 500000) { // 500KBの制限
                    echo "ファイルが大きすぎます。";
                    $uploadOk = 0;
                }

                // 許可するファイル形式を確認
                if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "JPG, JPEG, PNG & GIF のみ許可されています。";
                    $uploadOk = 0;
                }

                // エラーがない場合、ファイルをアップロード
                if ($uploadOk == 1) {
                    // 画像のハッシュ値を計算
                    $hashValue = hash_file('sha256', $productImages["tmp_name"][$productNumber]);

                    // 画像がすでに存在するか確認
                    $sql = "SELECT imageNumber FROM images WHERE imageHash = :imageHash";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(['imageHash' => $hashValue]);
                    $existingImage = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($existingImage) {
                        // 既存の画像が見つかった場合
                        $imageNumber = $existingImage['imageNumber'];
                    } else {
                        // 画像をデータベースに挿入
                        $sql = "INSERT INTO images (imageName, imageHash, storeNumber) VALUES (:imageName, :imageHash, :storeNumber)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            'imageName' => basename($productImages["name"][$productNumber]),
                            'imageHash' => $hashValue,
                            'storeNumber' => $_SESSION['store']['storeNumber'] // 現在のストア番号をセット
                        ]);
                        $imageNumber = $pdo->lastInsertId();
                    }

                    // アップロードされたファイルを移動
                    if (!move_uploaded_file($productImages["tmp_name"][$productNumber], $targetFile)) {
                        echo "ファイルのアップロードに失敗しました。";
                        $uploadOk = 0;
                    }
                }
            }

            // 商品情報を更新
            $sql = "UPDATE product SET
                productName = :productName,
                price = :price,
                storeCategoryNumber = :storeCategoryNumber,
                categoryNumber = :categoryNumber,
                dateAdded = :dateAdded,
                releaseDate = :releaseDate,
                pageDisplayStatus = :pageDisplayStatus,
                imageNumber = :imageNumber
                WHERE productNumber = :productNumber";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'productName' => $productName,
                'price' => $price,
                'storeCategoryNumber' => $storeCategoryNumber,
                'categoryNumber' => $categoryNumber,
                'dateAdded' => $dateAdded,
                'releaseDate' => $releaseDate,
                'pageDisplayStatus' => $pageDisplayStatus,
                'imageNumber' => $imageNumber,
                'productNumber' => $productNumber,
            ]);
        }

        // トランザクションをコミット
        $pdo->commit();

        // リダイレクトを適切な位置に移動
        header('Location: ../productManagerMenu.php');
        exit;

    } catch (PDOException $e) {
        // エラーが発生した場合、トランザクションをロールバック
        $pdo->rollBack();
        echo "エラーが発生しました: " . htmlspecialchars($e->getMessage());
    }

    $utilConnDB->disconnect($pdo);
} else {
    echo "無効なリクエストです。";
    //header('Location: editProductInventoryMenu.php');
}
?>
