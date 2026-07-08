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

$stmt = $conn->prepare("
SELECT
    p.*,
    pw.created_at AS wishlisted_at
FROM product_wishlist pw
JOIN products p
    ON p.id = pw.product_id
WHERE pw.buyer_id = ?
ORDER BY pw.created_at DESC
");

$stmt->bind_param("i", $buyer_id);
$stmt->execute();

$wishlist = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Wishlist Saya</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

<style>

.main-content{
    padding:40px;
}

.page-title{
    font-size:34px;
    margin-bottom:30px;
}

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(260px,1fr));

    gap:25px;

}

.product-card{

    background:#fff;

    border-radius:18px;

    overflow:hidden;

    box-shadow:0 6px 18px rgba(0,0,0,.08);

    transition:.25s;

}

.product-card:hover{

    transform:translateY(-5px);

}

.product-image{

    width:100%;

    height:220px;

    object-fit:cover;

    background:#f3f4f6;

}

.placeholder{

    height:220px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:60px;

    background:#f3f4f6;

}

.product-body{

    padding:20px;

}

.product-title{

    font-size:20px;

    font-weight:bold;

    margin-bottom:10px;

}

.product-price{

    font-size:24px;

    color:#2563eb;

    font-weight:bold;

    margin-bottom:15px;

}

.product-meta{

    color:#666;

    margin-bottom:20px;

}

.action-row{

    display:flex;

    gap:10px;

    flex-wrap:wrap;

}

.btn{

    flex:1;

    padding:10px;

    border:none;

    border-radius:10px;

    cursor:pointer;

    text-decoration:none;

    text-align:center;

    font-weight:bold;

}

.btn-primary{

    background:#2563eb;

    color:white;

}

.btn-danger{

    background:#ef4444;

    color:white;

}

.btn-outline{

    background:#fff;

    color:#2563eb;

    border:1px solid #2563eb;

}

.empty{

    text-align:center;

    padding:100px 20px;

}

.empty h2{

    margin:20px 0;

}

</style>

</head>

<body>

<?php include "../includes/sidebar-buyer.php"; ?>

<div
id="mainContent"
class="main-content">

<h1 class="page-title">
❤️ Wishlist Saya
</h1>

<?php if($wishlist->num_rows==0): ?>

<div class="empty">

<div style="font-size:70px;">
💔
</div>

<h2>
Wishlist masih kosong
</h2>

<p>
Tambahkan produk favoritmu ke wishlist.
</p>

<br>

<a
href="../marketplace.php"
class="btn btn-primary"
style="display:inline-block;width:auto;padding:14px 24px;">

Lihat Marketplace

</a>

</div>

<?php else: ?>

<div class="grid">

<?php while($product=$wishlist->fetch_assoc()): ?>

<div class="product-card">

<?php if(!empty($product['image'])): ?>

<img

src="../media/<?= htmlspecialchars($product['image']) ?>"

class="product-image"

alt="<?= htmlspecialchars($product['name']) ?>">

<?php else: ?>

<div class="placeholder">
📦
</div>

<?php endif; ?>

<div class="product-body">

<div class="product-title">

<?= htmlspecialchars($product['name']) ?>

</div>

<div class="product-price">

Rp <?= number_format($product['price'],0,',','.') ?>

</div>

<div class="product-meta">

Kategori:
<?= htmlspecialchars($product['category']) ?>

<br><br>

Stok:
<?= intval($product['stock']) ?>

</div>

<div class="action-row">

<a

href="produk-detail.php?id=<?= $product['id'] ?>"

class="btn btn-outline">

Lihat

</a>

<form
action="keranjang.php"
method="post"
style="flex:1;">

<input

type="hidden"

name="product_id"

value="<?= $product['id'] ?>">

<button
class="btn btn-primary"
type="submit">

🛒 Keranjang

</button>

</form>

<a

href="wishlist.php?product_id=<?= $product['id'] ?>"

class="btn btn-danger">

❌ Hapus

</a>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

<?php endif; ?>

</div>

<script>

document.addEventListener(
'DOMContentLoaded',
function(){

const sidebar=document.getElementById('sidebar');

const toggle=document.getElementById('sidebarToggle');

const content=document.getElementById('mainContent');

if(!sidebar)return;

function update(){

if(sidebar.classList.contains('closed')){

content.classList.add('expanded');

}else{

content.classList.remove('expanded');

}

}

update();

toggle.addEventListener(
'click',
function(){

setTimeout(update,20);

});

});

</script>

</body>
</html>