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
                        echo "既存の画像が使用されます。画像ID: " . $imageNumber;
                    } else {
                        // 画像ファイルをアップロード
                        if (move_uploaded_file($productImages["tmp_name"][$productNumber], $targetFile)) {
                            echo "ファイル " . htmlspecialchars(basename($productImages["name"][$productNumber])) . " がアップロードされました。";

                            // 画像情報をデータベースに保存
                            $fileName = basename($productImages["name"][$productNumber]);
                            $storeNumber = $_SESSION['store']['storeNumber']; // ここで正しい storeNumber を取得
                            $addedDate = date('Y-m-d H:i:s'); // 現在の日時を取得

                            $sql = "INSERT INTO images (storeNumber, imageHash, imageName, addedDate) VALUES (:storeNumber, :imageHash, :imageName, :addedDate)";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([
                                'storeNumber' => $storeNumber,
                                'imageHash' => $hashValue,
                                'imageName' => $fileName,
                                'addedDate' => $addedDate
                            ]);

                            // 保存された画像のIDを取得
                            $imageNumber = $pdo->lastInsertId();
                            echo "画像情報がデータベースに保存されました。画像ID: " . $imageNumber;
                        } else {
                            throw new Exception("画像アップロード中にエラーが発生しました。");
                        }
                    }
                } else {
                    throw new Exception("ファイルはアップロードされませんでした。");
                }
            }

            // 商品情報を更新するクエリの作成
            $sql = "UPDATE product 
                    SET productName = :productName, price = :price, dateAdded = :dateAdded, releaseDate = :releaseDate";
            if ($imageNumber !== null) {
                $sql .= ", imageNumber = :imageNumber";
            }
            if ($storeCategoryNumber !== null) {
                $sql .= ", storeCategoryNumber = :storeCategoryNumber";
            }
            if ($categoryNumber !== null) {
                $sql .= ", categoryNumber = :categoryNumber";
            }
            $sql .= " WHERE productNumber = :productNumber";

            $statement = $pdo->prepare($sql);
            $statement->bindParam(':productName', $productName, PDO::PARAM_STR);
            $statement->bindParam(':price', $price, PDO::PARAM_STR);
            $statement->bindParam(':dateAdded', $dateAdded, PDO::PARAM_STR);
            $statement->bindParam(':releaseDate', $releaseDate, PDO::PARAM_STR);
            $statement->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            if ($imageNumber !== null) {
                $statement->bindParam(':imageNumber', $imageNumber, PDO::PARAM_INT);
            }
            if ($storeCategoryNumber !== null) {
                $statement->bindParam(':storeCategoryNumber', $storeCategoryNumber, PDO::PARAM_INT);
            }
            if ($categoryNumber !== null) {
                $statement->bindParam(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
            }

            $statement->execute();
        }

        // トランザクションをコミット
        $pdo->commit();
        echo "更新が正常に完了しました。";

        header('Location: ../../taoka/productManagerMenu.php');
    } catch (Exception $e) {
        // エラーが発生した場合はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "更新中にエラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }

    // データベース接続を切断
    $utilConnDB->disconnect($pdo);
}
?>
