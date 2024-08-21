<?php

header('Content-Type:text/plain; charset=utf-8');

require_once('../utilConnDB.php'); // データベース接続の設定を含むファイル

$utilConnDB = new UtilConnDB();

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
?>
