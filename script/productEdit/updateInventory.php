<?php
session_start();

// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$targetDir = "../uploads/"; // アップロードするディレクトリ
$targetFile = $targetDir . basename($_FILES["image"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// ディレクトリが存在しない場合は作成
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true); // 0777 はフルアクセス権限を意味します
}

// 画像ファイルが実際の画像か確認
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        echo "ファイルは画像です - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "ファイルは画像ではありません。";
        $uploadOk = 0;
    }
}

// ファイルサイズを確認
if ($_FILES["image"]["size"] > 500000) { // 500KBの制限
    echo "ファイルが大きすぎます。";
    $uploadOk = 0;
}

// 許可するファイル形式を確認
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "JPG, JPEG, PNG & GIF のみ許可されています。";
    $uploadOk = 0;
}

// エラーがない場合、ファイルをアップロード
if ($uploadOk == 0) {
    echo "ファイルはアップロードされませんでした。";
} else {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        echo "ファイル " . htmlspecialchars(basename($_FILES["image"]["name"])) . " がアップロードされました。";
        
        // ファイルのハッシュ値を計算
        $hashValue = hash_file('sha256', $targetFile);

        // データベース接続とトランザクション開始
        try {
            $pdo = $utilConnDB->connect();
            
            // データベースへの保存
            $fileName = basename($_FILES["image"]["name"]);
            $sql = "INSERT INTO images (file_name, hash_name) VALUES (:file_name, :hash_name)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['file_name' => $fileName, 'hash_name' => $hashValue]);

            // トランザクションをコミット
            $utilConnDB->commit($pdo); 
            echo "ファイル " . htmlspecialchars($fileName) . " がデータベースに保存されました。";
        } catch (PDOException $e) {
            // エラーが発生した場合、ロールバック
            $utilConnDB->rollback($pdo);
            echo "データベースエラー: " . $e->getMessage();
        } finally {
            // データベース接続を切断
            $utilConnDB->disconnect($pdo);
        }
    } else {
        echo "ファイルのアップロード中にエラーが発生しました。";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POST データを取得
    $productImage = $_FILES['productImage'] ?? [];
    $productNames = $_POST['productName'] ?? [];
    $specialPrices = $_POST['price'] ?? [];
    $startDates = $_POST['dateAdded'] ?? [];
    $endDates = $_POST['releaseDate'] ?? [];

    // データ検証（例: 特価は数値である必要があります）
    foreach ($specialPrices as $productNumber => $price) {
        if (!is_numeric($price)) {
            echo "特価は数値である必要があります。";
            exit;
        }
    }

    // トランザクションを開始
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    try {
        foreach ($productNames as $productNumber => $productName) {
            $price = $specialPrices[$productNumber] ?? null;
            $dateAdded = $startDates[$productNumber] ?? null;
            $releaseDate = $endDates[$productNumber] ?? null;

            // 商品情報を更新するクエリ
            $sql = "UPDATE product 
                    SET productName = :productName, price = :price, dateAdded = :dateAdded, releaseDate = :releaseDate, imageNumber = :imageNumber
                    WHERE productNumber = :productNumber";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(':productName', $productName, PDO::PARAM_STR);
            $statement->bindParam(':price', $price, PDO::PARAM_STR); // 特価が浮動小数点数の場合
            $statement->bindParam(':dateAdded', $dateAdded, PDO::PARAM_STR);
            $statement->bindParam(':releaseDate', $releaseDate, PDO::PARAM_STR);
            $statement->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            $statement->execute();

            // SQLエラーの確認
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != PDO::ERR_NONE) {
                throw new PDOException($errorInfo[2]);
            }
        }

        // トランザクションをコミット
        $pdo->commit();

        // 成功後のリダイレクト
        header('Location: ../../taoka/productManagerMenu.php');
        exit;

    } catch (PDOException $e) {
        // エラーが発生した場合はロールバック
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        // エラーメッセージの表示
        echo "更新中にエラーが発生しました: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
}
?>
