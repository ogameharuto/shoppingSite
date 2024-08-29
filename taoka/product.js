document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM fully loaded and parsed');  // ページ読み込み時の確認

    const messageElement = document.getElementById('message');
    if (messageElement && messageElement.dataset.message) {
        alert(messageElement.dataset.message);
    }

    const categoriesElement = document.getElementById('categories');

    // カテゴリのクリックイベントを監視
    categoriesElement.addEventListener('click', (e) => {
        const target = e.target;
        if (target.tagName === 'A') {
            e.preventDefault(); // デフォルトのリンク遷移を防ぐ
            const path = target.getAttribute('data-path');  // データパス属性を直接取得
            console.log('Category clicked:', path);  // カテゴリクリック時のログ

            updateBreadcrumb(path);  // パンくずリストを更新
            fetchProducts({ category: path });  // 商品リストを更新
        }
    });
});

// パンくずリストを更新する関数
function updateBreadcrumb(path) {
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
        const url = new URL('fetch_products.php', window.location.href);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        console.log('Fetching products from:', url.toString());  // リクエストURLの確認
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const products = await response.json();
        updateProductList(products);
    } catch (error) {
        console.error('Fetch error:', error);
    }
}

// HTMLエスケープ関数
function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}