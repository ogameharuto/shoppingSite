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

/* データベース作成 */
$dbSW = $utilConnDB->createDB();  // false:not create
if (!$dbSW) {
    die('データベース作成に失敗しました。');
}

/* データベースに接続 */
$pdo = $utilConnDB->connect();
if ($pdo === null) {
    die('データベースに接続できませんでした。');
}

/*
 * カテゴリテーブル作成
 */
$sql = "SHOW TABLES LIKE 'category';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'category') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE category;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* カテゴリテーブル生成 */
$sql = 'CREATE TABLE category (
  categoryNumber INT AUTO_INCREMENT PRIMARY KEY,
  categoryName VARCHAR(50),
  parentCategoryNumber INT,
  FOREIGN KEY (parentCategoryNumber) REFERENCES category(categoryNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* カテゴリテーブルにデータ登録  */
insCategory($pdo);

/*
 * 顧客テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'customer';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'customer') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE customer;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* 顧客テーブル生成 */
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
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* 顧客テーブルにデータ登録  */
insCustomer($pdo);

/*
 * 店舗テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'store';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'store') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE store;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* 店舗テーブル生成 */
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
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* 店舗テーブルにデータ登録  */
insStore($pdo);

/*
 * 商品テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'product';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'product') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE product;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* 商品テーブル生成 */
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
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* 商品テーブルにデータ登録  */
insProduct($pdo);

/*
 * 注文テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'orderTable';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'orderTable') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE orderTable;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* 注文テーブル生成 */
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
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* 注文テーブルにデータ登録  */
insOrder($pdo);

/*
 * 注文詳細テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'orderDetail';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'orderDetail') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE orderDetail;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* 注文詳細テーブル生成 */
$sql = 'CREATE TABLE orderDetail (
  orderDetailNumber INT AUTO_INCREMENT PRIMARY KEY,
  orderNumber INT,
  productNumber INT,
  quantity INT,
  price DECIMAL(10, 2),
  FOREIGN KEY (orderNumber) REFERENCES orderTable(orderNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* 注文詳細テーブルにデータ登録  */
insOrderDetail($pdo);

/*
 * カートテーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'cart';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'cart') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE cart;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* カートテーブル生成 */
$sql = 'CREATE TABLE cart (
  customerNumber INT,
  productNumber INT,
  quantity INT,
  dateAdded DATETIME,
  PRIMARY KEY (customerNumber, productNumber),
  FOREIGN KEY (customerNumber) REFERENCES customer(customerNumber) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (productNumber) REFERENCES product(productNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* カートテーブルにデータ登録  */
insCart($pdo);

/*
 * お問い合わせ対応日時設定番号テーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'dateAndTimeSettings';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'dateAndTimeSettings') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE dateAndTimeSettings;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* お問い合わせ対応日時設定番号テーブル生成 */
$sql = 'CREATE TABLE dateAndTimeSettings (
  dateAndTimeSettingsNumber INT AUTO_INCREMENT PRIMARY KEY,
  storeNumber INT,
  businessStartDate DATE,
  businessEndDate DATE,
  supportStartTime TIME,
  supportEndTime TIME,
  FOREIGN KEY (storeNumber) REFERENCES store(storeNumber) ON DELETE CASCADE ON UPDATE CASCADE
);';
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* お問い合わせ対応日時設定番号テーブルにデータ登録  */
insDateAndTimeSettings($pdo);

/*
 * レビューテーブル作成
 */
/* 登録済みの確認 */
$sql = "SHOW TABLES LIKE 'review';";
$ret = $pdo->query($sql);
$findSW = false;
while ($row = $ret->fetch(PDO::FETCH_NUM)) {
    if ($row[0] == 'review') {
        $findSW = true;
    }
}
if ($findSW) {
    $sql = 'DROP TABLE review;';
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "テーブル削除エラー: " . implode(", ", $pdo->errorInfo());
    }
}

/* レビューテーブル生成 */
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
$count = $pdo->exec($sql);
if ($count === false) {
    echo "テーブル作成エラー: " . implode(", ", $pdo->errorInfo());
}

/* レビューテーブルにデータ登録  */
insReview($pdo);

/*
 * データ登録関数
 */
function insCategory($pdo) {
    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Books', NULL);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Electronics', NULL);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Fiction', 1);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Non-Fiction', 1);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Mobile Phones', 2);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO category (categoryName, parentCategoryNumber) VALUES ('Laptops', 2);";
    sql_exec($pdo, $sql);
}

function insCustomer($pdo) {
    $sql = "INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) VALUES ('John Doe', 'ジョン・ドウ', '123 Elm Street', '12345', '1990-01-01', 'john.doe@example.com', '123-456-7890', 'password123');";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO customer (customerName, furigana, address, postCode, dateOfBirth, mailAddress, telephoneNumber, password) VALUES ('Jane Smith', 'ジェーン・スミス', '456 Oak Avenue', '67890', '1985-05-15', 'jane.smith@example.com', '098-765-4321', 'password456');";
    sql_exec($pdo, $sql);
}

function insStore($pdo) {
    $sql = "INSERT INTO store (companyName, companyPostalCode, companyAddress, companyRepresentative, storeName, furigana, telephoneNumber, mailAddress, storeDescription, storeImageURL, storeAdditionalInfo, operationsManager, contactAddress, contactPostalCode, contactPhoneNumber, contactEmailAddress, password) VALUES ('TechWorld', '11111', '789 Maple Road', 'Alice Johnson', 'TechWorld Store', 'テックワールド', '555-1234', 'techworld@example.com', 'A store for all your tech needs.', 'http://example.com/image.jpg', 'Additional store info.', 'Bob Brown', '101 Pine Street', '22222', '555-5678', 'bob.brown@example.com', 'storepass');";
    sql_exec($pdo, $sql);
}

function insProduct($pdo) {
    $sql = "INSERT INTO product (productName, productImageURL, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus) VALUES ('Book A', 'http://example.com/bookA.jpg', 19.99, 1, 100, 'A great book.', '2024-07-29', '2024-07-29', 1, TRUE);";
    sql_exec($pdo, $sql);

    $sql = "INSERT INTO product (productName, productImageURL, price, categoryNumber, stockQuantity, productDescription, dateAdded, releaseDate, storeNumber, pageDisplayStatus) VALUES ('Smartphone X', 'http://example.com/smartphoneX.jpg', 299.99, 5, 50, 'Latest smartphone.', '2024-07-29', '2024-07-29', 1, TRUE);";
    sql_exec($pdo, $sql);
}

function insOrder($pdo) {
    $sql = "INSERT INTO orderTable (customerNumber, orderDateTime, orderStatus, deliveryAddress, paymentMethodStatus, billingName, billingAddress) VALUES (1, '2024-07-29 14:00:00', 'Processing', '123 Elm Street', 'Credit Card', 'John Doe', '123 Elm Street');";
    sql_exec($pdo, $sql);
}

function insOrderDetail($pdo) {
    $sql = "INSERT INTO orderDetail (orderNumber, productNumber, quantity, price) VALUES (1, 1, 2, 19.99);";
    sql_exec($pdo, $sql);
}

function insCart($pdo) {
    $sql = "INSERT INTO cart (customerNumber, productNumber, quantity, dateAdded) VALUES (1, 1, 1, '2024-07-29 14:00:00');";
    sql_exec($pdo, $sql);
}

function insDateAndTimeSettings($pdo) {
    $sql = "INSERT INTO dateAndTimeSettings (storeNumber, businessStartDate, businessEndDate, supportStartTime, supportEndTime) VALUES (1, '2024-01-01', '2024-12-31', '09:00:00', '17:00:00');";
    sql_exec($pdo, $sql);
}

function insReview($pdo) {
    $sql = "INSERT INTO review (customerNumber, productNumber, reviewText, purchaseFlag, evaluation) VALUES (1, 1, 'Excellent product!', TRUE, '5');";
    sql_exec($pdo, $sql);
}

/*
 * SQL文実行
 */
function sql_exec($pdo, $sql) {
    $count = $pdo->exec($sql);
    if ($count === false) {
        echo "SQL Error: " . implode(", ", $pdo->errorInfo());
    }
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
