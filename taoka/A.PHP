<?php
// セッション開始
session_start();

// データベース接続
require_once('../script/utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();

$current_page = basename($_SERVER['PHP_SELF']);

// ストア番号を取得
$storeNumber = $_SESSION['store']['storeNumber'];

// フィルタリングと検索のための注文データを取得
$searchTarget = $_GET['searchTarget'] ?? '';
$searchText = $_GET['searchText'] ?? '';
$publicationStatus = $_GET['publicationStatus'] ?? '';

// ストアに登録されている商品のみを表示するためのSQLクエリ
$sql = "
    SELECT p.productNumber, p.productName, p.pageDisplayStatus, i.imageHash, i.imageName, s.storeName
    FROM product p
    JOIN store s ON p.storeNumber = s.storeNumber
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    WHERE p.storeNumber = :storeNumber"; // storeNumberでフィルタリング

$params = [':storeNumber' => $storeNumber];

// 検索条件の追加
if ($searchTarget && $searchText) {
    switch ($searchTarget) {
        case "商品コード":
            $sql .= " AND p.productNumber = :searchText";
            $params[':searchText'] = $searchText;
            break;
        case "商品名":
            $sql .= " AND p.productName LIKE :searchText";
            $params[':searchText'] = "%" . $searchText . "%";
            break;
    }
}

if ($publicationStatus) {
    switch ($publicationStatus) {
        case "公開中":
            $sql .= " AND p.pageDisplayStatus = 1";
            break;
        case "非公開":
            $sql .= " AND p.pageDisplayStatus = 0";
            break;
    }
}

$sql .= " ORDER BY s.storeName, p.productName"; // 商品を店舗ごとに並び替え

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
<html>
<head>
<meta charset="UTF-8">
    <title>ショッピングサイト</title>
    <link rel="stylesheet" href="../script/stockEdit/productStructure.css">
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
    <div class="container">
        <div class="header">
            <div class="navbar">
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">ページ編集</a>
                <a href="http://localhost/shopp/taoka/A.php" class="nav-item <?php echo ($current_page == 'A.php') ? 'active' : ''; ?>">商品管理</a>
                <a href="http://localhost/shopp/script/stockEdit/productStructure.php" class="nav-item <?php echo ($current_page == 'productStructure.php') ? 'active' : ''; ?>">在庫管理</a>
                <a href="http://localhost/shopp/script/imageIns/imageInsMenu.php" class="nav-item <?php echo ($current_page == 'imageInsMenu.php') ? 'active' : ''; ?>">画像管理</a>
                <a href="" class="nav-item <?php echo ($current_page == '') ? 'active' : ''; ?>">カテゴリ管理</a>
            </div>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="search-section">
                    <form id="searchForm" method="GET">
                        <h3>商品検索</h3>
                        <div class="flex">
                            <label>検索対象</label>
                            <select name="searchTarget">
                                <option value="商品コード" <?php if ($searchTarget == "商品コード") echo 'selected'; ?>>商品コード</option>
                                <option value="商品名" <?php if ($searchTarget == "商品名") echo 'selected'; ?>>商品名</option>
                            </select>
                        </div>
                        <div class="flex">
                            <label>検索文字</label>
                            <input type="text" name="searchText" value="<?php echo htmlspecialchars($searchText, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                        <div class="flex">
                            <label>公開状態</label>
                            <select name="publicationStatus">
                                <option value="">全て</option>
                                <option value="公開中" <?php if ($publicationStatus == "公開中") echo 'selected'; ?>>公開中</option>
                                <option value="非公開" <?php if ($publicationStatus == "非公開") echo 'selected'; ?>>非公開</option>
                            </select>
                        </div>
                        <button type="submit" id="searchButton">検索</button>
                    </form>
                </div>
                <div id="categories" class="sitemap">
                    <ul>
                        <li data-path="ストアトップ/">
                            <a href="#" onclick="showBreadcrumb('ストアトップ')">ストアトップ</a>
                            <?php if (!empty($categoryTree)): ?>
                            <ul>
                                <?php
                                function renderTree($tree, $parentPath = 'ストアトップ')
                                {
                                    foreach ($tree as $node) {
                                        $currentPath = $parentPath . '/' . $node['categoryName'];
                                        echo '<li data-path="' . $currentPath . '">';
                                        echo '<a href="#" onclick="showBreadcrumb(\'' . $currentPath . '\')">' . $node['categoryName'] . '</a>';
                                        if (!empty($node['children'])) {
                                            echo '<ul>';
                                            renderTree($node['children'], $currentPath);
                                            echo '</ul>';
                                        }
                                        echo '</li>';
                                    }
                                }
                                // ツリーの表示
                                renderTree($categoryTree);
                                ?>
                            </ul>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div id="breadcrumb"></div>
                <div class="product-list-header">
                    <h3>商品一覧</h3>
                    <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
                    <button type="submit" id="deleteButton">削除</button>
                </div>
                <form id="productForm" method="POST" action="delete_products.php">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>選択</th>
                                <th>商品コード</th>
                                <th>画像</th>
                                <th>商品名</th>
                                <th>ステータス</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentStore = '';
                            foreach ($products as $row):
                            ?>
                                <tr>
                                    <td><input type="checkbox" name="products[]" value="<?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                                    <td><?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php if (!empty($row['imageHash'])): ?>
                                            <img src="../script/uploads/<?php echo htmlspecialchars($row['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" width="100">
                                        <?php else: ?>
                                            画像なし
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo $row['pageDisplayStatus'] == 1 ? '公開中' : '非公開'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
