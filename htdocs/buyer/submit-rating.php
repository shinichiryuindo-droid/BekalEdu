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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../marketplace.php");
    exit;
}

$buyerId = $_SESSION['user_id'];
$productId = intval($_POST['product_id'] ?? 0);
$rating = intval($_POST['rating'] ?? 0);
$review = trim($_POST['review'] ?? '');

if (
    $productId <= 0 ||
    $rating < 1 ||
    $rating > 5
) {
    die("Data tidak valid.");
}

/*
---------------------------------------
Pastikan produk ada
---------------------------------------
*/

$check = $conn->prepare("
    SELECT id
    FROM products
    WHERE id=?
    LIMIT 1
");

$check->bind_param("i", $productId);
$check->execute();

if ($check->get_result()->num_rows == 0) {
    die("Produk tidak ditemukan.");
}

/*
---------------------------------------
Sudah pernah memberi rating?
---------------------------------------
*/

$check = $conn->prepare("
    SELECT id
    FROM product_reviews
    WHERE
        product_id=?
        AND buyer_id=?
");

$check->bind_param(
    "ii",
    $productId,
    $buyerId
);

$check->execute();

$result = $check->get_result();

if ($result->num_rows > 0) {

    /*
    UPDATE REVIEW
    */

    $update = $conn->prepare("
        UPDATE product_reviews
        SET
            rating=?,
            review=?,
            created_at=NOW()
        WHERE
            product_id=?
            AND buyer_id=?
    ");

    $update->bind_param(
        "isii",
        $rating,
        $review,
        $productId,
        $buyerId
    );

    $update->execute();

} else {

    /*
    INSERT REVIEW
    */

    $insert = $conn->prepare("
        INSERT INTO product_reviews
        (
            product_id,
            buyer_id,
            rating,
            review,
            created_at
        )
        VALUES
        (?, ?, ?, ?, NOW())
    ");

    $insert->bind_param(
        "iiis",
        $productId,
        $buyerId,
        $rating,
        $review
    );

    $insert->execute();

}

header(
    "Location: produk-detail.php?id=" .
    $productId .
    "&rating=success"
);
exit;