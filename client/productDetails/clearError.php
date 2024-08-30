<?php
session_start();

// JSONレスポンス用のヘッダー設定
header('Content-Type: application/json');

// アクションが `clearError` であればエラーをクリア
$request = json_decode(file_get_contents('php://input'), true);
if (isset($request['action']) && $request['action'] === 'clearError') {
    unset($_SESSION['error']);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>
