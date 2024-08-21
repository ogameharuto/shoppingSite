<?php
// セッション開始
session_start();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}

// データベース接続
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$store = $_SESSION['store'];
$storeNumber = $store['storeNumber'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];

    if ($imageError === 0) {
        $imageData = file_get_contents($imageTmpName);
        $imageHash = hash('sha256', $imageData);

        try {
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

            if ($imageExists) {
                $message = "この店舗で同じ画像がすでに登録されています。";
            } else {
                $uploadDir = 'uploads/';
                $uploadFile = $uploadDir . basename($imageName);

                if (move_uploaded_file($imageTmpName, $uploadFile)) {
                    $insertSql = "INSERT INTO images (storeNumber, imageName, imageHash, addedDate) VALUES (:storeNumber, :imageName, :imageHash, NOW())";
                    $insertStmt = $pdo->prepare($insertSql);
                    $insertStmt->execute([
                        ':storeNumber' => $storeNumber,
                        ':imageName' => $imageName,
                        ':imageHash' => $imageHash
                    ]);
                    $pdo->commit();
                    $message = "画像が正常にアップロードされました。";
                } else {
                    $message = "画像のアップロードに失敗しました。";
                }
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            $message = "エラーが発生しました: " . $e->getMessage();
        }
    } else {
        $message = "画像のアップロード中にエラーが発生しました。";
    }
}

// 画像の削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image_number'])) {
    $imageNumber = $_POST['delete_image_number'];

    try {
        if (!$pdo->inTransaction()) {
            $pdo->beginTransaction();
        }

        $selectImageSql = "SELECT imageName FROM images WHERE imageNumber = :imageNumber AND storeNumber = :storeNumber";
        $selectImageStmt = $pdo->prepare($selectImageSql);
        $selectImageStmt->execute([':imageNumber' => $imageNumber, ':storeNumber' => $storeNumber]);
        $image = $selectImageStmt->fetch(PDO::FETCH_ASSOC);

        if ($image) {
            $imageName = $image['imageName'];
            $deleteSql = "DELETE FROM images WHERE imageNumber = :imageNumber AND storeNumber = :storeNumber";
            $deleteStmt = $pdo->prepare($deleteSql);
            $deleteStmt->execute([':imageNumber' => $imageNumber, ':storeNumber' => $storeNumber]);

            $filePath = 'uploads/' . $imageName;
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $pdo->commit();
            $message = "画像が正常に削除されました。";
        } else {
            $message = "指定された画像が見つかりません。";
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        $message = "エラーが発生しました: " . $e->getMessage();
    }
}

// 画像の一覧を取得
$selectSql = "SELECT * FROM images WHERE storeNumber = :storeNumber ORDER BY addedDate DESC";
$selectStmt = $pdo->prepare($selectSql);
$selectStmt->execute([':storeNumber' => $storeNumber]);
$images = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像アップロードと一覧表示</title>
    <link rel="stylesheet" type="text/css" href="imageIns.css">
    <script type="text/javascript">
        <?php if ($message): ?>
        alert('<?php echo $message; ?>');
        <?php endif; ?>
    </script>
</head>
<body>
    <h1>画像をアップロードし、一覧表示する</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image">画像ファイル:</label>
        <input type="file" name="image" id="image" required>
        <input type="submit" name="submit" value="アップロード">
    </form>

    <h2>画像一覧</h2>
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>ファイル名</th>
                <th>画像</th>
                <th>追加日時</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($images) > 0): ?>
                <?php foreach ($images as $index => $image): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($image['imageName']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($image['imageName']); ?>" alt="<?php echo htmlspecialchars($image['imageName']); ?>"></td>
                    <td><?php echo htmlspecialchars($image['addedDate']); ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="delete_image_number" value="<?php echo $image['imageNumber']; ?>">
                            <input type="submit" value="削除">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">登録されている画像はありません。</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
