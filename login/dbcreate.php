<?php
/*
 companyDBCreate.php（データベース初期化）

 @author  大亀陽斗
 @version 1.0
 @date    2024/07/25
*/

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
$sql    = "show tables like 'company_info';";
$ret    = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
  if ($row[0] == 'company_info') {
    $findSW = true;
  }
}
if ($findSW == true) {
  $sql   = 'drop table company_info;';
  $count = $pdo->query($sql);
}
/* company_infoテーブル生成 */
$sql   = 'create table company_info('
       . 'id INT AUTO_INCREMENT PRIMARY KEY, '
       . 'business_type VARCHAR(255) NOT NULL, '
       . 'company_type VARCHAR(255) NOT NULL, '
       . 'corporate_number VARCHAR(13), '
       . 'company_name VARCHAR(255) NOT NULL, '
       . 'postal_code VARCHAR(10) NOT NULL, '
       . 'prefecture VARCHAR(255) NOT NULL, '
       . 'city VARCHAR(255) NOT NULL, '
       . 'town VARCHAR(255) NOT NULL, '
       . 'street_address VARCHAR(255) NOT NULL, '
       . 'building_name VARCHAR(255), '
       . 'phone_number VARCHAR(20) NOT NULL, '
       . 'invoice_registration ENUM("registered", "not_registered") NOT NULL, '
       . 'establishment_date DATE NOT NULL, '
       . 'capital INT NOT NULL, '
       . 'revenue INT'
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
    $sql   = "insert into company_info (business_type, company_type, corporate_number, company_name, postal_code, prefecture, city, town, street_address, building_name,phone_number, invoice_registration, establishment_date, capital, revenue) "
           . "values ('株式会社', '法人', '1234567890123', 'サンプル株式会社', '100-0001', '東京都', '千代田区', '神田', '1-1', 'サンプルビル', '03-1234-5678', 'registered', '2024-01-01', 1000000, 5000000);";
    $count = sql_exec($pdo, $sql);

    $sql   = "insert into company_info (business_type, company_type, corporate_number, company_name, postal_code, prefecture, city, town, street_address, building_name, phone_number, invoice_registration, establishment_date, capital, revenue) "
           . "values ('株式会社', '法人', '0987654321098', 'テスト株式会社', '150-0001', '東京都', '渋谷区', '宇田川町', '2-2', 'テストビル','03-9876-5432', 'not_registered', '2023-06-15', 2000000, 10000000);";
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