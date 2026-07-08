<?php

session_start();

require_once '../includes/config.php';

if(
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] != 'seller'
){
    header('Location: ../login.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT *
     FROM products
     WHERE seller_id = ?
     ORDER BY created_at DESC"
);

$stmt->bind_param(
    "i",
    $currentUserId
);

$stmt->execute();

$products = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Produk Saya
</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

<style>

body{
    margin:0;
    background:#f5f7fb;
    font-family:Arial,sans-serif;
}

.products-container{

    max-width:1200px;

    margin:40px auto;

    padding:20px;

    transition:.3s;

}

.products-container.expanded{

    margin-left:90px;

}

.page-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;

}

.add-btn{

    background:#2563eb;

    color:white;

    text-decoration:none;

    padding:12px 20px;

    border-radius:12px;

}

.product-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fill,minmax(300px,1fr));

    gap:20px;

}

.product-card{

    background:white;

    border-radius:20px;

    overflow:hidden;

    box-shadow:
    0 8px 25px rgba(0,0,0,.05);

}

.product-image{

    width:100%;

    height:220px;

    object-fit:cover;

    background:#e5e7eb;

}

.product-content{

    padding:18px;

}

.product-name{

    font-size:18px;

    font-weight:700;

    margin-bottom:10px;

}

.product-price{

    color:#2563eb;

    font-size:22px;

    font-weight:bold;

    margin-bottom:10px;

}

.product-stock{

    color:#6b7280;

    margin-bottom:15px;

}

.actions{

    display:flex;

    gap:10px;

}

.main-content{

    margin-left:270px;

    padding:30px;

    transition:.3s;

}

.main-content.expanded{

    margin-left:90px;

}
    
.btn{

    flex:1;

    text-align:center;

    text-decoration:none;

    padding:12px;

    border-radius:10px;

}

.btn-edit{

    background:#2563eb;

    color:white;

}

.btn-delete{

    background:#ef4444;

    color:white;

}

.empty{

    background:white;

    padding:50px;

    border-radius:20px;

    text-align:center;

}

</style>

</head>

<body>

<?php include '../includes/sidebar-seller.php'; ?>

<div id="mainContent" class="main-content">
<div class="page-top">

<h1>
📦 Produk Saya
</h1>

<a
href="tambah-produk.php"
class="add-btn">

➕ Tambah Produk

</a>

</div>

<?php if($products->num_rows > 0): ?>

<div class="product-grid">

<?php while($product = $products->fetch_assoc()): ?>

<div class="product-card">

<?php if(!empty($product['image'])): ?>

<img
src="/media/<?php echo htmlspecialchars($product['image']); ?>"
class="product-image"
alt="<?php echo htmlspecialchars($product['name']); ?>">
<?php else: ?>

<div class="product-image"></div>

<?php endif; ?>

<div class="product-content">

<div class="product-name">

<?php
echo htmlspecialchars(
$product['name']
);
?>

</div>

<div class="product-price">

Rp

<?php

echo number_format(
$product['price'],
0,
',',
'.'
);

?>

</div>

<div class="product-stock">

📦 Stok:

<?php
echo $product['stock'];
?>

</div>

<div class="actions">

<a
href="edit-produk.php?id=<?php echo $product['id']; ?>"
class="btn btn-edit">

Edit

</a>

<a
href="hapus-produk.php?id=<?php echo $product['id']; ?>"
class="btn btn-delete"
onclick="return confirm('Hapus produk ini?')">

Hapus

</a>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="empty">

<h2>
📭
</h2>

<p>
Belum ada produk.
</p>

<br>

<a
href="tambah-produk.php"
class="add-btn">

Tambah Produk Pertama

</a>

</div>

<?php endif; ?>

</div>

</body>
</html>