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
  ('237285352a8f7d64e7c273f58159007cf6e43d5b165ba01e06f347b0a0d6b54d', 'レディース服.jpg', '2024-01-09', 2),
  ('5d6f0ba22bfd4c589697723299f85723f8929686066c83748cf9809bb9da83e9', 'メンズ服.jpg', '2024-02-14', 2),
  ('b70c0c3e439ceab3c1c9e0b62dbbc52e5b6c748a2d193317faaf4964f7073e3b', 'レディースアクセサリー.jpg', '2024-02-14', 2),
  ('5a600bc38a61ec69e16468e623059bce9511b87ecf9e12ad45b89ee245516cf9', 'スマートウォッチ.jpg', '2024-02-14', 2),
  ('fc7cf931a7de615eb35bb9c37895208e48953a709f9027de9f8bb0fdce9036a5', 'メンズ時計.jpg', '2024-02-14', 2),
  ('9c5b8afcbf1347191632799ceb4024ed1173198e4efaf76447803b9191fcb7b2', 'メンズアクセサリー.jpg', '2024-02-14', 2),
  ('44f38ce5a426e257dd6b0f62b8962104c7b6b43ad91bee5c1aadbdf8acfe6e22', 'ゆめぴりか.jpg', '2024-02-14', 2),
  ('81095ada1350135a1abf7a2c44d924e575fb2da3bc371b7acbd9a3d350868179', '薄力粉.jpg', '2024-02-14', 2),
  ('1086ecdda07e20a7ce2be50516d9b56743ec99dea125aa9a38b17741eb49073b', 'おいしいお菓子.jpg', '2024-02-14', 2),
  ('09d3f4afbb854a70936fcd6f07729b5d293d816fffb0a69a5f9899ea3fd915e8', '惑星リンゴ.png', '2024-02-14', 2),
  ('af080a41389bc257af9b2f77ccac5d17805a082b5958af014df23ded42260dd7', 'バナナ.png', '2024-02-14', 2),
  ('e0eef721868c45bddf82c2ffc6fb8f585abc24a08774d34c3af93a085828729f', 'ブドウ.jpg', '2024-02-14', 2),
  ('f2eddbb3cf21875837fedc10f735812501fc57cbdcbecb7e88a196313854c379', 'オレンジ.jpg', '2024-02-14', 1),
  ('a1c75584a2fe27a9b7a21a5958a072824f224e1f9c76b3fd910021a87179e73d', '炭酸水.jpg', '2024-02-14', 1),
  ('9ed8c62947ff020874c3b3976628e0184ce19ac69ee0cb735c29b6a08ad8807c', '日本酒.jpg', '2024-02-14', 1),
  ('70a962bb6c2077fc2946e1efcd1f55cb89b85c46bdc0b7a74bd9e93ac2909d2f', '焼酎.jpg', '2024-02-14', 1),
  ('59612430f5fad2ac95c806d1336a0619d61060532b05dd087bdb5c041d534b62', 'テレビ.jpg', '2024-02-14', 2),
  ('c20dfe06791e67e7a0d1b10039fe9735b4daafa6dfa79b7a8a21db6a607c88e4', 'スイッチ.jpg', '2024-02-14', 2),
  ('99cf00746438b8cd6565b1848a8e4d9be86fd928b0a38193a3f162588221d5a4', '仮面ライダーベルト.jpg', '2024-02-14', 2),
  ('1abe4cc3c1ea82f4464b52bdd4f56e2a3ac9c36c0fcfe5d484b1f5f38b22c5b4', 'サッカーボール.jpg', '2024-02-14', 2),
  ('e6f0cdfc49fe18615ca2891f88b6d1b8bad87437b1506cfab4d5fd3d8fca0e4b', '自動車.jpg', '2024-02-14', 1),
  ('b34c238c9af1ab9dd0964cebd4f3cb4217f141bffac4d5f60f46f253040a8bb4', 'バイク.jpg', '2024-02-14', 1),
  ('9d4d35a50bf64cefb15ac002c7ec1d99b98fff02fefd30e65b4ab4f2cbc64e2a', 'ママチャリ.jpg', '2024-02-14', 1);";
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
  ('ゆるかわ', 3850, 1, 1, 2000, 'ゆるっとかわいいが売りの服', '2024-09-03', '2024-09-03', 2, 1, 1),
  ('かっこいい服', 6700, 2, 2, 6264, '暗めの色でとてもかっこよく見えます。', '2024-09-03', '2024-09-03', 2, 1, 2),
  ('刺さると痛いネックレス', 16500, 4, 4, 100, 'イカツイファッションがお好きな女性向けのネックレスです。', '2024-09-03', '2024-09-03', 2, 1, 3),
  ('アリアス スマートウォッチ フルタッチパネル 角型 ブラック', 4890, 5, 5, 8920, '歩数・心拍・血中酸素・他で健康管理。', '2024-09-03', '2024-09-03', 2, 1, 4),
  ('LIGE type-osyare', 37000, 6, 6, 1000, 'やすそうに見えて実際は高い男性向けの腕時計です。', '2024-09-03', '2024-09-03', 2, 1, 5),
  ('ちょっとかっこいいネックレス', 7900, 7, 7, 8746545, '首にかけるだけで誰でも少しだけかっこよくなれます。', '2024-09-03', '2024-09-03', 2, 1, 6),
  ('ゆめぴりか', 6000, 9, 9, 355467864, '北海道産のお米', '2024-09-03', '2024-09-03', 2, 1, 7),
  ('岐阜県産 薄力粉', 1500, 9, 9, 989784735, '天ぷらやお菓子などの料理に適しています。', '2024-09-03', '2024-09-03', 2, 1, 8),
  ('おいしいお菓子', 190, 10, 10, 27000, '一度食べると病みつきになります', '2024-09-03', '2024-09-03', 2, 1, 9),
  ('惑星リンゴ', 16000, 11, 11, 10, '生産地が惑星の珍しいリンゴ', '2024-09-03', '2024-09-03', 2, 1, 10),
  ('おいしいバナナ', 320, 11, 11, 9785465656, '黒くなりにくくておいしいバナナ', '2024-09-03', '2024-09-03', 2, 1, 11),
  ('紫ブドウ', 600, 11, 11, 75638264, '一粒一粒に甘さが詰まっています', '2024-09-03', '2024-09-03', 2, 1, 12),
  ('オレンジジュース', 100, 13, 13, 1452632265, '一般的なオレンジジュース', '2024-09-03', '2024-09-03', 1, 1, 13),
  ('ウィルキンソン', 160, 14, 14, 735564126, '味がしない炭酸水。ほかのものと混ぜて飲むとおいしい', '2024-09-03', '2024-09-03', 1, 1, 14),
  ('日本酒', 1940, 15, 15, 190027, 'この日本酒を飲んでしまうとどんな人も一瞬で酔っていしまいます。', '2024-09-03', '2024-09-03', 1, 1, 15),
  ('焼酎', 5600, 16, 16, 574256, 'これを飲むとモヤモヤが解消されます。', '2024-09-03', '2024-09-03', 1, 1, 16),
  ('sharpのテレビ', 124000, 17, 17, 12000, '大画面で高画質のテレビ', '2024-09-03', '2024-09-03', 2, 1, 17),
  ('任天堂スイッチ', 45300, 19, 19, 80000, 'みんなが大好き任天堂の最新ゲーム機', '2024-09-03', '2024-09-03', 2, 1, 18),
  ('仮面ライダーベルト', 36900, 19, 19, 540000, '仮面ライダーダブルの変身ベルト', '2024-09-03', '2024-09-03', 2, 1, 19),
  ('サッカーボール', 4000, 20, 20, 100000, 'このボールはほかのと違い、空気が抜けにくい', '2024-09-03', '2024-09-03', 2, 1, 20),
  ('スポーツカー', 3850000, 22, 22, 80, 'こんなかっこいい車他にはありません!', '2024-09-03', '2024-09-03', 1, 1, 21),
  ('イカツイバイク', 5130000, 23, 23, 700, 'これに乗ってるとモテるかも', '2024-09-03', '2024-09-03', 1, 1, 22),
  ('ママチャリ', 36000, 24, 24, 90570, 'ちょっと大きめのママチャリです', '2024-09-03', '2024-09-03', 1, 1, 23);";
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