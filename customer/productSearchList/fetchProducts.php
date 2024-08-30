<?php
session_start();
header('Content-Type: application/json');

// セッションから商品データを取得
$products = $_SESSION['product'] ?? [];

// POSTリクエストから並び替え基準を取得
$sortByProduct = $_POST['productSort'] ?? '';
$sortByPrice = $_POST['priceSort'] ?? '';

// 商品を並び替える関数
function sortProducts($products, $sortByProduct, $sortByPrice) {
    usort($products, function($a, $b) use ($sortByProduct, $sortByPrice) {
        // 商品基準で並び替え
        if ($sortByProduct === 'priceLow') {
            return $a['price'] - $b['price'];
        } elseif ($sortByProduct === 'priceHigh') {
            return $b['price'] - $a['price'];
        } elseif ($sortByProduct === 'priceShippingLow') {
            // 価格＋送料が安い順のロジックを実装
            return ($a['price'] + $a['shipping']) - ($b['price'] + $b['shipping']);
        } elseif ($sortByProduct === 'priceShippingHigh') {
            // 価格＋送料が高い順のロジックを実装
            return ($b['price'] + $b['shipping']) - ($a['price'] + $a['shipping']);
        } elseif ($sortByProduct === 'reviewCount') {
            // レビュー件数順のロジックを実装
            return $b['reviewCount'] - $a['reviewCount'];
        } elseif ($sortByProduct === 'reviewScore') {
            // レビュー点順のロジックを実装
            return $b['reviewScore'] - $a['reviewScore'];
        } elseif ($sortByProduct === 'discount') {
            // 割引率の高い順のロジックを実装
            return $b['discount'] - $a['discount'];
        }

        // 並び替え基準が一致しない場合、並び替えなし
        return 0;
    });

    // 必要に応じて価格で並び替えを追加
    if ($sortByPrice === 'immediateUse') {
        // 今すぐ利用価格のロジックを実装
    } elseif ($sortByPrice === 'actual') {
        // 実質価格のロジックを実装
    }

    return $products;
}

// 商品を並び替える
$sortedProducts = sortProducts($products, $sortByProduct, $sortByPrice);

// 並び替えた商品をJSON形式で返す
echo json_encode($sortedProducts);
?>
