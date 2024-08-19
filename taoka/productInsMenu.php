<?php
/*
 productIns.php（社員スキル情報登録　入力画面）
 
 @author  田岡勇大
 @version 2.0
 @date    6月10日
*/

/* インポート */
require_once ('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// カテゴリパスを取得
$categoryPath = isset($_GET['category']) ? $_GET['category'] : '';

if (isset($_SESSION['skillBeans'])) {
    $skillBeans = $_SESSION['skillBeans'];
    /* SESSION変数をクリア */
    unset($_SESSION['skillBeans']);
}

$sql = "SELECT categoryName, categoryNumber FROM category";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$categoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../style.css" />
    <title>商品情報登録</title>
</head>

<body>
    <form name="myForm1" action="productInsMain.php" method="post">
        <h2>商品情報登録</h2>
        <div class="menu">

            商品名
            <br>
            <input type="text" name="productName" size="22" value="" required/>
            <p />
            <br>
            価格
            <br>
            <input type="number" name="price" size="22" value="" required/>
            <p />
            カテゴリ
            <br>
            <select name="category" required>
                <?php
                foreach ($categoryList as $list) {
                    echo '<option value="' . $list["categoryNumber"] . '">' . $list["categoryName"] . '</option>';
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
                <option value="公開中">公開中</option>
                <option value="非公開">非公開</option>
            </select>
            <p />
            <button type="submit">登録</button>
            <button type="button" onclick="location.href='skillMenu.php'">戻る</button>
        </div>
    </form>
</body>

</html>