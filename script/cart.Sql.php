<?php

header('Content-Type:text/plain; charset=utf-8');

class CartDAO{

    public function selectCartItems($pdo, $customerNumber) {
        // SQL文生成
        $sql = 'SELECT 
                    p.productName,
                    p.productImageURL,
                    p.price,
                    c.quantity,
                    p.productDescription
                FROM cart c
                JOIN product p ON c.productNumber = p.productNumber
                WHERE c.customerNumber = :customerNumber';
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':customerNumber', $customerNumber, PDO::PARAM_INT);
        
        $stmt->execute();
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $cartItems;
    }
}
?>
