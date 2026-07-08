<?php

session_start();

require_once '../includes/config.php';

if(
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'seller'
){
    header('Location: ../login.php');
    exit;
}

$sellerId =
$_SESSION['user_id'];

$username =
$_SESSION['username'] ?? 'Penjual';


/*
|--------------------------------------------------------------------------
| Produk Aktif
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM products
     WHERE seller_id = ?"
);

$stmt->bind_param(
    "i",
    $sellerId
);

$stmt->execute();

$productCount =
$stmt->get_result()
->fetch_assoc()['total'] ?? 0;


/* Hitung Pesanan Belum Dibayar (Status Pending) */
$stmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM orders
WHERE seller_id = ?
AND payment_status = 'belum_bayar'
");
$stmt->bind_param("i", $sellerId);
$stmt->execute();
$UnpaidOrders = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/*
|--------------------------------------------------------------------------
| Pesanan Baru
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE seller_id = ?
     AND status = 'pending'"
);

$stmt->bind_param(
    "i",
    $sellerId
);

$stmt->execute();

$newOrders =
$stmt->get_result()
->fetch_assoc()['total'] ?? 0;

/*
|--------------------------------------------------------------------------
| Pesanan nunggu diproses
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE seller_id = ?
     AND status = 'diproses'"
);

$stmt->bind_param(
    "i",
    $sellerId
);

$stmt->execute();

$needProcess =
$stmt->get_result()
->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Dashboard Penjual - Bekal Edu
</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

</head>
<body>

<?php
include '../includes/sidebar-seller.php';
?>

<div
class="main"
id="mainContent">

<div class="header-card">

<h1>
Halo,
<?php echo htmlspecialchars($username); ?>
🏪
</h1>

<p>
Kelola produk sekolah bekas,
pantau penjualan,
dan bantu siswa mendapatkan
perlengkapan dengan harga
terjangkau.
</p>

</div>

<div class="stats">

<div class="stat-card">

<div style="font-size:24px;">
📦
</div>

<div class="stat-number">
<?php echo number_format($productCount); ?>
</div>

<div
style="
color:#64748b;
font-weight:600;
font-size:14px;
">
Produk Aktif
</div>

</div>

<div class="stat-card">

<div style="font-size:24px;">
💰
</div>

<div class="stat-number">
<?php echo number_format($UnpaidOrders); ?>
</div>

<div
style="
color:#64748b;
font-weight:600;
font-size:14px;
">
Pesanan Belum dibayar
</div>

</div>

<div class="stat-card">

<div style="font-size:24px;">
🛒
</div>

<div class="stat-number">
<?php echo number_format($newOrders); ?>
</div>

<div
style="
color:#64748b;
font-weight:600;
font-size:14px;
">
Pesanan Baru
</div>

</div>

<div class="stat-card">

<div style="font-size:24px;">
⏳
</div>

<div class="stat-number">
<?php echo number_format($needProcess); ?>
</div>

<div
style="
color:#64748b;
font-weight:600;
font-size:14px;
">
Menunggu Diproses
</div>

</div>
</div>

<div class="actions">

<a
href="../seller/tambah-produk.php"
class="action-card">

<div style="font-size:32px;">
➕
</div>

<h3>
Tambah Produk
</h3>

<p>
Upload buku,
seragam,
atau perlengkapan sekolah bekas.
</p>

</a>

<a
href="../seller/produk.php"
class="action-card">

<div style="font-size:32px;">
📦
</div>

<h3>
Kelola Produk
</h3>

<p>
Edit ketersediaan,
harga,
dan informasi detail produk.
</p>

</a>

<a
href="../messages/index.php"
class="action-card">

<div style="font-size:32px;">
💬
</div>

<h3>
Chat Pembeli
</h3>

<p>
Balas pertanyaan,
proses negosiasi,
dan sepakati pengiriman.
</p>

</a>

</div>

<a
href="../logout.php"
class="logout-btn">

Keluar Akun

</a>

</div>

</body>
</html>