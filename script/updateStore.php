<?php
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

try {
    // Ensure we only begin a transaction if one is not already in progress
    if (!$pdo->inTransaction()) {
        $pdo->beginTransaction();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $storeNumber = filter_input(INPUT_POST, 'storeNumber', FILTER_VALIDATE_INT);
        $companyName = filter_input(INPUT_POST, 'companyName', FILTER_SANITIZE_STRING);
        $companyPostalCode = filter_input(INPUT_POST, 'companyPostalCode', FILTER_SANITIZE_STRING);
        $companyAddress = filter_input(INPUT_POST, 'companyAddress', FILTER_SANITIZE_STRING);
        $companyRepresentative = filter_input(INPUT_POST, 'companyRepresentative', FILTER_SANITIZE_STRING);
        $storeName = filter_input(INPUT_POST, 'storeName', FILTER_SANITIZE_STRING);
        $furigana = filter_input(INPUT_POST, 'furigana', FILTER_SANITIZE_STRING);
        $telephoneNumber = filter_input(INPUT_POST, 'telephoneNumber', FILTER_SANITIZE_STRING);
        $mailAddress = filter_input(INPUT_POST, 'mailAddress', FILTER_SANITIZE_EMAIL);
        $storeDescription = filter_input(INPUT_POST, 'storeDescription', FILTER_SANITIZE_STRING);
        $storeAdditionalInfo = filter_input(INPUT_POST, 'storeAdditionalInfo', FILTER_SANITIZE_STRING);
        $operationsManager = filter_input(INPUT_POST, 'operationsManager', FILTER_SANITIZE_STRING);
        $contactAddress = filter_input(INPUT_POST, 'contactAddress', FILTER_SANITIZE_STRING);
        $contactPostalCode = filter_input(INPUT_POST, 'contactPostalCode', FILTER_SANITIZE_STRING);
        $contactPhoneNumber = filter_input(INPUT_POST, 'contactPhoneNumber', FILTER_SANITIZE_STRING);
        $contactEmailAddress = filter_input(INPUT_POST, 'contactEmailAddress', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Handle file upload
        $storeImageURL = '';
        if (isset($_FILES['storeImage']) && $_FILES['storeImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . basename($_FILES['storeImage']['name']);
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            // Validate file type
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['storeImage']['tmp_name'], $uploadFile)) {
                    $storeImageURL = $uploadFile;
                } else {
                    throw new Exception('画像のアップロードに失敗しました。');
                }
            } else {
                throw new Exception('無効なファイルタイプです。');
            }
        } else {
            // Retrieve the existing image URL if no new image is uploaded
            $stmt = $pdo->prepare('SELECT storeImageURL FROM store WHERE storeNumber = :storeNumber');
            $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $storeImageURL = $result['storeImageURL'];
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Update store information
        $stmt = $pdo->prepare('UPDATE store SET companyName = :companyName, companyPostalCode = :companyPostalCode, companyAddress = :companyAddress, companyRepresentative = :companyRepresentative, storeName = :storeName, furigana = :furigana, telephoneNumber = :telephoneNumber, mailAddress = :mailAddress, storeDescription = :storeDescription, storeImageURL = :storeImageURL, storeAdditionalInfo = :storeAdditionalInfo, operationsManager = :operationsManager, contactAddress = :contactAddress, contactPostalCode = :contactPostalCode, contactPhoneNumber = :contactPhoneNumber, contactEmailAddress = :contactEmailAddress, password = :password WHERE storeNumber = :storeNumber');

        $stmt->bindParam(':companyName', $companyName, PDO::PARAM_STR);
        $stmt->bindParam(':companyPostalCode', $companyPostalCode, PDO::PARAM_STR);
        $stmt->bindParam(':companyAddress', $companyAddress, PDO::PARAM_STR);
        $stmt->bindParam(':companyRepresentative', $companyRepresentative, PDO::PARAM_STR);
        $stmt->bindParam(':storeName', $storeName, PDO::PARAM_STR);
        $stmt->bindParam(':furigana', $furigana, PDO::PARAM_STR);
        $stmt->bindParam(':telephoneNumber', $telephoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':mailAddress', $mailAddress, PDO::PARAM_STR);
        $stmt->bindParam(':storeDescription', $storeDescription, PDO::PARAM_STR);
        $stmt->bindParam(':storeImageURL', $storeImageURL, PDO::PARAM_STR);
        $stmt->bindParam(':storeAdditionalInfo', $storeAdditionalInfo, PDO::PARAM_STR);
        $stmt->bindParam(':operationsManager', $operationsManager, PDO::PARAM_STR);
        $stmt->bindParam(':contactAddress', $contactAddress, PDO::PARAM_STR);
        $stmt->bindParam(':contactPostalCode', $contactPostalCode, PDO::PARAM_STR);
        $stmt->bindParam(':contactPhoneNumber', $contactPhoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':contactEmailAddress', $contactEmailAddress, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();
        echo '更新が成功しました。<br><a href="editStore.php?storeNumber=' . htmlspecialchars($storeNumber, ENT_QUOTES, 'UTF-8') . '">戻る</a>';
    }
} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo 'エラー: ' . $e->getMessage();
} catch (Exception $e) {
    // Rollback transaction on other errors
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo 'エラー: ' . $e->getMessage();
}
?>
