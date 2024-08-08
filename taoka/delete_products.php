<?php
session_start();

require_once ('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['products'])) {
    $productsToDelete = $_POST['products'];

    try {
        $sql = 'DELETE FROM product WHERE productNumber IN (' . implode(',', array_map('intval', $productsToDelete)) . ')';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        // コミット
        $pdo->commit();
        $_SESSION['message'] = "削除が完了しました。";
    } catch (Exception $e) {
        // ロールバック
        $pdo->rollBack();
        $_SESSION['error'] = "カテゴリの削除中にエラーが発生しました。";
    }
}

header('Location: productManagerMenu.php');
exit;
?>