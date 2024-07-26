document.addEventListener('DOMContentLoaded', function() {
  const productSelect = document.getElementById('prodctSelect');
  const priceSelect = document.getElementById('priceSelect');
  const productListContainer = document.getElementById('productList');

  function fetchProducts() {
      fetch('fetchProducts.php')
          .then(response => response.json())
          .then(data => {
              renderProducts(data);
          })
          .catch(error => console.error('商品を取得中にエラーが発生しました:', error));
  }

  function renderProducts(products) {
      productListContainer.innerHTML = '';
      products.forEach(product => {
          const productElement = document.createElement('div');
          productElement.className = 'product';
          productElement.innerHTML = `
              <div class="width">
                  <img src="${product.image}" class="productImage"></img>
                  <p><a href="${product.url}" class="text">${product.name}</a></p>
                  <p>
                      <span class="price">${product.price}円</span>
                      <span class="postage">＋${product.shipping}</span>
                  </p>
                  <p>
                      <a href="${product.store_url}" class="store">
                          <span>${product.store}</span>
                      </a>
                  </p>
                  <button class="favoriteBtn">
                      <svg width="48" height="48" viewBox="0 0 48 48" aria-hidden="true" class="Symbol">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M39.4 11.57a8.94 8.94 0 0 0-12.55 0L24 14.4l-2.85-2.82a8.94 8.94 0 0 0-12.55 0 8.7 8.7 0 0 0 0 12.4l2.85 2.83 12.2 12.05c.2.2.51.2.7 0l1.05-1.02L36.55 26.8l2.85-2.82a8.7 8.7 0 0 0 0-12.4Z"></path>
                      </svg>
                  </button>
              </div>
          `;
          productListContainer.appendChild(productElement);
      });


      document.querySelectorAll('.favoriteBtn').forEach(button => {
          button.addEventListener('click', function() {
              this.classList.toggle('favorite');
          });
      });
  }

  function handleSort() {
      const sortByProduct = productSelect.value;
      const sortByPrice = priceSelect.value;

      fetch('fetchProducts.php')
          .then(response => response.json())
          .then(data => {
              let products = data;

              products.sort((a, b) => {
                  let aValue, bValue;

                  // 商品基準でのソート
                  if (sortByProduct === '価格が安い順') {
                      aValue = parseInt(a.price);
                      bValue = parseInt(b.price);
                      return aValue - bValue;
                  } else if (sortByProduct === '価格が高い順') {
                      aValue = parseInt(a.price);
                      bValue = parseInt(b.price);
                      return bValue - aValue;
                  }
                  // 他のソートオプションも同様に追加

                  // 価格基準でのソート（追加条件をここに記述）
                  if (sortByPrice === '今すぐ利用価格') {
                      // この基準のロジックを実装
                  } else if (sortByPrice === '実質価格') {
                      // この基準のロジックを実装
                  }

                  return 0;
              });

              renderProducts(products);
          })
          .catch(error => console.error('商品を取得中にエラーが発生しました:', error));
  }

  productSelect.addEventListener('change', handleSort);
  priceSelect.addEventListener('change', handleSort);

  fetchProducts();
});

