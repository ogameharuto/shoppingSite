<?php
session_start();
// データベース接続設定
require_once('../../utilConnDB.php');
$utilConnDB = new UtilConnDB();
$pdo = $utilConnDB->connect();
// ログイン確認
if (!isset($_SESSION['store'])) {
    header("Location: http://localhost/shopp/script/login/loginMenu.php");
    exit();
}

// ストア番号を取得
$storeNumber = $_SESSION['store']['storeNumber'];

$current_page = basename($_SERVER['PHP_SELF']);
// 検索条件の取得
$searchTarget = $_GET['searchTarget'] ?? '';
$searchText = $_GET['searchText'] ?? '';
$publicationStatus = $_GET['publicationStatus'] ?? '';

// 商品データと画像データを取得
$sql = "
    SELECT 
        p.productNumber, 
        p.productName, 
        p.price, 
        p.stockQuantity, 
        p.productDescription, 
        p.dateAdded, 
        p.releaseDate, 
        p.storeNumber, 
        p.pageDisplayStatus, 
        i.imageNumber,
        i.imageHash, 
        i.imageName,
        sc.storeCategoryNumber, 
        sc.storeCategoryName
    FROM product p
    LEFT JOIN images i ON p.imageNumber = i.imageNumber
    LEFT JOIN storecategory sc ON p.categoryNumber = sc.storeCategoryNumber
    WHERE p.storeNumber = :storeNumber
";

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

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カテゴリーデータを取得
$sql = "SELECT storeCategoryNumber, storeCategoryName, parentStoreCategoryNumber 
        FROM storecategory
        WHERE storeNumber = :storeNumber";
$params = [':storeNumber' => $storeNumber];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


// カテゴリツリーを構築する関数
function buildTree(array $elements, $parentId = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parentStoreCategoryNumber'] == $parentId) {
            $children = buildTree($elements, $element['storeCategoryNumber']);
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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫管理</title>
    <link rel="stylesheet" href="productStructure.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="navbar">
                <a href="http://localhost/shopp/script/storeToppage.php" class="nav-item <?php echo ($current_page == 'storeToppage.php') ? 'active' : ''; ?>">トップ</a>
                <a href="http://localhost/shopp/taoka/productManagerMenu.php" class="nav-item <?php echo ($current_page == 'productManagerMenu.php') ? 'active' : ''; ?>">商品管理</a>
                <a href="http://localhost/shopp/script/stockEdit/productStructure.php" class="nav-item <?php echo ($current_page == 'productStructure.php') ? 'active' : ''; ?>">在庫管理</a>
                <a href="http://localhost/shopp/script/imageIns/imageInsMenu.php" class="nav-item <?php echo ($current_page == 'imageInsMenu.php') ? 'active' : ''; ?>">画像管理</a>
                <a href="http://localhost/shopp/script/productCategory/categoryManagement.php" class="nav-item <?php echo ($current_page == 'categoryManagement.php') ? 'active' : ''; ?>">カテゴリ管理</a>
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
                        <li data-path="ストアトップ">
                            <a href="#" data-path="ストアトップ" onclick="updateBreadcrumb('ストアトップ')">ストアトップ</a>
                        </li>
                        <?php if (!empty($categoryTree)): ?>
                            <ul>
                                <?php
                                function renderTree($tree, $parentPath = 'ストアトップ')
                                {
                                    foreach ($tree as $node) {
                                        $currentPath = $parentPath . '/' . $node['storeCategoryName'];
                                        echo '<li data-path="' . htmlspecialchars($currentPath, ENT_QUOTES, 'UTF-8') . '">';
                                        echo '<a href="#" data-path="' . htmlspecialchars($currentPath, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($node['storeCategoryName'], ENT_QUOTES, 'UTF-8') . '</a>';
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
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div id="breadcrumb"></div>
                <div class="product-list-header">
                    <h3>商品一覧</h3>
                    <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
                </div>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>選択</th>
                            <th>商品コード</th>
                            <th>画像</th>
                            <th>商品名</th>
                            <th>在庫数</th>
                            <th>ステータス</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row): ?>
                            <tr>
                                <td><input type="checkbox" name="products[]" value="<?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?>"></td>
                                <td><?php echo htmlspecialchars($row['productNumber'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if (!empty($row['imageHash'])): ?>
                                        <img src="../uploads/<?php echo htmlspecialchars($row['imageName'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($row['imageName'], ENT_QUOTES, 'UTF-8'); ?>" width="100">
                                    <?php else: ?>
                                        画像なし
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['productName'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['stockQuantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <?php if ($row['pageDisplayStatus'] == 1): ?>
                                        <span>公開中</span>
                                    <?php else: ?>
                                        <span>非公開</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
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

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'editProductInventoryMain.php';

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
        document.addEventListener('DOMContentLoaded', () => {
    const categoriesElement = document.getElementById('categories');

    // カテゴリのクリックイベントを監視
    categoriesElement.addEventListener('click', (e) => {
        const target = e.target;

        // クリックされた要素がリンクの場合
        if (target.tagName === 'A') {
            e.preventDefault(); // デフォルトのリンク遷移を防ぐ
            const path = target.getAttribute('data-path'); // data-path 属性からパスを取得

            // デバッグ用に path をログに表示
            console.log('Clicked path:', path);

            if (path === 'ストアトップ') {
                // ストアトップがクリックされた場合、すべての商品を表示
                updateBreadcrumb('ストアトップ');
                fetchProducts({}); // カテゴリパラメータなしですべての商品を取得
            } else {
                // その他のカテゴリがクリックされた場合
                updateBreadcrumb(path);
                fetchProducts({ category: path });
            }
        }
    });
});

// パンくずリストを更新する関数
function updateBreadcrumb(path) {
    if (!path) {
        console.error('Path is null or undefined');
        return;
    }
    
    const breadcrumbElement = document.getElementById('breadcrumb');
    const parts = path.split('/');
    breadcrumbElement.innerHTML = parts.map((part, index) => {
        const linkPath = parts.slice(0, index + 1).join('/');
        return `<a href="#" data-path="${linkPath}">${escapeHtml(part)}</a>`;
    }).join(' > ');
    console.log('Breadcrumb updated:', breadcrumbElement.innerHTML);  // パンくずリスト更新時のログ

    // パスが「ストアトップ」の場合は全商品を表示する
    if (path === 'ストアトップ') {
        fetchProducts({});
    }
}

// 商品リストを更新する関数
function updateProductList(products) {
    const productsElement = document.getElementById('products');
    console.log('Updating product list with products:', products);  // 商品リスト更新時のログ

    const formElement = document.createElement('form');
    formElement.id = 'productForm';
    formElement.method = 'POST';
    formElement.action = 'delete_products.php';

    const tableHtml = `
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
            </tbody>
        </table>
    `;
    formElement.innerHTML = tableHtml;

    const tbodyElement = formElement.querySelector('tbody');

    products.forEach(product => {
        const rowHtml = `
            <tr>
                <td><input type="checkbox" name="products[]" value="${escapeHtml(product.productNumber)}"></td>
                <td>${escapeHtml(product.productNumber)}</td>
                <td>
                    ${product.imageName ? `<img src="../script/uploads/${escapeHtml(product.imageName)}" alt="Product Image" width="100">` : '画像なし'}
                </td>
                <td>${escapeHtml(product.productName)}</td>
                <td>${product.pageDisplayStatus == 1 ? '公開中' : '非公開'}</td>
            </tr>
        `;
        tbodyElement.innerHTML += rowHtml;
    });

    productsElement.innerHTML = '';
    productsElement.appendChild(formElement);
}

// 商品リストをフェッチする関数
async function fetchProducts(params) {
    try {
        const url = new URL('fetchCategoryProducts.php', window.location.href);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        console.log('Fetching products with params:', params);  // 追加
        console.log('Fetching products from:', url.toString());  // リクエストURLの確認
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const products = await response.json();
        console.log('Products fetched:', products);  // 追加
        updateProductList(products);
    } catch (error) {
        console.error('Fetch error:', error);
    }
}


// HTMLエスケープ関数
function escapeHtml(text) {
    return text
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}
    </script>
</body>
</html>
