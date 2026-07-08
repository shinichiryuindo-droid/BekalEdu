<?php

session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'buyer'
) {
    header("Location: ../login.php");
    exit;
}

require_once "../includes/config.php";

$buyer_id = $_SESSION['user_id'];

$product_id = intval($_GET['product_id'] ?? 0);

if ($product_id <= 0) {
    die("Produk tidak valid.");
}


/* Pastikan produk ada */

$checkProduct = $conn->prepare("
    SELECT id
    FROM products
    WHERE id=?
    LIMIT 1
");

$checkProduct->bind_param("i", $product_id);
$checkProduct->execute();

if ($checkProduct->get_result()->num_rows == 0) {
    die("Produk tidak ditemukan.");
}


/* Sudah ada di wishlist? */

$check = $conn->prepare("
    SELECT id
    FROM product_wishlist
    WHERE buyer_id=?
    AND product_id=?
");

$check->bind_param(
    "ii",
    $buyer_id,
    $product_id
);

$check->execute();

$result = $check->get_result();


if ($result->num_rows > 0) {

    /* Hapus wishlist */

    $delete = $conn->prepare("
        DELETE
        FROM product_wishlist
        WHERE buyer_id=?
        AND product_id=?
    ");

    $delete->bind_param(
        "ii",
        $buyer_id,
        $product_id
    );

    $delete->execute();

} else {

    /* Tambahkan wishlist */

    $insert = $conn->prepare("
        INSERT INTO product_wishlist
        (
            buyer_id,
            product_id
        )
        VALUES
        (?,?)
    ");

    $insert->bind_param(
        "ii",
        $buyer_id,
        $product_id
    );

    $insert->execute();

}


/* Kembali ke halaman produk */

header(
    "Location: produk-detail.php?id=" .
    $product_id
);

exit;

?>