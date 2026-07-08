<?php
session_start();
require_once '../includes/config.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    die("Produk tidak ditemukan.");
}

/* ==========================
   PRODUCT
========================== */

$stmt = $conn->prepare("
SELECT
    p.*,
    u.username AS seller_name
FROM products p
JOIN users u
    ON u.id = p.seller_id
WHERE p.id = ?
LIMIT 1
");

$stmt->bind_param("i", $productId);
$stmt->execute();

$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Produk tidak ditemukan.");
}

/* ==========================
   REVIEWS
========================== */

$stmt = $conn->prepare("
SELECT
    r.rating,
    r.review,
    r.created_at,
    u.username
FROM product_ratings r
JOIN users u
    ON u.id = r.buyer_id
WHERE r.product_id = ?
ORDER BY r.created_at DESC
LIMIT 10
");

$stmt->bind_param("i", $productId);
$stmt->execute();

$reviews = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?= htmlspecialchars($product['name']) ?>
- Bekal Edu
</title>

<link rel="stylesheet"
href="../assets/css/style.css">

<style>

body{
    margin:0;
    background:#f5f7fb;
    font-family:Segoe UI,sans-serif;
}

.container{
    max-width:1100px;
    margin:40px auto;
    padding:20px;
}

.card{
    background:#fff;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
    overflow:hidden;
}

.product{
    display:grid;
    grid-template-columns:420px 1fr;
}

@media(max-width:900px){

.product{
    grid-template-columns:1fr;
}

}

    .back-wrapper{
    margin-bottom:20px;
}

.back-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    background:#fff;
    color:#2563eb;
    text-decoration:none;
    font-weight:700;
    border-radius:10px;
    border:1px solid #dbeafe;
    box-shadow:0 3px 10px rgba(0,0,0,.05);
    transition:.2s;
}

.back-btn:hover{
    background:#2563eb;
    color:#fff;
    transform:translateY(-2px);
}
    
.image-box{
    background:#f3f4f6;
}

.image-box img{
    width:100%;
    display:block;
}

.info{
    padding:30px;
}

.title{
    font-size:32px;
    font-weight:700;
    margin-bottom:15px;
}

.price{
    color:#2563eb;
    font-size:36px;
    font-weight:800;
    margin-bottom:18px;
}

.badges{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.badge{
    background:#eef4ff;
    color:#2563eb;
    padding:8px 14px;
    border-radius:999px;
    font-size:14px;
    font-weight:600;
}

.description{
    margin-top:25px;
    line-height:1.8;
    color:#444;
}

.btn{
    display:inline-block;
    text-decoration:none;
    padding:12px 22px;
    border-radius:10px;
    font-weight:700;
    margin-top:25px;
}

.btn-buy{
    background:#2563eb;
    color:white;
}

.btn-chat{
    background:white;
    color:#2563eb;
    border:2px solid #2563eb;
    margin-left:10px;
}

.section{
    margin-top:30px;
}

.review{
    background:white;
    border-radius:14px;
    padding:18px;
    margin-bottom:15px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.review-user{
    font-weight:700;
}

.review-stars{
    color:#f59e0b;
    margin-top:5px;
}

.review-date{
    color:#888;
    font-size:13px;
    margin-top:5px;
}

.review-text{
    margin-top:12px;
    line-height:1.7;
}

</style>

</head>

<body>

<div class="container">
<div class="back-wrapper">
    <a href="javascript:history.back()" class="back-btn">
        ← Kembali
    </a>
</div>
<div class="card">

<div class="product">
    
<?php if (!empty($product['image'])): ?>

<div class="image-box">
    <img src="../media/<?= htmlspecialchars($product['image']) ?>"
         alt="<?= htmlspecialchars($product['name']) ?>">
</div>

<?php else: ?>

<div class="image-box"
     style="display:flex;align-items:center;justify-content:center;height:420px;font-size:80px;">
    📦
</div>

<?php endif; ?>

<div class="info">

<div class="title">
    <?= htmlspecialchars($product['name']) ?>
</div>

<div class="price">
    Rp <?= number_format($product['price'],0,',','.') ?>
</div>

<div class="badges">

    <div class="badge">
        ⭐
        <?= number_format($product['rating_avg'],1) ?>
        (<?= $product['rating_count'] ?>)
    </div>

    <div class="badge">
        📂
        <?= htmlspecialchars($product['category']) ?>
    </div>

    <div class="badge">
        📦
        Stock:
        <?= $product['stock'] ?>
    </div>

</div>

<div style="margin-top:20px;font-size:16px;">

<b>Nama Penjual:</b>
<?= htmlspecialchars($product['seller_name']) ?>

</div>

<form action="../buyer/keranjang.php" method="POST" style="display:inline;">

    <input
        type="hidden"
        name="product_id"
        value="<?= $product['id'] ?>">

    <button
        type="submit"
        class="btn btn-buy">

        🛒 Tambah ke Keranjang

    </button>

</form>
    
<a
href="../messages/cc.php?user_id=<?= $product['seller_id'] ?>"
class="btn btn-chat">

💬 Chat Penjual

</a>

</div>

</div>

</div>

<div class="card" style="margin-top:25px;padding:30px;">

<h2 style="margin-top:0;">

Deskripsi Produk

</h2>

<div class="description" style="margin-top:15px;">

<?= nl2br(htmlspecialchars($product['description'])) ?>

</div>

</div>

<div class="section">

<h2>

Ulasan Pembeli

</h2>
<br>

<?php if ($reviews->num_rows == 0): ?>

<div class="review">

Belum ada review untuk produk ini.

</div>

<?php else: ?>

<?php while($r = $reviews->fetch_assoc()): ?>

<div class="review">

<div class="review-user">

<?= htmlspecialchars($r['username']) ?>

</div>

<div class="review-stars">

<?php
for($i=1;$i<=5;$i++){
    echo ($i <= $r['rating']) ? "★" : "☆";
}
?>

</div>

<?php if(!empty($r['review'])): ?>

<div class="review-text">

<?= nl2br(htmlspecialchars($r['review'])) ?>

</div>

<?php endif; ?>

<div class="review-date">

<?= date("d M Y H:i", strtotime($r['created_at'])) ?>

</div>

</div>

<?php endwhile; ?>

<?php endif; ?>

</div>

<footer style="margin-top:50px;text-align:center;color:#888;padding:30px 0;">

Bekal Edu Marketplace

</footer>
    
    </body>
</html>