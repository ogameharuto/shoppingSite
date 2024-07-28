<?php

header('Content-Type:text/plain; charset=utf-8');

class StoreSQL{
    /*
    店舗表からすべての店舗情報を取得する
    店舗データを配列に登録して表す

    @param $pdo   データベース接続オブジェクト
    @return $storeList 店舗データ
    */
    public function selectAll($pdo){
        $storeList = array();

        // SQL文生成
        $sql = 'SELECT * FROM stores ORDER BY storeNumber ASC';
        $stmt = $pdo->prepare($sql);

        // SQL文実行
        $stmt->execute();

        // 検索結果を配列に登録
        foreach($stmt as $row){
            $storeList[] = $row;
        }

        return $storeList;
    }

    /* 店舗表から指定した店舗情報を取得する
    　店舗データを配列に登録して戻す
    @param  $pdo　データベース接続オブジェクト
    @param  $storeNumber 店舗番号
    @return  $store  検索結果
    */
    public function select($pdo, $storeNumber){
        // SQL文生成
        $sql = 'SELECT * FROM stores WHERE storeNumber=?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $storeNumber, PDO::PARAM_STR);

        // SQL文実行
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
        $sql = 'INSERT INTO stores (
                    storeNumber, companyName, companyPostalCode, companyAddress, 
                    companyRepresentative, storeName, furigana, telephoneNumber, 
                    mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, 
                    operationsManager, invoice_registration, contactAddress, 
                    contactPostalCode, contactPhoneNumber, contactEmailAddress, password
                ) VALUES (
                    :storeNumber, :companyName, :companyPostalCode, :companyAddress, 
                    :companyRepresentative, :storeName, :furigana, :telephoneNumber, 
                    :mailAddress, :storeDescription, :storeImageURL, :storeAdditionalInfo, 
                    :operationsManager, :invoice_registration, :contactAddress, 
                    :contactPostalCode, :contactPhoneNumber, :contactEmailAddress, :password
                )';
        $stmt = $pdo->prepare($sql);
    
        // 各プレースホルダーに対応する値をバインド
        $stmt->bindValue(':storeNumber', $storeData->getStoreNumber(), PDO::PARAM_STR);
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
        $stmt->bindValue(':invoice_registration', $storeData->getInvoiceRegistration(), PDO::PARAM_STR);
        $stmt->bindValue(':contactAddress', $storeData->getContactAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':contactPostalCode', $storeData->getContactPostalCode(), PDO::PARAM_STR);
        $stmt->bindValue(':contactPhoneNumber', $storeData->getContactPhoneNumber(), PDO::PARAM_STR);
        $stmt->bindValue(':contactEmailAddress', $storeData->getContactEmailAddress(), PDO::PARAM_STR);
        $stmt->bindValue(':password', $storeData->getPassword(), PDO::PARAM_STR);
    
        // SQL文実行
        try {
            $stmt->execute();
            $recCount = $stmt->rowCount();
            if ($recCount > 0) {
                echo "データが正常に登録されました。";
            } else {
                echo "データの登録に失敗しました。";
            }
        } catch(PDOException $e) {
            echo "エラー: " . $e->getMessage();
        }
    
        return $recCount;
    }
    
    
    

    /*
    店舗表の店舗情報を更新する
    @param  $pdo  データベース接続オブジェクト
    @param  $storeData  店舗更新情報
    @return 更新件数
    */
    public function update($pdo, $storeData){
        $recCount = 0;

        // SQL文生成
        $sql = 'UPDATE stores SET 
                    companyName=:companyName, companyPostalCode=:companyPostalCode, 
                    companyAddress=:companyAddress, companyRepresentative=:companyRepresentative, 
                    storeName=:storeName, furigana=:furigana, telephoneNumber=:telephoneNumber, 
                    mailAddress=:mailAddress, storeDescription=:storeDescription, 
                    storeImageURL=:storeImageURL, storeAdditionalInfo=:storeAdditionalInfo, 
                    operationsManager=:operationsManager, invoice_registration=:invoice_registration, 
                    contactAddress=:contactAddress, contactPostalCode=:contactPostalCode, 
                    contactPhoneNumber=:contactPhoneNumber, contactEmailAddress=:contactEmailAddress, 
                    password=:password
                WHERE storeNumber=:storeNumber';
        $stmt = $pdo->prepare($sql);

        // SQL文実行
        try {
            $stmt->execute($storeData);
            $recCount = $stmt->rowCount();
        } catch(PDOException $e){
            echo "エラー: " . $e->getMessage();
        }

        return $recCount;
    }

    /*
    店舗表の店舗情報を削除する
    @param  $pdo  データベース接続オブジェクト
    @param  $storeNumber 店舗削除情報
    @return 削除件数
    */
    public function delete($pdo, $storeNumber){
        $recCount = 0;

        // SQL文生成
        $sql = 'DELETE FROM stores WHERE storeNumber=?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $storeNumber, PDO::PARAM_STR);

        // SQL文実行
        try {
            $stmt->execute();
            $recCount = $stmt->rowCount();
        } catch(PDOException $e){
            echo "エラー: " . $e->getMessage();
        }

        return $recCount;
    }
}
?>
