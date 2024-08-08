document.addEventListener('DOMContentLoaded', () => {
    const categoriesElement = document.getElementById('categories');

    // カテゴリのクリックイベントを監視
    categoriesElement.addEventListener('click', (e) => {
        const target = e.target;
        if (target.tagName === 'A') {
            e.preventDefault(); // デフォルトのリンク遷移を防ぐ
            const path = target.parentElement.getAttribute('data-path');
            updateBreadcrumb(path);
            fetchProducts({ category: path });
        }
    });

    // パンくずリストを表示
    function updateBreadcrumb(path) {
        const breadcrumbElement = document.getElementById('breadcrumb');
        const parts = path.split('/');
        breadcrumbElement.innerHTML = parts.map((part, index) => {
            const linkPath = parts.slice(0, index + 1).join('/');
            return `<a href="#" data-path="${linkPath}">${part}</a>`;
        }).join(' > ');
    }

    // 該当する商品の一覧を作成
    async function fetchProducts(params) {
        try {
            const url = new URL('fetch_products.php', window.location.href);
            Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const products = await response.json();
            updateProductList(products);
        } catch (error) {
        }
    }

    // フォームを作り直してfetchProducts関数から受け取った商品をすべて表示
    function updateProductList(products) {
        const productsElement = document.getElementById('products');
    
        // 新しい form 要素を作成
        const formElement = document.createElement('form');
        formElement.id = 'productForm';
        formElement.method = 'POST';
        formElement.action = 'delete_products.php';
    
        // 各商品の内容を追加
        products.forEach(product => {
            const productHtml = `
                <input type="checkbox" name="products[]" value="${product.productNumber}">
                商品コード: ${product.productNumber}<br>
                商品画像: <img src="${product.productImageURL}" alt="Product Image"><br>
                商品名: ${product.productName}<br>
                ステータス: ${product.pageDisplayStatus == 1 ? '公開中' : '非公開'}<br><br>
            `;
            formElement.innerHTML += productHtml;
        });
    
        // 生成した form を productsElement に追加
        productsElement.innerHTML = '';
        productsElement.appendChild(formElement);
    }
});