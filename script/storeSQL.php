<?php

header('Content-Type:text/plain; charset=utf-8');

class StoreSQL{

    /* 店舗表から指定した店舗情報を取得する
    　店舗データを配列に登録して戻す
    @param  $pdo　データベース接続オブジェクト
    @param  $loginData ログイン情報
    @return  $store  検索結果
    */
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
    
    

    /*
    店舗表に店舗情報を登録する
    @param  $pdo  データベース接続オブジェクト
    @param  $storeData　店舗登録情報
    @return int 登録件数
    */
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
    public function aa($pdo, $selectedProductNumbers){
        // 選択された商品データを取得するクエリ
        $sql = "SELECT productNumber AS productNumber, productName AS productName, stockQuantity AS stock 
        FROM product 
        WHERE productNumber IN (" . implode(',', array_fill(0, count($selectedProductNumbers), '?')) . ")";
        $statement = $pdo->prepare($sql);
        $statement->execute($selectedProductNumbers);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $products;
    }
}
?>
