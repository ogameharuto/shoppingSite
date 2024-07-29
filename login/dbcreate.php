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
 * テーブル作成およびデータ挿入
 */

// カテゴリテーブル作成
$sql = 'CREATE TABLE category (
  categoryNumber INT AUTO_INCREMENT PRIMARY KEY,
  categoryName VARCHAR(50),
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// カテゴリデータ挿入
$sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES
  ('Electronics', NULL),
  ('Books', NULL),
  ('Smartphones', 1),
  ('Laptops', 1);";
$pdo->exec($sql);

// 顧客テーブル作成
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

// 顧客データ挿入
$sql = "INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) VALUES
  ('山田 太郎', 'ヤマダ タロウ', '東京都千代田区', '1000001', '1980-01-01', 'yamada@example.com', '09012345678', 'password123'),
  ('佐藤 花子', 'サトウ ハナコ', '大阪府大阪市', '5400001', '1990-05-05', 'sato@example.com', '08098765432', 'password456');";
$pdo->exec($sql);

// 店舗テーブル作成
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

// 店舗データ挿入
$sql = "INSERT INTO store (companyName, companyPostalCode, companyAddress, companyRepresentative, storeName, furigana, telephoneNumber, mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, contactPhoneNumber, contactEmailAddress, password) VALUES
  ('株式会社ストアA', '1000001', '東京都千代田区', '田中 一郎', 'ストアA', 'ストア エー', '0355556666', 'storea@example.com', '電子機器とガジェット', 'https://example.com/storea.jpg', '営業時間: 9:00 - 18:00', '田中 一郎', '東京都千代田区', '1000001', '0355556666', 'contacta@example.com', 'password789'),
  ('株式会社ストアB', '5400001', '大阪府大阪市', '鈴木 二郎', 'ストアB', 'ストア ビー', '0677778888', 'storeb@example.com', '書籍と文房具', 'https://example.com/storeb.jpg', '営業時間: 10:00 - 19:00', '鈴木 二郎', '大阪府大阪市', '5400001', '0677778888', 'contactb@example.com', 'password101');";
$pdo->exec($sql);

// 商品テーブル作成
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

// 商品データ挿入
$sql = "INSERT INTO product (productName, productImageURL, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus) VALUES
  ('iPhone 13', 'https://example.com/iphone13.jpg', 799.99, 3, 100, '最新のAppleスマートフォン', '2024-01-10', '2024-01-20', 1, 1),
  ('MacBook Air', 'https://example.com/macbookair.jpg', 999.99, 4, 50, 'Appleの薄型ノートPC', '2024-02-15', '2024-02-25', 1, 1),
  ('Harry Potterqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqaaaaaaaqqqqqqq', 'https://example.com/harrypotter.jpg', 15.99, 2, 200, '人気のファンタジー小説', '2024-03-01', '2024-03-10', 2, 1);";
$pdo->exec($sql);

// 注文テーブル作成
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

// 注文データ挿入
$sql = "INSERT INTO orderTable (customerNumber, orderDateTime, orderStatus, deliveryAddress, paymentMethodStatus, billingName, billingAddress) VALUES
  (1, '2024-07-28 10:00:00', 'Processing', '東京都千代田区', 'Paid', '山田 太郎', '東京都千代田区'),
  (2, '2024-07-29 15:30:00', 'Shipped', '大阪府大阪市', 'Pending', '佐藤 花子', '大阪府大阪市');";
$pdo->exec($sql);

// 注文詳細テーブル作成
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

// 注文詳細データ挿入
$sql = "INSERT INTO orderDetail (orderNumber, productNumber, quantity, price) VALUES
  (1, 1, 2, 799.99),
  (1, 2, 1, 999.99),
  (2, 3, 3, 15.99);";
$pdo->exec($sql);

// カートテーブル作成
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

// カートデータ挿入
$sql = "INSERT INTO cart (customerNumber, productNumber, quantity, dateAdded) VALUES
  (1, 1, 1, '2024-07-29 09:00:00'),
  (1, 3, 2, '2024-07-29 09:05:00'),
  (2, 2, 1, '2024-07-29 09:10:00');";
$pdo->exec($sql);

// お問い合わせ対応日時設定番号テーブル作成
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

// お問い合わせ対応日時設定番号データ挿入
$sql = "INSERT INTO dateAndTimeSettings (storeNumber, businessStartDate, businessEndDate, supportStartTime, supportEndTime) VALUES
  (1, '2024-01-01', '2024-12-31', '09:00:00', '18:00:00'),
  (2, '2024-01-01', '2024-12-31', '10:00:00', '19:00:00');";
$pdo->exec($sql);

// レビューテーブル作成
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

// レビューデータ挿入
$sql = "INSERT INTO review (customerNumber, productNumber, reviewText, purchaseFlag, evaluation) VALUES
  (1, 1, '素晴らしい製品です！', 1, '5'),
  (2, 2, 'とても満足しています。', 1, '4'),
  (1, 3, '少し期待外れでした。', 1, '3');";
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