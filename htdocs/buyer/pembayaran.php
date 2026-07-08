<?php
session_start();
require_once '../includes/config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer'){
    header('Location: ../login.php');
    exit;
}

$buyerId = $_SESSION['user_id'];
$orderId = intval($_GET['order_id'] ?? ($_GET['id'] ?? 0));

// Ambil Pesanan + Info Bank Penjual
$stmt = $conn->prepare("SELECT o.*, u.nama_bank, u.no_rekening, u.username as nama_toko FROM orders o JOIN users u ON o.seller_id = u.id WHERE o.id = ? AND o.buyer_id = ?");
$stmt->bind_param("ii", $orderId, $buyerId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if(!$order){
    die("Pesanan tidak ditemukan.");
}

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!isset($_FILES['payment_proof']) || $_FILES['payment_proof']['error'] != 0){
        $message = '<p class="bekal-error">Pilih bukti pembayaran terlebih dahulu.</p>';
    } else {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['payment_proof']['name'], PATHINFO_EXTENSION));

        if(!in_array($ext, $allowed)){
            $message = '<p class="bekal-error">Format gambar tidak didukung.</p>';
        } else {
            $filename = 'payment_' . $orderId . '_' . time() . '.' . $ext;
            
            // PATH UPLOAD SESUAI PERMINTAAN
            $destination = '../media/payments/' . $filename;
            
            // Cek jika folder belum ada
            if(!is_dir('../media/payments/')){
                mkdir('../media/payments/', 0777, true);
            }

            if(move_uploaded_file($_FILES['payment_proof']['tmp_name'], $destination)){
                $update = $conn->prepare("
UPDATE orders
SET
    payment_proof=?,
    payment_status='menunggu_verifikasi',
    payment_uploaded_at=NOW()
WHERE id=?
");

$update->bind_param("si", $filename, $orderId);
$update->execute();
                
                $message = '<p style="color:green;font-weight:bold;">Bukti pembayaran berhasil dikirim. Menunggu verifikasi penjual.</p>';
                // Update local variable agar UI langsung berubah
                $order['payment_status'] = 'menunggu_verifikasi';
$order['payment_proof'] = $filename; 
            } else {
                $message = '<p class="bekal-error">Gagal mengupload file.</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/sidebar-buyer.php'; ?>

<div class="main" id="mainContent">
    <h1>💳 Pembayaran Pesanan #<?php echo $orderId; ?></h1>
    <?php echo $message; ?>

    <div class="form-card" style="max-width: 600px;">
        <h2>Total Pembayaran</h2>
        <h1 style="color: #2563eb;">Rp <?php echo number_format($order['total_price'], 0, ',', '.'); ?></h1>
        <hr>

        <h3>Transfer ke rekening berikut:</h3>
        <p>Toko: <strong><?php echo htmlspecialchars($order['nama_toko']); ?></strong></p>
        
        <div style="background: #eff6ff; padding: 20px; border-radius: 12px; margin: 20px 0;">
            <div style="font-size:28px; font-weight:bold; color: #1e3a8a;">
                <?php echo htmlspecialchars($order['no_rekening'] ?? 'Belum Diatur'); ?>
            </div>
            <p style="margin-top: 5px; font-size: 18px; font-weight: 600; color: #3b82f6;">
                Bank <?php echo htmlspecialchars($order['nama_bank'] ?? 'Bekal Edu'); ?>
            </p>
        </div>
        <hr>

        <?php if(
    $order['payment_status']=='belum_bayar'
): ?>
            <form method="post" enctype="multipart/form-data">
                <label style="font-weight: 600;">Upload Bukti Pembayaran (JPG/PNG/WEBP)</label><br><br>
                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.webp" required style="display:block; margin-bottom: 20px;">
                <button class="btn btn-primary" type="submit" style="padding: 12px 20px;">Kirim Bukti Pembayaran</button>
            </form>
        <?php else: ?>
            <div style="padding: 15px; background: #fef3c7; color: #92400e; border-radius: 10px; font-weight: bold; text-align: center;">
                Status: <?php echo str_replace('_', ' ', strtoupper($order['payment_status'])); ?>
            </div>
        <?php endif; ?>
        
        <br><br>
        <a href="pesanan-saya.php" style="text-decoration: none; color: #64748b; font-weight: 600;">&larr; Kembali ke Pesanan Saya</a>
    </div>
</div>
</body>
</html>