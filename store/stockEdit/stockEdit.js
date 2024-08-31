// 商品編集ボタンクリック時の処理
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
    form.action = 'editProductStockMain.php';

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

// ページの読み込み完了時にカテゴリのクリックイベントを設定
document.addEventListener('DOMContentLoaded', () => {
    const categoriesElement = document.getElementById('categories');

    // カテゴリのクリックイベントを監視
    categoriesElement.addEventListener('click', (e) => {
        const target = e.target;

        // クリックされた要素がリンクの場合
        if (target.tagName === 'A') {
            e.preventDefault(); // デフォルトのリンク遷移を防ぐ
            const path = target.getAttribute('data-path'); // data-path 属性からパスを取得

            console.log('Clicked path:', path);

            // パンくずリストを更新
            updateBreadcrumb(path);

            // 商品をフェッチ
            fetchProducts({ category: path });
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
}

// 商品リストを更新する関数
function updateProductList(products) {
    if (!Array.isArray(products)) {
        console.error('Expected an array of products, but got:', products);
        return;
    }

    const productsElement = document.querySelector('.main-content');
    console.log('Updating product list with products:', products);

    let tableHtml = `
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
    `;
    products.forEach(product => {
        tableHtml += `
            <tr>
                <td><input type="checkbox" name="products[]" value="${escapeHtml(product.productNumber)}"></td>
                <td>${escapeHtml(product.productNumber)}</td>
                <td>
                    ${product.imageName ? `<img src="../../uploads/${escapeHtml(product.imageName)}" alt="Product Image" width="100">` : '画像なし'}
                </td>
                <td>${escapeHtml(product.productName)}</td>
                <td>${escapeHtml(product.stockQuantity)}</td>
                <td>${product.pageDisplayStatus == 1 ? '公開中' : '非公開'}</td>
            </tr>
        `;
    });
    tableHtml += '</tbody></table>';
    productsElement.querySelector('.product-table')?.remove(); // 古いテーブルを削除
    productsElement.innerHTML += tableHtml;
}

// 商品リストをフェッチする関数
async function fetchProducts(params) {
    try {
        const url = new URL('fetchCategoryProducts.php', window.location.href);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        console.log('Fetching products with params:', params);
        console.log('Fetching products from:', url.toString());
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const result = await response.json();
        console.log('Result fetched:', result);

        // エラーチェック
        if (result.error) {
            throw new Error(result.error);
        }

        if (!Array.isArray(result)) {
            throw new TypeError('Expected an array of products but got: ' + JSON.stringify(result));
        }

        updateProductList(result);
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
