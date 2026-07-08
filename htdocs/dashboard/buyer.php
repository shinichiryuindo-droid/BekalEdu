<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header('Location: ../login.php');
    exit;
}

require_once '../includes/config.php';

$userId = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'Pelajar';

/* Hitung Pesanan Belum Dibayar (Status Pending) */
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE buyer_id = ? AND (payment_status IS NULL OR payment_status = 'pending' OR status = 'pending')");
$stmt->bind_param("i", $userId);
$stmt->execute();
$unpaidOrders = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/* Menunggu Dikirim */
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE buyer_id = ? AND status = 'diproses'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$processingOrders = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/* Sedang Dikirim */
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE buyer_id = ? AND status = 'dikirim'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$shippingOrders = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/* Pesanan Dibatalkan */
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders WHERE buyer_id = ? AND status = 'dibatalkan'");
$stmt->bind_param("i", $userId);
$stmt->execute();
$cancelledOrders = $stmt->get_result()->fetch_assoc()['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Pelajar - Bekal Edu</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/sidebar-buyer.php'; ?>

<div class="main" id="mainContent">

    <div class="header-card">
        <h1>Halo, <?php echo htmlspecialchars($username); ?> 👋</h1>
        <p>Selamat datang di dashboard pelajar Bekal Edu. Cari perlengkapan sekolah bekas dan pantau status pesanan Anda.</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div style="font-size:24px;">🛒</div>
            <div class="stat-number"><?php echo number_format($unpaidOrders); ?></div>
            <div style="color:#ef4444; font-weight:600; font-size:14px;">Pesanan Belum Dibayar</div>
        </div>
        <div class="stat-card">
            <div style="font-size:24px;">⏳</div>
            <div class="stat-number"><?php echo number_format($processingOrders); ?></div>
            <div style="color:#64748b; font-weight:600; font-size:14px;">Menunggu Dikirim</div>
        </div>
        <div class="stat-card">
            <div style="font-size:24px;">🚚</div>
            <div class="stat-number"><?php echo number_format($shippingOrders); ?></div>
            <div style="color:#64748b; font-weight:600; font-size:14px;">Sedang Dikirim</div>
        </div>
        <div class="stat-card">
            <div style="font-size:24px;">❌</div>
            <div class="stat-number"><?php echo number_format($cancelledOrders); ?></div>
            <div style="color:#64748b; font-weight:600; font-size:14px;">Pesanan Dibatalkan</div>
        </div>
    </div>

    <div class="actions">
        <a href="../marketplace/index.php" class="action-card">
            <div style="font-size:32px;">🛍️</div>
            <h3>Marketplace</h3>
            <p>Cari dan beli perlengkapan sekolah bekas dengan harga terjangkau.</p>
        </a>
        <a href="../buyer/pesanan-saya.php" class="action-card">
            <div style="font-size:32px;">📦</div>
            <h3>Pesanan Saya</h3>
            <p>Pantau status seluruh pesanan dan lakukan pembayaran pesanan Anda.</p>
        </a>
        <a href="../profile.php" class="action-card">
            <div style="font-size:32px;">👤</div>
            <h3>Profil Saya</h3>
            <p>Perbarui informasi akun dan data akademik Anda.</p>
        </a>
    </div>

    <a href="../logout.php" class="logout-btn">Keluar Akun</a>
</div>
</body>
</html>