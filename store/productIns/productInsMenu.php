<?php
/*
 productIns.php（社員スキル情報登録　入力画面）
 
 @author  田岡勇大
 @version 2.0
 @date    6月10日
*/

/* インポート */
require_once ('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

session_start();

// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: ../account/storeLoginMenu.php");
    exit();
}

$storeNumber = $_SESSION['store']['storeNumber'];

$sql = "SELECT storeCategoryNumber, storeCategoryName FROM storeCategory WHERE storeNumber = :storeNumber";

$stmt = $pdo->prepare($sql);
$stmt->execute([':storeNumber' => $storeNumber]);
$storeCategoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT categoryName, categoryNumber FROM category";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$shoppCategoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <title>商品情報登録</title>
</head>

<body>
    <form name="myForm1" action="productInsMain.php" method="post" enctype="multipart/form-data">
        <h2>商品情報登録</h2>
        <div class="menu">

            商品名
            <br>
            <input type="text" name="productName" size="22" value="" required/>
            <p />
            商品画像
            <br>
            <input type="file" name="image" id="image" required>
            <br>
            <br>
            価格
            <br>
            <input type="number" name="price" size="22" value="" required/>
            <p />
            ショップカテゴリ
            <br>
            <select name="shoppCategory" required>
                <?php
                foreach ($shoppCategoryList as $list) {
                    echo '<option value="' . $list["categoryNumber"] . '">' . $list["categoryName"] . '</option>';
                }
                ?>
            </select>
            <p />
            ストアカテゴリ
            <br>
            <select name="storeCategory" required>
                <?php
                foreach ($storeCategoryList as $list) {
                    echo '<option value="' . $list["storeCategoryNumber"] . '">' . $list["storeCategoryName"] . '</option>';
                }
                ?>
            </select>
            <p />
            在庫数
            <br>
            <input type="number" name="stock" size="22" value="" required/>
            <p />
            商品詳細説明
            <br>
            <input type="text" name="productDescription" size="22" value="" />
            <p />
            発売日
            <br>
            <input type="date" name="releaseDate" size="22" value="" required/>
            <p />
            ページ表示ステータス
            <br>
            <select name="pageDisplayStatus" required>
                <option value="1">公開中</option>
                <option value="0">非公開</option>
            </select>
            <p />
            <button type="submit">登録</button>
            <button type="button" onclick="location.href='../script/storeToppage.php'">戻る</button>
        </div>
    </form>
</body>

</html>