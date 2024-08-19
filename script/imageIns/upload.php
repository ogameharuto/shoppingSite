<?php
session_start();
require_once('../utilConnDB.php');

$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect(); // トランザクション開始

// フォームからの入力を取得
$storeNumber = (int)$_POST['storeNumber'];
$productNumber = (int)$_POST['productNumber'];

try {
    // すでに同じ productNumber に関連する画像が存在するか確認
    $sql = 'SELECT COUNT(*) FROM images WHERE productNumber = :productNumber';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count > 0) {
        echo 'この productNumber にはすでに画像が登録されています。';
    } else {
        // ファイルのアップロード処理
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            
            // 許可されたファイル拡張子
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array($fileExtension, $allowedExtensions)) {
                // アップロードファイルをサーバーに保存するディレクトリ
                $uploadDir = './uploads/';
                $dest_path = $uploadDir . $fileName;
                
                // 画像を指定ディレクトリに移動
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // 画像のハッシュ値を生成
                    $imageHash = hash_file('md5', $dest_path);
                    
                    // 画像名をファイル名に設定
                    $imageName = $fileName;

                    // データベースに画像情報を挿入
                    $sql = 'INSERT INTO images (imageHash, imageName, addedDate, storeNumber, productNumber) 
                            VALUES (:imageHash, :imageName, NOW(), :storeNumber, :productNumber)';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':imageHash', $imageHash);
                    $stmt->bindParam(':imageName', $imageName);
                    $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
                    $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);

                    // SQL実行
                    if ($stmt->execute()) {
                        // コミット
                        $utilConnDB->commit($pdo);
                        echo '画像がアップロードされ、データベースに登録されました。';
                    } else {
                        // エラー時にロールバック
                        $utilConnDB->rollback($pdo);
                        echo 'データベースへの登録に失敗しました。';
                    }
                } else {
                    echo 'ファイルのアップロードに失敗しました。';
                }
            } else {
                echo '許可されていないファイルタイプです。';
            }
        } else {
            echo 'ファイルのアップロードエラー: ' . $_FILES['image']['error'];
        }
    }
} catch (PDOException $e) {
    // エラー時にロールバック
    $utilConnDB->rollback($pdo);
    echo 'SQLエラー: ' . $e->getMessage();
}

// 接続の切断
$utilConnDB->disconnect($pdo);
?>
