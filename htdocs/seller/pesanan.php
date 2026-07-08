<?php
session_start();
require_once '../includes/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role']!='seller'){
    header('Location: ../login.php');
    exit;
}

$currentSellerId=$_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD']=='POST'){

    $orderId=(int)($_POST['order_id'] ?? 0);

    if(isset($_POST['verifikasi_pembayaran'])){

        $stmt = $conn->prepare("
UPDATE orders
SET
    payment_status='sudah_dibayar',
    payment_verified_at=NOW(),
    payment_verified_by=?,
    status='diproses'
WHERE id=?
AND seller_id=?
");

$stmt->bind_param(
"iii",
$currentSellerId,
$orderId,
$currentSellerId
);
        

        $stmt->execute();

    }

    elseif(isset($_POST['status'])){

        $status=$_POST['status'];

        $allowed=[
            'pending',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan'
        ];

        if(in_array($status,$allowed)){

            $stmt=$conn->prepare(
                "UPDATE orders
                 SET status=?
                 WHERE id=?
                 AND seller_id=?"
            );

            $stmt->bind_param(
                "sii",
                $status,
                $orderId,
                $currentSellerId
            );

            $stmt->execute();

        }

    }

}

$stmt=$conn->prepare("SELECT o.*,p.name AS product_name,u.username AS buyer_name,u.full_name,u.address,u.phone FROM orders o JOIN products p ON p.id=o.product_id JOIN users u ON u.id=o.buyer_id WHERE o.seller_id=? ORDER BY o.created_at DESC");
$stmt->bind_param("i",$currentSellerId);
$stmt->execute();
$orders=$stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Pesanan Masuk</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
body{margin:0;background:#f5f7fb;font-family:Arial}
.order-card{background:#fff;padding:25px;border-radius:20px;margin-bottom:20px;box-shadow:0 8px 25px rgba(0,0,0,.05);display:flex;flex-wrap:wrap;justify-content:space-between;gap:20px}
.main-content{margin-left:270px;padding:30px}.payment-box{background:#f8fafc;border:1px solid #e2e8f0;padding:15px;border-radius:12px;min-width:300px}
.status-select,.update-btn{width:100%;padding:10px;border-radius:10px}.update-btn{background:#2563eb;color:#fff;border:none;cursor:pointer}
.chat-btn{display:inline-block;margin-top:12px;padding:10px 18px;background:#f3f4f6;color:#111;text-decoration:none;border-radius:10px}
</style></head><body>
<?php include '../includes/sidebar-seller.php'; ?>
<div class="main-content">
<h1>🛒 Pesanan Masuk</h1>
<?php if($orders->num_rows): while($order=$orders->fetch_assoc()): ?>
<div class="order-card">
<div style="flex:2;min-width:250px">
<h2><?=htmlspecialchars($order['product_name'])?></h2>
<p>Pembeli: <?=htmlspecialchars($order['buyer_name'])?></p>
<p>Nama: <?=htmlspecialchars($order['full_name']?:'-')?></p>
<p>Telepon: <?=htmlspecialchars($order['phone']?:'-')?></p>
<p>Alamat:<br><?=nl2br(htmlspecialchars($order['address']?:'-'))?></p>
<p>Jumlah: <?=$order['quantity']?></p>
<p>Total: Rp <?=number_format($order['total_price'],0,',','.')?></p>
<a class="chat-btn" href="/messages/cc.php?user_id=<?=$order['buyer_id']?>">💬 Chat Pembeli</a>
</div>
<div class="payment-box">

<h3 style="margin-top:0;color:#374151;">
Status Pembayaran
</h3>

<?php

$paymentStatus = $order['payment_status'];
$paymentProof = $order['payment_proof'];
?>

<?php if($paymentStatus == 'menunggu_verifikasi'): ?>

<div
style="
background:#fef3c7;
padding:12px;
border-radius:10px;
margin-bottom:15px;
font-weight:bold;
color:#92400e;
">

⏳ Menunggu Verifikasi

</div>

<?php if(!empty($paymentProof)): ?>

<img
src="../media/payments/<?php echo htmlspecialchars($paymentProof); ?>"
style="
width:100%;
max-width:320px;
border-radius:12px;
border:1px solid #ddd;
margin-bottom:12px;
cursor:pointer;
"
onclick="window.open(this.src)">

<br>

<a
href="../media/payments/<?php echo htmlspecialchars($paymentProof); ?>"
target="_blank"
class="chat-btn">

🔍 Buka Gambar Asli

</a>

<?php else: ?>

<div
style="
background:#fee2e2;
padding:10px;
border-radius:10px;
color:#991b1b;
">

Bukti transfer belum ditemukan.

</div>

<?php endif; ?>

<br><br>

<form method="post">

<input
type="hidden"
name="order_id"
value="<?php echo $order['id']; ?>">

<button
type="submit"
name="verifikasi_pembayaran"
class="update-btn"
style="
background:#10b981;
width:100%;
"
onclick="return confirm('Dana sudah masuk ke rekening Anda?');">

✅ Setujui Pembayaran

</button>

</form>

<?php elseif($paymentStatus == 'sudah_dibayar'): ?>

<div
style="
background:#dcfce7;
padding:12px;
border-radius:10px;
color:#166534;
font-weight:bold;
">

✅ Pembayaran Sudah Diverifikasi

</div>

<?php if(!empty($paymentProof)): ?>

<br>

<img
src="../media/payments/<?php echo htmlspecialchars($paymentProof); ?>"
style="
width:100%;
max-width:320px;
border-radius:12px;
border:1px solid #ddd;
">

<?php endif; ?>

<?php else: ?>

<div
style="
background:#fee2e2;
padding:12px;
border-radius:10px;
color:#991b1b;
font-weight:bold;
">

❌ Belum Dibayar

</div>

<?php endif; ?>

<hr>

<h3>Status Pengiriman</h3>

<form method="post">

<input
type="hidden"
name="order_id"
value="<?php echo $order['id']; ?>">

<select
name="status"
class="status-select"
style="width:100%;margin-bottom:10px;">

<option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>

<option value="diproses" <?php if($order['status']=='diproses') echo 'selected'; ?>>Diproses</option>

<option value="dikirim" <?php if($order['status']=='dikirim') echo 'selected'; ?>>Dikirim</option>

<option value="selesai" <?php if($order['status']=='selesai') echo 'selected'; ?>>Selesai</option>

<option value="dibatalkan" <?php if($order['status']=='dibatalkan') echo 'selected'; ?>>Dibatalkan</option>

</select>

<button
type="submit"
class="update-btn"
style="width:100%;">

Update Pengiriman

</button>

</form>

</div>
    <?php endwhile; ?>

<?php else: ?>

<p>Belum ada pesanan masuk.</p>

<?php endif; ?>

</div>

</body>
</html>
