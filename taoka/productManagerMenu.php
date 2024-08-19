<?php
// セッション開始
session_start();

// データベース接続
require_once('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

// フィルタリングと検索のための注文データを取得
$searchTarget = $_GET['searchTarget'] ?? '';
$searchText = $_GET['searchText'] ?? '';
$publicationStatus = $_GET['publicationStatus'] ?? '';

$sql = "SELECT productNumber, productName, pageDisplayStatus FROM product WHERE 1=1";
$params = [];
if ($searchTarget && $searchText) {
    switch ($searchTarget) {
        case "商品コード":
            $sql .= " AND productNumber = :searchText";
            break;
        case "商品名":
            $sql .= " AND productName LIKE :searchText";
            $searchText = "%" . $searchText . "%";
            break;
    }
    $params[':searchText'] = $searchText;
}

if ($publicationStatus) {
    switch ($publicationStatus) {
        case "公開中":
            $sql .= " AND pageDisplayStatus = 1";
            break;
        case "非公開":
            $sql .= " AND pageDisplayStatus = 0";
            break;
    }
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリーデータを取得
$sql = "SELECT categoryNumber, categoryName, parentCategoryNumber FROM category";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリツリーを構築する関数
function buildTree(array $elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parentCategoryNumber'] == $parentId) {
            $children = buildTree($elements, $element['categoryNumber']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}
// カテゴリツリーを生成
$categoryTree = buildTree($categories);

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

// ページ初期ロード時にカテゴリーデータをJSONとして出力
$categoriesJson = json_encode($categories, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="productManeger.css">
    <script src="product.js" defer></script>
</head>

<body>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const message = <?php echo json_encode($message); ?>;
            if (message) {
                alert(message);
            }
        });
    </script>
    <div class="flex">
        <div class="leftWidht">
            <div class="productSearch">
                <form id="searchForm" name="商品管理" method="GET">
                    <h3>商品検索</h3>
                    <div class="flex">
                        <label>
                            <p>検索対象</p>
                        </label>
                        <select name="searchTarget">
                            <option value="商品コード">商品コード</option>
                            <option value="商品名">商品名</option>
                        </select>
                    </div>
                    <div class="flex">
                        <label>
                            <p>検索文字</p>
                        </label>
                        <input type="text" name="searchText">
                    </div>
                    <div class="flex">
                        <label>
                            <p>公開状態</p>
                        </label>
                        <select name="publicationStatus">
                            <option value="公開中">公開中</option>
                            <option value="非公開">非公開</option>
                        </select>
                    </div>
                    <button type="submit" id="searchButton">検索</button>
                </form>
            </div>
            <div id="categories" class="sitemap">
                <li data-path="ストアトップ/">
                    <a href="#" data-path="ストアトップ">ストアトップ</a>
                    <ul>
                        <?php
                        // カテゴリツリーをHTMLで表示する関数
                        function renderTree($tree, $parentPath = 'ストアトップ')
                        {
                            foreach ($tree as $node) {
                                $currentPath = $parentPath . '/' . $node['categoryName'];
                                echo '<ul>';
                                echo '<li data-path="' . $currentPath . '">';
                                echo '<a href="#" onclick="showBreadcrumb(\'' . $currentPath . '\')">' . $node['categoryName'] . '</a>';
                                if (!empty($node['children'])) {
                                    renderTree($node['children'], $currentPath);
                                }
                                echo '</li>';
                                echo '</ul>';
                            }
                        }

                        // ツリーの表示
                        renderTree($categoryTree);
                        ?>
                    </ul>
                </li>
            </div>
        </div>
        <div class="productList">
            <div id="breadcrumb"></div>
            <h3>商品一覧</h3>
            <p>選択した商品の編集・削除が行えます</p>
            <p>新規追加は選択したカテゴリに新しく商品を追加することができます</p>
            <div class="flex">
            <button type="submit" id="newProductButton" onclick="location.href='productInsMenu.php'">新規追加</button>
            <button form="productForm" type="submit" onclick="{return checkDel()}">削除</button>
            <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
            </div>
            <div id="products">
                <form id="productForm" method="POST" action="delete_products.php">
                    <?php
                    foreach ($products as $row) {
                        echo '<input type="checkbox" name="products[]" value="' . $row['productNumber'] . '">';
                        echo "商品コード: " . $row["productNumber"] . "<br>";
                        echo "商品名: " . $row["productName"] . "<br>";
                        echo "ステータス: " . ($row["pageDisplayStatus"] == 1 ? '公開中' : '非公開') . "<br><br>";
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    <script>
        const categories = <?php echo $categoriesJson; ?>;
        function checkDel() {
        if(confirm('削除しますか？')){ 
            return true; 
        }else{
            alert('キャンセルされました'); 
            return false; 
        }
    }
    function handleEditButtonClick() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    if (checkboxes.length === 0) {
        alert("編集する商品を選んでください.");
        return;
    }

    const selectedItems = [];
    checkboxes.forEach((checkbox) => {
        selectedItems.push(checkbox.value);
    });

    // POST リクエストを送信
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../script/productEdit/editProductInventoryMain.php';

    selectedItems.forEach((item) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product[]';
        input.value = item;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}
    </script>
</body>

</html>