<?php

header('Content-Type:text/plain; charset=utf-8');

class StoreSQL{

    //顧客ごとにカートテーブル参照
    public function selectCartItems($pdo, $customerNumber) {
        // SQL文生成
        $sql = 'SELECT 
                    p.productName,
                    p.productImageURL,
                    p.price,
                    c.quantity,
                    p.productDescription
                FROM cart c
                JOIN product p ON c.productNumber = p.productNumber
                WHERE c.customerNumber = :customerNumber';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':customerNumber', $customerNumber, PDO::PARAM_INT);
        
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $cartItems;
    }

    //ストア側のログイン
    public function select($pdo, $loginData) {
        // SQL文生成
        $sql = 'SELECT * FROM store WHERE mailAddress = :email AND password = :password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $loginData->getMailAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $loginData->getPassword(), PDO::PARAM_STR);
        
        $stmt->execute();
        $store = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $store;
    }

    //顧客側のログイン
    public function LogSelect($pdo, $loginData){
        $sql = 'SELECT * FROM customer WHERE mailAddress = :email AND password = :password';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $loginData->getMailAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $loginData->getPassword(), PDO::PARAM_STR);
        
        $stmt->execute();
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $customer;
    }
    
    //ストアテーブルに登録
    public function insert($pdo, $storeData) {
        $recCount = 0;
    
        // SQL文生成
        $sql = 'INSERT INTO store (
                    companyName, companyPostalCode, companyAddress, companyRepresentative, storeName, furigana, telephoneNumber, 
                    mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, 
                    contactPhoneNumber, contactEmailAddress, password
                ) VALUES (
                    :companyName, :companyPostalCode, :companyAddress, 
                    :companyRepresentative, :storeName, :furigana, :telephoneNumber, 
                    :mailAddress, :storeDescription, :storeImageURL, :storeAdditionalInfo, 
                    :operationsManager, :contactAddress, 
                    :contactPostalCode, :contactPhoneNumber, :contactEmailAddress, :password
                )';
        $stmt = $pdo->prepare($sql);
    
        // 各プレースホルダーに対応する値をバインド
        $stmt->bindValue(':companyName', $storeData->getCompanyName(), PDO::PARAM_STR);
        $stmt->bindValue(':companyPostalCode', $storeData->getCompanyPostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':companyAddress', $storeData->getCompanyAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':companyRepresentative', $storeData->getCompanyRepresentative(), PDO::PARAM_STR);
        $stmt->bindValue(':storeName', $storeData->getStoreName(), PDO::PARAM_STR);
        $stmt->bindValue(':furigana', $storeData->getFurigana(), PDO::PARAM_STR);
        $stmt->bindValue(':telephoneNumber', $storeData->getTelephoneNumber(), PDO::PARAM_STR);
        $stmt->bindValue(':mailAddress', $storeData->getMailAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':storeDescription', $storeData->getStoreDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':storeImageURL', $storeData->getStoreImageURL(), PDO::PARAM_STR);
        $stmt->bindValue(':storeAdditionalInfo', $storeData->getStoreAdditionalInfo(), PDO::PARAM_STR);
        $stmt->bindValue(':operationsManager', $storeData->getOperationsManager(), PDO::PARAM_STR);
        $stmt->bindValue(':contactAddress', $storeData->getContactAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':contactPostalCode', $storeData->getContactPostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':contactPhoneNumber', $storeData->getContactPhoneNumber(), PDO::PARAM_STR);
        $stmt->bindValue(':contactEmailAddress', $storeData->getContactEmailAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $storeData->getPassword(), PDO::PARAM_STR);
    
        // SQL文実行
        try {
            /* SQL文実行 */
            $ret = $stmt->execute();

            /* 件数を取得 */
            $recCount = $stmt->rowCount();
        } catch(PDOException $e){}
    
        return $recCount;
    }

    // 選択された商品データを取得する
    public function productEditSelect($pdo, $selectedProductNumbers){
        $sql = "SELECT productNumber AS productNumber, productName AS productName, stockQuantity AS stock 
        FROM product 
        WHERE productNumber IN (" . implode(',', array_fill(0, count($selectedProductNumbers), '?')) . ")";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($selectedProductNumbers);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    //商品の情報更新
    public function productUpdSelect($pdo, $selectedProductNumbers){
        $sql = "SELECT productNumber AS productNumber, productImageURL AS productImageURL, productName AS productName, price AS price, dateAdded AS dateAdded, releaseDate AS releaseDate
        FROM product 
        WHERE productNumber IN (" . implode(',', array_fill(0, count($selectedProductNumbers), '?')) . ")";
        $statement = $pdo->prepare($sql);
        $statement->execute($selectedProductNumbers);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }

    // 顧客番号に基づいて商品データを取得
    public function productSelect($pdo, $storeNumber){
        $sql = "SELECT productNumber, productName, categoryNumber, stockQuantity, pageDisplayStatus 
                FROM product 
                WHERE storeNumber = :storeNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':storeNumber', $storeNumber, PDO::PARAM_INT);
        $stmt->execute();
    
        // 結果を取得
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // カテゴリ情報を取得
    public function categorySelect($pdo){
        $sql = "SELECT categoryNumber, categoryName FROM category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        // 結果を取得
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 商品検索
    public function searchProducts($pdo, $searchTerm) {
        $sql = "SELECT p.*, s.storeName FROM product p 
                JOIN store s ON p.storeNumber = s.storeNumber 
                WHERE p.productName LIKE :searchTerm";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 類似商品検索
    public function findSimilarProducts($pdo, $categoryNumber, $searchTerm) {
        $sql = "SELECT p.*, c.categoryName FROM product p 
                JOIN category c ON p.storeNumber = c.categoryNumber 
                WHERE p.categoryNumber = :categoryNumber 
                AND p.productName LIKE :searchTerm";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':categoryNumber', $categoryNumber, PDO::PARAM_INT);
        $stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // 商品番号からストア情報を取得
    public function getStoreByProductNumber($pdo, $productNumber) {
        $sql = "
            SELECT store.*
            FROM store
            JOIN product ON store.storeNumber = product.storeNumber
            WHERE product.productNumber = :productNumber
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // カテゴリデータを取得
    public function getCategories($pdo) {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 商品データを取得
    public function getProductByNumber($pdo, $productNumber) {
        $sql = "SELECT * FROM product WHERE productNumber = :productNumber";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // レビューデータを取得
    public function getReviewsByProductNumber($pdo, $productNumber) {
        $sql = "
            SELECT review.*, customer.customerName 
            FROM review 
            JOIN customer ON review.customerNumber = customer.customerNumber 
            WHERE review.productNumber = :productNumber 
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // カテゴリ表示
    public function displayCategoryTree($categories, $categoryNumber) {
        $html = '';
        $currentCategory = null;

        // 現在のカテゴリを取得
        foreach ($categories as $category) {
            if ($category['categoryNumber'] == $categoryNumber) {
                $currentCategory = $category;
                break;
            }
        }

        if ($currentCategory) {
            // 親カテゴリがある場合は再帰的に表示
            if ($currentCategory['parentCategoryNumber'] != 0) {
                $html .= $this->displayCategoryTree($categories, $currentCategory['parentCategoryNumber']);
                $html .= '>';
            }

            // 現在のカテゴリを表示
            $html .= htmlspecialchars($currentCategory['categoryName'], ENT_QUOTES, 'UTF-8');
        }
        return $html;
    }

    // カートテーブルに同じのがあるかチェック
    public function getCartItem($pdo, $customerNumber, $productNumber){
            $stmt = $pdo->prepare("SELECT * FROM cart WHERE customerNumber = :customerNumber AND productNumber = :productNumber");
            $stmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
            $stmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            $stmt->execute();
            return $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 既存のアイテムがある場合は数量を更新
    public function updateCartItemQuantity($pdo, $newQuantity, $customerNumber, $productNumber){
            $updateStmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE customerNumber = :customerNumber AND productNumber = :productNumber");
            $updateStmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
            $updateStmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
            $updateStmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            return $updateStmt->execute();
    }
    
    // 新規アイテムを追加
    public function insertCartItem($pdo, $customerNumber, $productNumber, $quantity){
            $insertStmt = $pdo->prepare("INSERT INTO cart (customerNumber, productNumber, quantity) VALUES (:customerNumber, :productNumber, :quantity)");
            $insertStmt->bindParam(':customerNumber', $customerNumber, PDO::PARAM_INT);
            $insertStmt->bindParam(':productNumber', $productNumber, PDO::PARAM_INT);
            $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            return $insertStmt->execute();
    }
}
?>
