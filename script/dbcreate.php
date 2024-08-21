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
    'images',
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

//ストア側のカテゴリテーブル作成


// ストア側のカテゴリデータ挿入


// カテゴリテーブル作成
$sql = 'CREATE TABLE category (
  categoryNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  categoryName VARCHAR(50) NOT NULL,
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// カテゴリデータ挿入
$sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES
  ('家電', NULL),
  ('本', NULL),
  ('スマホ', 1),
  ('ノートパソコン', 1);";
$pdo->exec($sql);

// 顧客テーブル作成
$sql = 'CREATE TABLE customer (
  customerNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerName VARCHAR(50) NOT NULL,
  furigana VARCHAR(50) NOT NULL,
  address VARCHAR(100) NOT NULL,
  postCode VARCHAR(10) NOT NULL,
  dateOfBirth DATE NOT NULL,
  mailAddress VARCHAR(50) UNIQUE NOT NULL,
  telephoneNumber VARCHAR(20) NOT NULL,
  password VARCHAR(50) NOT NULL
);';
$pdo->exec($sql);

// 顧客データ挿入
$sql = "INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) VALUES
  ('山田 太郎', 'ヤマダ タロウ', '東京都千代田区', '1000001', '1980-01-01', 'yamada@example.com', '09012345678', 'password123'),
  ('佐藤 花子', 'サトウ ハナコ', '大阪府大阪市', '5400001', '1990-05-05', 'sato@example.com', '08098765432', 'password456');";
$pdo->exec($sql);

// 店舗テーブル作成
$sql = 'CREATE TABLE store (
  storeNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  companyName VARCHAR(50) NOT NULL,
  companyPostalCode VARCHAR(10) NOT NULL,
  companyAddress VARCHAR(100) NOT NULL,
  companyRepresentative VARCHAR(50) NOT NULL,
  storeName VARCHAR(50) NOT NULL,
  furigana VARCHAR(50) NOT NULL,
  telephoneNumber VARCHAR(20) NOT NULL,
  mailAddress VARCHAR(50) NOT NULL,
  storeDescription VARCHAR(2000) NOT NULL,
  storeImageURL VARCHAR(255) NOT NULL,
  storeAdditionalInfo VARCHAR(2000) NOT NULL,
  operationsManager VARCHAR(50) NOT NULL,
  contactAddress VARCHAR(100) NOT NULL,
  contactPostalCode VARCHAR(10) NOT NULL,
  contactPhoneNumber VARCHAR(20) NOT NULL,
  contactEmailAddress VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
);';
$pdo->exec($sql);

// 店舗データ挿入
$sql = "INSERT INTO store (companyName, companyPostalCode, companyAddress, companyRepresentative, storeName, furigana, telephoneNumber, mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, contactPhoneNumber, contactEmailAddress, password) VALUES
  ('株式会社ストアA', '1000001', '東京都千代田区', '田中 一郎', 'ストアA', 'ストア エー', '0355556666', 'storea@example.com', '電子機器とガジェット', 'https://example.com/storea.jpg', '営業時間: 9:00 - 18:00', '田中 一郎', '東京都千代田区', '1000001', '0355556666', 'contacta@example.com', 'password789'),
  ('株式会社ストアB', '5400001', '大阪府大阪市', '鈴木 二郎', 'ストアB', 'ストア ビー', '0677778888', 'storeb@example.com', '書籍と文房具', 'https://example.com/storeb.jpg', '営業時間: 10:00 - 19:00', '鈴木 二郎', '大阪府大阪市', '5400001', '0677778888', 'contactb@example.com', 'password101');";
$pdo->exec($sql);

// 商品テーブル作成
$sql = 'CREATE TABLE product (
  productNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  productName VARCHAR(50) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  categoryNumber INT NOT NULL,
  stockQuantity INT NOT NULL,
  productDescription VARCHAR(500) NOT NULL,
  dateAdded DATE NOT NULL,
  releaseDate DATE NOT NULL,
  storeNumber INT NOT NULL,
  pageDisplayStatus BOOLEAN NOT NULL,
  FOREIGN KEY (categoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 商品データ挿入
$sql = "INSERT INTO product (productName, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus) VALUES
  ('iPhone 13', 799.99, 3, 100, '最新のAppleスマートフォン', '2024-01-10', '2024-01-20', 1, 1),
  ('MacBook Air', 999.99, 4, 50, 'Appleの薄型ノートPC', '2024-02-15', '2024-02-25', 1, 0),
  ('Harry Potterq', 15.99, 2, 200, '人気のファンタジー小説', '2024-03-01', '2024-03-10', 2, 0);";
$pdo->exec($sql);

// 画像テーブル作成
$sql = 'CREATE TABLE images (
  imageNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  imageHash VARCHAR(256) NOT NULL,
  imageName VARCHAR(255) NOT NULL,
  addedDate date NOT NULL,
  storeNumber INT NOT NULL,
  productNumber INT NOT NULL,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 注文テーブル作成
$sql = 'CREATE TABLE orderTable (
  orderNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerNumber INT NOT NULL,
  orderDateTime DATETIME NOT NULL,
  orderStatus VARCHAR(50) NOT NULL,
  deliveryAddress VARCHAR(100) NOT NULL,
  paymentMethodStatus VARCHAR(50) NOT NULL,
  billingName VARCHAR(50) NOT NULL,
  billingAddress VARCHAR(100) NOT NULL,
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 注文データ挿入
$sql = "INSERT INTO orderTable (customerNumber, orderDateTime, orderStatus, deliveryAddress, paymentMethodStatus, billingName, billingAddress) VALUES
  (1, '2024-07-28 10:00:00', '入金処理', '東京都千代田区', 'Paid', '山田 太郎', '東京都千代田区'),
  (2, '2024-07-29 15:30:00', '出荷済み', '大阪府大阪市', 'Pending', '佐藤 花子', '大阪府大阪市');";
$pdo->exec($sql);

// 注文詳細テーブル作成
$sql = 'CREATE TABLE orderDetail (
  orderDetailNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  orderNumber INT NOT NULL,
  productNumber INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
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
  customerNumber INT NOT NULL,
  productNumber INT NOT NULL,
  quantity INT NOT NULL,
  dateAdded DATETIME NOT NULL,
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
  dateAndTimeSettingsNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  storeNumber INT NOT NULL,
  businessStartDate DATE NOT NULL,
  businessEndDate DATE NOT NULL,
  supportStartTime TIME NOT NULL,
  supportEndTime TIME NOT NULL,
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
  reviewNumber INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  customerNumber INT NOT NULL,
  productNumber INT NOT NULL,
  reviewText VARCHAR(300),
  purchaseFlag BOOLEAN NOT NULL,
  evaluation VARCHAR(10),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// レビューデータ挿入
$sql = "INSERT INTO review (customerNumber, productNumber, reviewText, purchaseFlag, evaluation) VALUES
  (1, 1, '素晴らしい製品です！', 1, '4.5'),
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

<form name="myForm1" action="../taoka/index.php" method="post">
  <h2>実習No.3 データベース初期化（デバッグ用）</h2>
  データベースを初期化しました。<p />
  <input type="submit" value="戻る" />
</form>
</body>
</html>