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
$dbSW = $utilConnDB->createDB();  // false:not create
/*
 * データベースに接続
 */
$pdo = $utilConnDB->connect();   // null:not found

/*
 * 外部キー制約を一時的に無効にする
 */
$pdo->exec('SET FOREIGN_KEY_CHECKS = 0;');

/*
 * テーブルを削除する関数
 */
function dropTableIfExists($pdo, $tableName)
{
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
  'customer_orders',
  'product',
  'dateAndTimeSettings',
  'storeCategory',
  'store',
  'customer',
  'category',
  'deliveryOptions',
  'favoriteProducts'
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
  categoryName VARCHAR(50) NOT NULL,
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// カテゴリデータ挿入
$sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES
  ('レディースファッション', NULL),
  ('メンズファッション', NULL),
  ('腕時計、アクセサリー', NULL),
  ('レディースアクセサリー', 3),
  ('スマートウォッチ', 3),
  ('メンズ腕時計', 3),
  ('メンズアクセサリー', 3),
  ('食品', NULL),
  ('お米、雑穀、粉類', 8),
  ('お菓子', 8),
  ('フルーツ', 8),
  ('ドリンク、水、お酒', NULL),
  ('ジュース', 11),
  ('炭酸飲料', 11),
  ('日本酒', 11),
  ('焼酎', 11),
  ('家電', NULL),
  ('スマホ、タブレット、パソコン', NULL),
  ('ゲーム、おもちゃ', NULL),
  ('スポーツ', NULL),
  ('車、バイク、自転車', NULL),
  ('自動車', 20),
  ('バイク', 20),
  ('自転車', 20),
  ('本、雑誌、コミック', NULL);";
$pdo->exec($sql);

// 顧客テーブル作成
$sql = 'CREATE TABLE customer (
  customerNumber INT AUTO_INCREMENT PRIMARY KEY,
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
  storeNumber INT AUTO_INCREMENT PRIMARY KEY,
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

// 店舗カテゴリテーブル作成
$sql = 'CREATE TABLE storeCategory (
  storeCategoryNumber INT AUTO_INCREMENT PRIMARY KEY,
  storeCategoryName VARCHAR(50) NOT NULL,
  parentStoreCategoryNumber INT,
  storeNumber INT,
  FOREIGN KEY (parentStoreCategoryNumber) REFERENCES storeCategory(storeCategoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 店舗カテゴリデータ挿入
$sql = "INSERT INTO storeCategory (storeCategoryName, parentStoreCategoryNumber, storeNumber) VALUES
  ('レディースファッション', NULL, 2),
  ('メンズファッション', NULL, 2),
  ('腕時計、アクセサリー', NULL, 2),
  ('レディースアクセサリー', 3, 2),
  ('スマートウォッチ', 3, 2),
  ('メンズ腕時計', 3, 2),
  ('メンズアクセサリー', 3, 2),
  ('食品', NULL, 2),
  ('お米、雑穀、粉類', 8, 2),
  ('お菓子', 8, 2),
  ('フルーツ', 8, 2),
  ('ドリンク、水、お酒', NULL, 1),
  ('ジュース', 1, 1),
  ('炭酸飲料', 1, 1),
  ('日本酒', 1, 1),
  ('焼酎', 1, 1),
  ('家電', NULL, 2),
  ('スマホ、タブレット、パソコン', NULL, 1),
  ('ゲーム、おもちゃ', NULL, 2),
  ('スポーツ', NULL, 2),
  ('車、バイク、自転車', NULL, 1),
  ('自動車', 20, 1),
  ('バイク', 20, 1),
  ('自転車', 20, 1),
  ('本、雑誌、コミック', NULL, 2);";
$pdo->exec($sql);

// 画像テーブル作成
$sql = 'CREATE TABLE images (
  imageNumber INT AUTO_INCREMENT PRIMARY KEY,
  imageHash VARCHAR(256) NOT NULL,
  imageName VARCHAR(255) NOT NULL,
  addedDate date NOT NULL,
  storeNumber INT NOT NULL,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 画像データを挿入
$sql = "INSERT INTO images (imageHash, imageName, addedDate, storeNumber) VALUES
  ('32268287870496aa2fe29023631344719eefd5b97cebb201f6e6e5cac1ec0a9e', 'スマホ.png', '2024-01-09', 1),
  ('b8e584f69e3a3101423fcd90d23abe929ec0b284dba309c354a6badd0054f90f', 'ノートパソコン.jpg', '2024-02-14', 1),
  ('e83440f9b48370a042d7f115f4b42fd676c64eca9cd0044367918a61e7524261', '本.jpg', '2024-02-28', 2);";
$pdo->exec($sql);

// 商品テーブル作成
$sql = 'CREATE TABLE product (
  productNumber INT AUTO_INCREMENT PRIMARY KEY,
  productName VARCHAR(50) NOT NULL,
  price INT NOT NULL,
  categoryNumber INT NOT NULL,
  storeCategoryNumber INT,
  stockQuantity INT NOT NULL,
  productDescription VARCHAR(500) NOT NULL,
  dateAdded DATE NOT NULL,
  releaseDate DATE NOT NULL,
  storeNumber INT NOT NULL,
  pageDisplayStatus BOOLEAN NOT NULL,
  imageNumber INT,
  FOREIGN KEY (categoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeCategoryNumber) REFERENCES storeCategory(storeCategoryNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (imageNumber) REFERENCES images(imageNumber) ON DELETE CASCADE ON UPDATE CASCADE

);';
$pdo->exec($sql);

// 商品データ挿入
$sql = "INSERT INTO product (productName, price, categoryNumber,storeCategoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus, imageNumber) VALUES
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('メンズファッション', '2024-09-03', '2024-09-03', 2, 1, null),
  ('クール系ネックレス', 16500, 14, 14, 100, とてもおしゃれできれいな時計です。, '2024-09-03', '2024-09-03', 2, 1, null),
  ('アリアス　スマートウォッチ　フルタッチパネル　角型　ブラック', 4890, 15, 15, 8920, 歩数・心拍・血中酸素・他で健康管理。'2024-09-03', '2024-09-03', 2, 1, null),
  ('LIGE type-osyare', 37000, 16, 16, 1000, やすそうに見えて実際は高い男性向けの腕時計です。, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ちょっとかっこいいネックレス', 7900, 7, 7, 首にかけるだけで誰でも少しだけかっこよくなれます。, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),
  ('ゆるかわ', 3850, 1, 1, 2347, ゆるっとかわいいが売りの服, '2024-09-03', '2024-09-03', 2, 1, null),;";
$pdo->exec($sql);


// 注文テーブル作成
$sql = 'CREATE TABLE customer_orders (
  orderNumber INT AUTO_INCREMENT PRIMARY KEY,
  customerNumber INT NOT NULL,
  orderDateTime DATETIME NOT NULL,
  orderStatus VARCHAR(50) NOT NULL,
  deliveryName VARCHAR(50),
  deliveryFurigana VARCHAR(50),
  deliveryAddress VARCHAR(100) NOT NULL,
  deliveryPostCode VARCHAR(100) NOT NULL,
  deliveryPhone VARCHAR(100) NOT NULL,
  deliveryDateTime VARCHAR(50) NOT NULL,
  paymentMethodStatus VARCHAR(50) NOT NULL,
  billingName VARCHAR(50) NOT NULL,
  billingFurigana VARCHAR(50),
  billingAddress VARCHAR(100) NOT NULL,
  billingPostCode VARCHAR(100) NOT NULL,
  billingPhone VARCHAR(100) NOT NULL,
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);

// 注文詳細テーブル作成
$sql = 'CREATE TABLE orderDetail (
  orderDetailNumber INT AUTO_INCREMENT PRIMARY KEY,
  orderNumber INT NOT NULL,
  productNumber INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (orderNumber) REFERENCES customer_orders(orderNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
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

// お問い合わせ対応日時設定番号テーブル作成
$sql = 'CREATE TABLE dateAndTimeSettings (
  dateAndTimeSettingsNumber INT AUTO_INCREMENT PRIMARY KEY,
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
  reviewNumber INT AUTO_INCREMENT PRIMARY KEY,
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
  (1, 1, '素晴らしい製品です！', 1, '5'),
  (2, 2, 'とても満足しています。', 1, '4');";
$pdo->exec($sql);

// お届け方法データ挿入
$sql = 'CREATE TABLE deliveryOptions (
  deliveryOptionSettingNumber	INT AUTO_INCREMENT PRIMARY KEY,
  updatedOn	VARCHAR(50),
  storeNumber	INT NOT NULL,
  deliveryCompany	DATE,
  deliveryMethod	DATE,
  deliveryDate DATE NOT NULL,
  deliveryTime VARCHAR(50) NOT NULL,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
  );';
$pdo->exec($sql);

//お気に入り
$sql = 'CREATE TABLE favoriteProducts (
  favoriteItemNumber INT AUTO_INCREMENT PRIMARY KEY,
  customerNumber INT NOT NULL,
  productNumber INT NOT NULL,
  addeddate date,
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$pdo->exec($sql);




/*
 * SQL文実行
 */
function sql_exec($pdo, $sql)
{
  $count = $pdo->exec($sql);

  return $count;
}
session_start();
session_unset();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>ショッピングサイト</title>
</head>

<body>
<h2>データベース初期化（デバッグ用）</h2>
    データベースを初期化しました。<br>
    <p><a href="store/account/storeLoginMenu.php">ストアクリエイターProのログイン</a></p>
    <p><a href="customer/account/customerLoginMenu.php">ヤフーショッピングのログイン</a></p>
    <p><a href="customerToppage.php">ヤフーショッピングサイト</a></p>
</body>

</html>