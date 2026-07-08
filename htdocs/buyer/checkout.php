<?php

session_start();

require_once '../includes/config.php';

if(
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'buyer'
){
    header('Location: ../login.php');
    exit;
}

$buyerId = $_SESSION['user_id'];

/*pusingggg */

$stmt = $conn->prepare(
    "SELECT
        c.product_id,
        c.quantity,
        p.seller_id,
        p.price,
        p.stock,
        p.name
     FROM cart c
     JOIN products p
     ON c.product_id = p.id
     WHERE c.buyer_id = ?"
);

$stmt->bind_param(
    "i",
    $buyerId
);

$stmt->execute();

$items =
$stmt->get_result();

if(
    $items->num_rows === 0
){
    header(
        'Location: keranjang.php'
    );
    exit;
}

$conn->begin_transaction();

try{

    while(
        $item =
        $items->fetch_assoc()
    ){

        if(
            $item['stock'] <
            $item['quantity']
        ){

            throw new Exception(
                'Stok produk "' .
                $item['name'] .
                '" tidak mencukupi.'
            );

        }

        $totalPrice =
            $item['price'] *
            $item['quantity'];

        $stmtOrder =
        $conn->prepare(
            "INSERT INTO orders
            (
                buyer_id,
                seller_id,
                product_id,
                quantity,
                total_price,
                status
            )
            VALUES
            (
                ?, ?, ?, ?, ?, 'pending'
            )"
        );

        $stmtOrder->bind_param(
            "iiiid",
            $buyerId,
            $item['seller_id'],
            $item['product_id'],
            $item['quantity'],
            $totalPrice
        );

        $stmtOrder->execute();

        $stmtStock =
        $conn->prepare(
            "UPDATE products
             SET stock =
             stock - ?
             WHERE id = ?"
        );

        $stmtStock->bind_param(
            "ii",
            $item['quantity'],
            $item['product_id']
        );

        $stmtStock->execute();

    }

    $stmtDelete =
    $conn->prepare(
        "DELETE FROM cart
         WHERE buyer_id = ?"
    );

    $stmtDelete->bind_param(
        "i",
        $buyerId
    );

    $stmtDelete->execute();

    $conn->commit();

    header(
        'Location: keranjang.php?success=1'
    );

    exit;

}catch(Exception $e){

    $conn->rollback();

    die(
        'Checkout gagal: ' .
        $e->getMessage()
    );

}