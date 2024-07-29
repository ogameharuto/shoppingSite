<?php
/*
 dbCreate.php（データベース初期化）

 @author  田岡勇大
 @version 2.0
 @date    6月10日
*/

/* インポート */
require_once('utilConnDB.php');
$utilConnDB = new UtilConnDB();

/*
 * データベース作成
 */
$dbSW  = $utilConnDB->createDB();  // false:not create
/*
 * データベースに接続
 */
$pdo   = $utilConnDB->connect();   // null:not found

/*
 * 外部キー制約を一時的に無効にする
 */
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

/*
 * テーブルを削除する関数
 */
function dropTableIfExists($pdo, $tableName) {
    $sql = "SHOW TABLES LIKE '$tableName';";
    $ret = $pdo->query($sql);
    if ($ret->fetch(PDO::FETCH_NUM)) {
        $sql = "DROP TABLE $tableName;";
        $pdo->exec($sql);
    }
}

/*
 * テーブルを削除
 */
$tables = [
    'review',
    'cart',
    'orderDetail',
    'orderTable',
    'product',
    'dateAndTimeSettings',
    'store',
    'customer',
    'category'
];

foreach ($tables as $table) {
    dropTableIfExists($pdo, $table);
}

/*
 * 外部キー制約を再度有効にする
 */
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1;');

/*
 * カテゴリテーブル作成
 */
$sql = 'CREATE TABLE category (
  categoryNumber INT AUTO_INCREMENT PRIMARY KEY,
  categoryName VARCHAR(50),
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * 顧客テーブル作成
 */
$sql = 'CREATE TABLE customer (
  customerNumber INT AUTO_INCREMENT PRIMARY KEY,
  customerName VARCHAR(50),
  furigana VARCHAR(50),
  address VARCHAR(100),
  postCode VARCHAR(10),
  dateOfBirth DATE,
  mailAddress VARCHAR(50) UNIQUE,
  telephoneNumber VARCHAR(20),
  password VARCHAR(50)
);';
$pdo->exec($sql);

/*
 * 店舗テーブル作成
 */
$sql = 'CREATE TABLE store (
  storeNumber INT AUTO_INCREMENT PRIMARY KEY,
  companyName VARCHAR(50),
  companyPostalCode VARCHAR(10),
  companyAddress VARCHAR(100),
  companyRepresentative VARCHAR(50),
  storeName VARCHAR(50),
  furigana VARCHAR(50),
  telephoneNumber VARCHAR(20),
  mailAddress VARCHAR(50),
  storeDescription VARCHAR(2000),
  storeImageURL VARCHAR(255),
  storeAdditionalInfo VARCHAR(2000),
  operationsManager VARCHAR(50),
  contactAddress VARCHAR(100),
  contactPostalCode VARCHAR(10),
  contactPhoneNumber VARCHAR(20),
  contactEmailAddress VARCHAR(50),
  password VARCHAR(50)
);';
$pdo->exec($sql);

/*
 * 商品テーブル作成
 */
$sql = 'CREATE TABLE product (
  productNumber INT AUTO_INCREMENT PRIMARY KEY,
  productName VARCHAR(50),
  productImageURL VARCHAR(255),
  price DECIMAL(10, 2),
  categoryNumber INT,
  stockQuantity INT,
  productDescription VARCHAR(500),
  dateAdded DATE,
  releaseDate DATE,
  storeNumber INT,
  pageDisplayStatus BOOLEAN,
  FOREIGN KEY (categoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * 注文テーブル作成
 */
$sql = 'CREATE TABLE orderTable (
  orderNumber INT AUTO_INCREMENT PRIMARY KEY,
  customerNumber INT,
  orderDateTime DATETIME,
  orderStatus VARCHAR(50),
  deliveryAddress VARCHAR(100),
  paymentMethodStatus VARCHAR(50),
  billingName VARCHAR(50),
  billingAddress VARCHAR(100),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * 注文詳細テーブル作成
 */
$sql = 'CREATE TABLE orderDetail (
  orderDetailNumber INT AUTO_INCREMENT PRIMARY KEY,
  orderNumber INT,
  productNumber INT,
  quantity INT,
  price DECIMAL(10, 2),
  FOREIGN KEY (orderNumber) REFERENCES orderTable(orderNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * カートテーブル作成
 */
$sql = 'CREATE TABLE cart (
  customerNumber INT,
  productNumber INT,
  quantity INT,
  dateAdded DATETIME,
  PRIMARY KEY (customerNumber, productNumber),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * お問い合わせ対応日時設定番号テーブル作成
 */
$sql = 'CREATE TABLE dateAndTimeSettings (
  dateAndTimeSettingsNumber INT AUTO_INCREMENT PRIMARY KEY,
  storeNumber INT,
  businessStartDate DATE,
  businessEndDate DATE,
  supportStartTime TIME,
  supportEndTime TIME,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * レビューテーブル作成
 */
$sql = 'CREATE TABLE review (
  reviewNumber INT AUTO_INCREMENT PRIMARY KEY,
  customerNumber INT,
  productNumber INT,
  reviewText VARCHAR(300),
  purchaseFlag BOOLEAN,
  evaluation VARCHAR(10),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

/*
 * SQL文実行
 */
function sql_exec($pdo, $sql) {
    $count = $pdo->exec($sql);

    return $count;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
</head>
<body>

<form name="myForm1" action="index.php" method="post">
  <h2>実習No.3 データベース初期化（デバッグ用）</h2>
  データベースを初期化しました。<p />
  <input type="submit" value="戻る" />
</form>
</body>
</html>