document.addEventListener('DOMContentLoaded', () => {
    const categories = document.getElementById('categories');
    const breadcrumb = document.getElementById('breadcrumb');
    const products = document.getElementById('products');
    const searchButton = document.getElementById('searchButton');
    const searchForm = document.getElementById('searchForm');

    categories.addEventListener('click', (e) => {
        const target = e.target;
        if (target.tagName === 'LI') {
            const path = target.getAttribute('data-path');
            updateBreadcrumb(path);
            fetchProducts({ category: path });
        }
    });

    searchButton.addEventListener('click', () => {
        const formData = new FormData(searchForm);
        const searchParams = {};
        formData.forEach((value, key) => {
            searchParams[key] = value;
        });
        fetchProducts(searchParams);
    });

    function updateBreadcrumb(path) {
        const parts = path.split('/');
        breadcrumb.innerHTML = parts.map((part, index) => {
            const linkPath = parts.slice(0, index + 1).join('/');
            return `<a href="#" data-path="${linkPath}">${part}</a>`;
        }).join(' > ');
    }

    function fetchProducts(params) {
        const query = new URLSearchParams(params).toString();
        fetch(`fetch_products.php?${query}`)
            .then(response => response.json())
            .then(data => {
                displayProducts(data);
            })
            .catch(error => {
                console.error('Error fetching products:', error);
            });
    }

    function displayProducts(productsList) {
        if (productsList.length === 0) {
            products.innerHTML = '<p>該当する商品が見つかりませんでした。</p>';
            return;
        }
        products.innerHTML = productsList.map(product => `
            <div class="product">
                <h4>${product.name}</h4>
                <p>コード: ${product.code}</p>
                <p>状態: ${product.status}</p>
            </div>
        `).join('');
    }
});