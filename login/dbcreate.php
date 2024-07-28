<?php

/* インポート */
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();

/*
 * 会社情報（company_info）データベース作成
 */
$dbSW  = $utilConnDB->createDB();  // false:not create
/*
 * 会社情報（company_info）データベースに接続
 */
$pdo   = $utilConnDB->connect();   // null:not found

/*
 * 会社情報（company_info）テーブル作成
 */
/* 登録済みの確認 */
$sql    = "show tables like 'stores';";
$ret    = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
  if ($row[0] == 'stores') {
    $findSW = true;
  }
}
if ($findSW == true) {
  $sql   = 'drop table stores;';
  $count = $pdo->query($sql);
}
/* company_infoテーブル生成 */
$sql   = 'create table stores('
       . 'storeNumber INT NOT NULL AUTO_INCREMENT PRIMARY KEY, '  // 自動インクリメントに変更
       . 'companyName VARCHAR(50),' 
       . 'companyPostalCode VARCHAR(50),'
       . 'companyAddress VARCHAR(50),'
       . 'companyRepresentative VARCHAR(50),'
       . 'storeName VARCHAR(50), '
       . 'furigana VARCHAR(50), '
       . 'telephoneNumber VARCHAR(50),'
       . 'mailAddress VARCHAR(50),'
       . 'storeDescription VARCHAR(2000),'
       . 'storeImageURL VARCHAR(255),'
       . 'storeAdditionalInfo VARCHAR(2000),'
       . 'operationsManager VARCHAR(50), '
       . 'invoice_registration ENUM("registered", "not_registered") NOT NULL, '
       . 'contactAddress VARCHAR(50),'
       . 'contactPostalCode VARCHAR(50),'
       . 'contactPhoneNumber VARCHAR(50),'
       .'contactEmailAddress VARCHAR(50),'
       .'password VARCHAR(50)'
       . ');';
$count = $pdo->query($sql);

/* company_infoテーブルにデータ登録 */
insCompanyInfo($pdo);

/* 登録データを確定する */
$pdo->commit();

/*
 * DBを切断する
 */
$stmt  = null;
$pdo   = null;

/*
 * company_infoテーブルにデータ登録
 */
function insCompanyInfo($pdo) {
    $sql   = "insert into stores (companyName, companyPostalCode, companyAddress, companyRepresentative, 
    storeName, furigana, telephoneNumber, mailAddress, storeDescription, 
    storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, 
    contactPhoneNumber, contactEmailAddress, password) "
    
           . "values ('Sample Company', '123-4567', '123 Sample Street, City', 'John Doe', 
           'Sample Store', 'サンプル ストア', '123-456-7890', 'sample@example.com', 'This is a sample store description.', 
           'http://example.com/image.jpg', 'Additional information about the store.', 'Jane Smith', '123 Contact Street, City', '234-5678', 
           '234-567-8901', 'contact@example.com', 'password123'),
          ('Another Company', '234-5678', '456 Another Street, City', 'Alice Johnson', 
           'Another Store', 'アナザー ストア', '234-567-8901', 'another@example.com', 'Description for another store.', 
           'http://example.com/another_image.jpg', 'Additional info about another store.', 'Bob Brown', '456 Contact Street, City', '345-6789', 
           '345-678-9012', 'another_contact@example.com', 'password456');";
    $count = sql_exec($pdo, $sql);
}

/*
 * SQL文実行
 */
function sql_exec($pdo, $sql) {
    $count = $pdo->exec($sql);

    return $count;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <title>データベース初期化</title>
</head>
<body>
<h2>会社情報データベース初期化</h2>
<p>会社情報データベースを初期化しました。</p>
<form name="myForm1" action="index.html" method="post">
  <input type="submit" value="戻る" />
</form>
</body>
</html>
