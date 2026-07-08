<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header('Location: ../login.php'); exit;
}

$buyer_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
SELECT
    o.*,
    p.name AS product_name,
    p.image AS product_image,
    p.id AS product_id,
    p.price AS product_price,
    p.seller_id,
    u.username AS seller_name,
    r.id AS review_id
FROM orders o
JOIN products p ON o.product_id = p.id
JOIN users u ON u.id = p.seller_id
LEFT JOIN product_ratings r
    ON r.product_id = o.product_id
    AND r.buyer_id = o.buyer_id
WHERE o.buyer_id = ?
ORDER BY o.created_at DESC
");

$stmt->bind_param("i", $buyer_id);

$stmt->execute();
$orders = $stmt->get_result();

$statusLabel = [
    'pending'    => ['label' => '⏳ Menunggu Pembayaran', 'cls' => 'st-pending'],
    'paid'       => ['label' => '✅ Sudah Dibayar',       'cls' => 'st-paid'],
    'diproses'   => ['label' => '🔧 Diproses',            'cls' => 'st-diproses'],
    'dikirim'    => ['label' => '🚚 Dikirim',             'cls' => 'st-dikirim'],
    'selesai'    => ['label' => '🎉 Selesai',             'cls' => 'st-selesai'],
    'shipped'    => ['label' => '🚚 Dikirim',             'cls' => 'st-dikirim'],
    'completed'  => ['label' => '🎉 Selesai',             'cls' => 'st-selesai'],
    'dibatalkan' => ['label' => '❌ Dibatalkan',          'cls' => 'st-batal'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pesanan Saya — Bekal Edu</title>
<link rel="stylesheet" href="../assets/css/style.css">
<style>
.orders-page { max-width: 960px; }

/* Page header */
.page-hero {
    background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #4f46e5 100%);
    border-radius: 20px;
    padding: 30px 36px;
    color: #fff;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.page-hero::after {
    content: '🛒';
    position: absolute;
    right: 28px; top: 50%;
    transform: translateY(-50%);
    font-size: 80px;
    opacity: .12;
    pointer-events: none;
}
.page-hero h1 { margin: 0; font-size: 26px; font-weight: 800; }
.page-hero p  { margin: 8px 0 0; opacity: .85; font-size: 14px; }

/* Filter tabs */
.filter-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.ftab {
    padding: 8px 18px;
    border-radius: 999px;
    border: 1.5px solid var(--border);
    background: var(--card);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s;
    color: var(--text-mid);
}
.ftab:hover, .ftab.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}

/* Order card */
.order-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid var(--border);
    box-shadow: 0 3px 14px rgba(0,0,0,.05);
    margin-bottom: 18px;
    overflow: hidden;
    transition: box-shadow .3s, transform .3s;
    animation: fadeUp .45s ease both;
}
@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.order-card:hover { box-shadow: 0 12px 32px rgba(0,0,0,.09); transform: translateY(-2px); }
.order-card:nth-child(2){ animation-delay:.05s; }
.order-card:nth-child(3){ animation-delay:.10s; }
.order-card:nth-child(4){ animation-delay:.15s; }
.order-card:nth-child(n+5){ animation-delay:.20s; }

/* Card top bar — status accent */
.order-accent { height: 4px; }
.st-pending .order-accent  { background: #f59e0b; }
.st-paid .order-accent     { background: #3b82f6; }
.st-diproses .order-accent { background: #8b5cf6; }
.st-dikirim .order-accent  { background: #06b6d4; }
.st-selesai .order-accent  { background: #10b981; }
.st-batal .order-accent    { background: #ef4444; }

.order-body {
    display: flex;
    gap: 20px;
    padding: 22px;
    align-items: flex-start;
    flex-wrap: wrap;
}

/* Product image */
.order-thumb-wrap { flex-shrink: 0; }
.order-thumb {
    width: 96px; height: 96px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
    background: var(--primary-light);
}
.order-thumb-ph {
    width: 96px; height: 96px;
    border-radius: 14px;
    background: var(--primary-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 38px;
    flex-shrink: 0;
}

/* Info section */
.order-info { flex: 1; min-width: 200px; }
.order-product-name {
    font-size: 17px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 6px;
    line-height: 1.35;
}
.order-seller {
    font-size: 13px;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 10px;
}
.order-details {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 13px;
    color: var(--text-mid);
}
.detail-chip {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 5px 11px;
    font-weight: 600;
}
.order-date { font-size: 12px; color: var(--text-soft); margin-top: 8px; }

/* Status badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 13px;
    font-weight: 700;
    white-space: nowrap;
}
.st-pending  .status-badge { background: #fef3c7; color: #92400e; }
.st-paid     .status-badge { background: #dbeafe; color: #1e40af; }
.st-diproses .status-badge { background: #ede9fe; color: #6d28d9; }
.st-dikirim  .status-badge { background: #cffafe; color: #155e75; }
.st-selesai  .status-badge { background: #d1fae5; color: #065f46; }
.st-batal    .status-badge { background: #fee2e2; color: #991b1b; }

/* Actions */
.order-actions {
    display: flex;
    flex-direction: column;
    gap: 9px;
    align-items: flex-end;
    flex-shrink: 0;
    min-width: 160px;
}

@media(max-width: 700px) {
    .order-body    { flex-direction: column; }
    .order-actions { align-items: flex-start; width: 100%; }
    .order-actions .act-btn { width: 100%; justify-content: center; }
}

.act-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 16px;
    border-radius: 11px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: transform .2s, box-shadow .2s, opacity .2s;
    border: none;
    font-family: inherit;
    white-space: nowrap;
}
.act-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.12); }

.btn-blue   { background: var(--primary); color: #fff; }
.btn-green  { background: #16a34a; color: #fff; }
.btn-purple { background: #7c3aed; color: #fff; }
.btn-gray   { background: var(--bg); color: var(--text-mid); border: 1.5px solid var(--border); }
.btn-gold   { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }

.btn-blue:hover   { color: #fff; }
.btn-green:hover  { color: #fff; }
.btn-purple:hover { color: #fff; }
.btn-gold:hover   { color: #fff; }

/* Total price highlight */
.order-total {
    font-size: 18px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 12px;
    text-align: right;
}

/* Already reviewed badge */
.reviewed-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #86efac;
    border-radius: 999px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 700;
}

/* Empty state */
.empty-state {
    background: #fff;
    border-radius: 20px;
    padding: 70px 40px;
    text-align: center;
    box-shadow: var(--shadow-sm);
    border: 1.5px solid var(--border);
}
.empty-state .ei { font-size: 60px; margin-bottom: 16px; }
.empty-state h3  { margin: 0 0 10px; font-size: 20px; }
.empty-state p   { color: var(--text-soft); margin: 0 0 22px; }

/* Summary bar */
.summary-bar {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 14px;
    margin-bottom: 24px;
}
.sum-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px 20px;
    border: 1.5px solid var(--border);
    box-shadow: var(--shadow-sm);
}
.sum-card .sum-num  { font-size: 24px; font-weight: 800; color: var(--primary); }
.sum-card .sum-lbl  { font-size: 12px; color: var(--text-soft); margin-top: 4px; }
</style>
</head>
<body>
<?php include '../includes/sidebar-buyer.php'; ?>

<div id="mainContent" class="main-content orders-page">

    <!-- Hero -->
    <div class="page-hero">
        <h1>Pesanan Saya</h1>
        <p>Pantau status, bayar, chat penjual, dan beri ulasan untuk semua pesananmu.</p>
    </div>

    <?php
    /* Collect summary stats */
    $allOrders   = [];
    $totalSpend  = 0;
    $countByStatus = [];
    while ($o = $orders->fetch_assoc()) {
        $allOrders[] = $o;
        $totalSpend += $o['total_price'];
        $st = $o['status'];
        $countByStatus[$st] = ($countByStatus[$st] ?? 0) + 1;
    }
    $total = count($allOrders);
    ?>

    <!-- Summary -->
    <?php if ($total > 0): ?>
    <div class="summary-bar">
        <div class="sum-card">
            <div class="sum-num"><?= $total ?></div>
            <div class="sum-lbl">Total Pesanan</div>
        </div>
        <div class="sum-card">
            <div class="sum-num" style="font-size:18px;">Rp <?= number_format($totalSpend, 0, ',', '.') ?></div>
            <div class="sum-lbl">Total Pengeluaran</div>
        </div>
        <div class="sum-card">
            <div class="sum-num" style="color:#f59e0b;"><?= $countByStatus['pending'] ?? 0 ?></div>
            <div class="sum-lbl">Menunggu Bayar</div>
        </div>
        <div class="sum-card">
            <div class="sum-num" style="color:#10b981;"><?= ($countByStatus['selesai'] ?? 0) + ($countByStatus['completed'] ?? 0) ?></div>
            <div class="sum-lbl">Selesai</div>
        </div>
    </div>

    <!-- Filter tabs -->
    <div class="filter-tabs">
        <button class="ftab active" onclick="filterOrders('all', this)">Semua (<?= $total ?>)</button>
        <?php if (!empty($countByStatus['pending'])): ?>
        <button class="ftab" onclick="filterOrders('pending', this)">⏳ Menunggu (<?= $countByStatus['pending'] ?>)</button>
        <?php endif; ?>
        <?php if (!empty($countByStatus['paid'])): ?>
        <button class="ftab" onclick="filterOrders('paid', this)">✅ Dibayar (<?= $countByStatus['paid'] ?>)</button>
        <?php endif; ?>
        <?php if ((!empty($countByStatus['dikirim'])) || !empty($countByStatus['shipped'])): ?>
        <button class="ftab" onclick="filterOrders('dikirim', this)">🚚 Dikirim</button>
        <?php endif; ?>
        <?php if ((!empty($countByStatus['selesai'])) || !empty($countByStatus['completed'])): ?>
        <button class="ftab" onclick="filterOrders('selesai', this)">🎉 Selesai</button>
        <?php endif; ?>
    </div>

    <!-- Order list -->
    <div id="orderList">
    <?php foreach ($allOrders as $idx => $order): ?>
    <?php
        $st     = $order['status'];
        $stInfo = $statusLabel[$st] ?? ['label' => ucfirst($st), 'cls' => 'st-pending'];
        $cls    = $stInfo['cls'];
$canReview = in_array($st, [
    'selesai',
    'completed'
]);
        $isPending = $st === 'pending';
        $hasReview = !empty($order['review_id']);
        $animDelay = min($idx * 0.05, 0.3);
    ?>
    <div class="order-card <?= $cls ?>" data-status="<?= htmlspecialchars($st) ?>" style="animation-delay:<?= $animDelay ?>s;">
        <div class="order-accent"></div>
        <div class="order-body">

            <!-- Image -->
            <?php if (!empty($order['product_image'])): ?>
            <img src="<?= htmlspecialchars('../media/' . $order['product_image']) ?>"
                 class="order-thumb" alt="<?= htmlspecialchars($order['product_name']) ?>"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
            <div class="order-thumb-ph" style="display:none;">📦</div>
            <?php else: ?>
            <div class="order-thumb-ph">📦</div>
            <?php endif; ?>

            <!-- Info -->
            <div class="order-info">
                <div class="order-product-name"><?= htmlspecialchars($order['product_name']) ?></div>
                <div class="order-seller">👤 <?= htmlspecialchars($order['seller_name']) ?></div>
                <div class="order-details">
                    <span class="detail-chip">🔢 <?= $order['quantity'] ?> item</span>
                    <span class="detail-chip">💰 Rp <?= number_format($order['total_price'], 0, ',', '.') ?></span>
                </div>
                <div class="order-date">📅 <?= date('d M Y, H:i', strtotime($order['created_at'])) ?> WIB</div>
            </div>

            <!-- Actions -->
            <div class="order-actions">
                <span class="status-badge"><?= $stInfo['label'] ?></span>
                <div class="order-total">Rp <?= number_format($order['total_price'], 0, ',', '.') ?></div>

                <!-- Lihat Produk -->
                <a href="../buyer/produk-detail.php?id=<?= $order['product_id'] ?>" class="act-btn btn-gray">
                    👁️ Lihat Produk
                </a>

                <!-- Chat Penjual -->
                <a href="../messages/cc.php?user_id=<?= $order['seller_id'] ?>" class="act-btn btn-blue">
                    💬 Chat Penjual
                </a>

                <!-- Bayar (jika pending) -->
                <?php if ($isPending): ?>
                <a href="pembayaran.php?order_id=<?= $order['id'] ?>" class="act-btn btn-green">
                    💳 Bayar Sekarang
                </a>
                <?php endif; ?>

                <!-- Review (jika selesai) -->
                <?php if ($canReview): ?>
                    <?php if ($hasReview): ?>
                    <span class="reviewed-badge">⭐ Sudah Diulas</span>
                    <?php else: ?>
                    <a href="submit-review.php?order_id=<?= $order['id'] ?>" class="act-btn btn-gold">
                        ⭐ Beri Ulasan
                    </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <?php endforeach; ?>
    </div><!-- /orderList -->

    <?php else: ?>
    <div class="empty-state">
        <div class="ei">📦</div>
        <h3>Belum ada pesanan</h3>
        <p>Kamu belum pernah melakukan pembelian. Yuk mulai belanja!</p>
        <a href="../marketplace.php" class="act-btn btn-blue" style="display:inline-flex;margin:0 auto;">
            🛒 Ke Marketplace
        </a>
    </div>
    <?php endif; ?>

</div><!-- /mainContent -->

<script>
function filterOrders(status, btn) {
    document.querySelectorAll('.ftab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.order-card').forEach(card => {
        if (status === 'all') {
            card.style.display = '';
        } else if (status === 'dikirim') {
            const s = card.dataset.status;
            card.style.display = (s === 'dikirim' || s === 'shipped') ? '' : 'none';
        } else if (status === 'selesai') {
            const s = card.dataset.status;
            card.style.display = (s === 'selesai' || s === 'completed') ? '' : 'none';
        } else {
            card.style.display = card.dataset.status === status ? '' : 'none';
        }
    });
}

/* Sidebar sync */
(function(){
    const sb  = document.getElementById('sidebar');
    const tog = document.getElementById('sidebarToggle');
    const mc  = document.getElementById('mainContent');
    if (!sb || !tog || !mc) return;
    function sync(){ mc.classList.toggle('expanded', sb.classList.contains('closed')); }
    sync();
    tog.addEventListener('click', () => setTimeout(sync, 20));
})();
</script>
</body>
</html>