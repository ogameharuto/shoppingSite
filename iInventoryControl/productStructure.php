<!DOCTYPE html>
<html>
<head>
    aaaaaaa
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫管理</title>
    <link rel="stylesheet" href="productStructure.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="menu">
                <div class="menu-item">ページ編集</div>
                <div class="menu-item">商品管理</div>
                <div class="menu-item">在庫管理</div>
                <div class="menu-item">画像管理</div>
                <div class="menu-item">カテゴリ管理</div>
            </div>
        </div>
        <div class="content">
            <div class="sidebar">
                <div class="search-section">
                    <h3>商品検索</h3>
                    <form>
                        <input type="text" placeholder="商品コード">
                        <button type="submit">検索</button>
                    </form>
                </div>
                <div class="search-section">
                    <h3>在庫クローズ商品検索</h3>
                    <form>
                        <input type="text" placeholder="商品コード">
                        <button type="submit">検索</button>
                    </form>
                </div>
                <div class="category-list">
                    <h3>カテゴリリスト</h3>
                    <?php echo $categoryListHTML; ?>
                </div>
            </div>
            <div class="main-content">
                <div class="product-list-header">
                    <h3>商品一覧</h3>
                    <button class="edit-button" onclick="handleEditButtonClick()">編集</button>
                </div>
                <form method="POST" id="productForm">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>選択</th>
                                <th>商品コード</th>
                                <th>商品名</th>
                                <th>カテゴリ</th>
                                <th>在庫数</th>
                                <th>ステータス</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="product[]"></td>
                                <td>012345</td>
                                <td>数字商品テスト</td>
                                <td>テスト商品</td>
                                <td>10</td>
                                <td>公開中</td>
                            </tr>
                        </tbody>
                    </table>
                </form>
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
            const url = 'editProductInventory.php';
            window.location.href = url;
        }
    </script>
</body>
</html>


