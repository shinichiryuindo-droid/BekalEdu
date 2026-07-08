<?php
session_start();
require_once 'includes/config.php';

$search   = trim($_GET['search']   ?? '');
$category = trim($_GET['category'] ?? '');
$sort     = trim($_GET['sort']     ?? 'terbaru');

/*
|--------------------------------------------------------------------------
| Build Query
|--------------------------------------------------------------------------
*/
$where  = ['p.stock > 0'];
$params = [];
$types  = '';

if (!empty($search)) {
    $where[]  = '(p.name LIKE ? OR p.description LIKE ? OR u.username LIKE ?)';
    $kw       = "%$search%";
    $params[] = $kw;
    $params[] = $kw;
    $params[] = $kw;
    $types   .= 'sss';
}

if (!empty($category)) {
    $where[]  = 'p.category = ?';
    $params[] = $category;
    $types   .= 's';
}

$orderBy = match($sort) {
    'termurah'  => 'p.price ASC',
    'termahal'  => 'p.price DESC',
    'terlama'   => 'p.created_at ASC',
    default     => 'p.created_at DESC',
};

$whereSQL = implode(' AND ', $where);

/* Pagination */
$perPage     = 12;
$page        = max(1, intval($_GET['page'] ?? 1));
$offset      = ($page - 1) * $perPage;

/* Count total */
$countSQL = "SELECT COUNT(*) AS total
             FROM products p
             JOIN users u ON u.id = p.seller_id
             WHERE $whereSQL";
$countStmt = $conn->prepare($countSQL);
if (!empty($params)) $countStmt->bind_param($types, ...$params);
$countStmt->execute();
$totalRows = $countStmt->get_result()->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $perPage);

/* Fetch products */
$sql = "SELECT p.*, u.username AS seller_name
        FROM products p
        JOIN users u ON u.id = p.seller_id
        WHERE $whereSQL
        ORDER BY $orderBy
        LIMIT ? OFFSET ?";

$allTypes  = $types . 'ii';
$allParams = array_merge($params, [$perPage, $offset]);

$stmt = $conn->prepare($sql);
$stmt->bind_param($allTypes, ...$allParams);
$stmt->execute();
$products = $stmt->get_result();

/* Categories from DB (or fallback list) */
$categories = ['Buku Pelajaran','Seragam','Tas Sekolah','Kalkulator','Alat Tulis','Elektronik','Lainnya'];

/* Logged-in role */
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    
       <style>

.marketplace{
    max-width:1300px;
    margin:40px auto 40px 300px;
    padding:20px;
    transition:.35s ease;
}

.marketplace.expanded{
    margin-left:40px;
}

@media(max-width:992px){

    .marketplace,
    .marketplace.expanded{
        margin-left:auto;
        margin-right:auto;
    }

}

</style>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Marketplace — Bekal Edu</title>
<link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<?php
if ($role === 'buyer') {
    include 'includes/sidebar-buyer.php';
} elseif ($role === 'seller') {
    include 'includes/sidebar-seller.php';
} elseif (in_array($role, ['partner','pending_partner'])) {
    include 'includes/sidebar-partner.php';
} else {
    include 'includes/topbar.php';
}
?>

     
<div id="mainContent" class="<?php echo isset($_SESSION['user_id']) ? 'main-content' : 'main-content no-sidebar'; ?> marketplace">

    <!-- Header -->
    <div class="mp-header">
        <h1>Marketplace Sekolah Bekas</h1>
        <p>Temukan buku, seragam, dan perlengkapan sekolah berkualitas dengan harga terjangkau</p>
    </div>

    <!-- Search + Filter bar -->
    <div class="mp-search-bar">
        <form method="get" class="mp-search-bar" style="padding:0;box-shadow:none;margin:0;flex:1;gap:10px;background:none;display:flex;flex-wrap:wrap;align-items:center;">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">
            <div style="display:flex;gap:10px;flex:1;min-width:220px;">
                <input type="text" name="search"
                       class="mp-search-input"
                       placeholder="Cari produk, penjual..."
                       value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="mp-search-btn">🔍 Cari</button>
            </div>
            <div class="mp-filters">
                <select name="sort" class="mp-select" onchange="this.form.submit()">
                    <option value="terbaru"  <?= $sort==='terbaru'  ? 'selected':'' ?>>Terbaru</option>
                    <option value="termurah" <?= $sort==='termurah' ? 'selected':'' ?>>Termurah</option>
                    <option value="termahal" <?= $sort==='termahal' ? 'selected':'' ?>>Termahal</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Category pills -->
    <div class="category-row">
        <a href="marketplace.php?search=<?= urlencode($search) ?>&sort=<?= $sort ?>"
           class="cat-pill <?= $category==='' ? 'active':'' ?>">
            🏷️ Semua
        </a>
        <?php foreach ($categories as $cat): ?>
        <a href="marketplace.php?search=<?= urlencode($search) ?>&category=<?= urlencode($cat) ?>&sort=<?= $sort ?>"
           class="cat-pill <?= $category===$cat ? 'active':'' ?>">
            <?= htmlspecialchars($cat) ?>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Meta row -->
    <div class="mp-meta">
        <span>
            <?php if (!empty($search) || !empty($category)): ?>
                Hasil untuk
                <?= !empty($search)   ? '"'.htmlspecialchars($search).'"' : '' ?>
                <?= !empty($category) ? 'kategori <strong>'.htmlspecialchars($category).'</strong>' : '' ?>
                — <strong><?= number_format($totalRows) ?> produk</strong>
            <?php else: ?>
                <strong><?= number_format($totalRows) ?> produk</strong> tersedia
            <?php endif; ?>
        </span>
        <?php if (!empty($search) || !empty($category)): ?>
        <a href="marketplace.php" style="color:var(--text-soft);font-size:13px;">✕ Reset filter</a>
        <?php endif; ?>
    </div>

    <!-- Product grid -->
    <?php if ($products->num_rows > 0): ?>
    <div class="product-grid">
        <?php while ($p = $products->fetch_assoc()): ?>
        <?php
            $stockStatus = $p['stock'] > 5 ? 'in-stock'
                         : ($p['stock'] > 0 ? 'low-stock' : 'no-stock');
            $stockText   = $p['stock'] > 5 ? '✅ Stok tersedia'
                         : ($p['stock'] > 0 ? "⚠️ Stok sisa {$p['stock']}" : '❌ Habis');
        ?>
        <div class="product-card">
            <div class="product-image-wrap">
                <?php if (!empty($p['image'])): ?>
<img src="../media/<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
                <?php else: ?>
                    <div class="product-image-placeholder">
                        <?= match($p['category'] ?? '') {
                            'Buku Pelajaran' => '📖',
                            'Seragam'        => '👕',
                            'Tas Sekolah'    => '🎒',
                            'Kalkulator'     => '🧮',
                            'Alat Tulis'     => '✏️',
                            'Elektronik'     => '💻',
                            default          => '📦'
                        } ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($p['category'])): ?>
                <span class="product-badge"><?= htmlspecialchars($p['category']) ?></span>
                <?php endif; ?>
            </div>

            <div class="product-content">
                <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                <div class="product-price">Rp <?= number_format($p['price'], 0, ',', '.') ?></div>
                <div class="product-seller">
                    <span>👤</span><?= htmlspecialchars($p['seller_name']) ?>
                </div>
                <div class="product-stock <?= $stockStatus ?>"><?= $stockText ?></div>

                <div class="product-actions">
                    <a href="/buyer/produk-detail.php?id=<?= $p['id'] ?>" class="btn btn-primary">Lihat Detail</a>
                    <?php if ($role === 'buyer'): ?>
                    <a href="/messages/cc.php?user_id=<?= $p['seller_id'] ?>"
                       class="btn btn-ghost">💬 Chat</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page'=>$page-1])) ?>" class="pg-btn">← Prev</a>
        <?php endif; ?>

        <?php for ($i = max(1,$page-2); $i <= min($totalPages,$page+2); $i++): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page'=>$i])) ?>"
           class="pg-btn <?= $i===$page ? 'active':'' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
        <a href="?<?= http_build_query(array_merge($_GET, ['page'=>$page+1])) ?>" class="pg-btn">Next →</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- Empty state -->
    <div class="empty-state">
        <div class="empty-icon">📦</div>
        <h3>Tidak ada produk ditemukan</h3>
        <p>
            <?= !empty($search) || !empty($category)
                ? 'Coba gunakan kata kunci lain atau hapus filter.'
                : 'Belum ada produk yang tersedia saat ini.' ?>
        </p>
        <?php if (!empty($search) || !empty($category)): ?>
        <a href="marketplace.php" class="btn btn-primary" style="display:inline-block;width:auto;padding:12px 24px;">Lihat Semua Produk</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Stats strip -->
    <div class="mp-stats">
        <div class="mp-stat-card">
            <h2><?= number_format($totalRows) ?>+</h2>
            <p>Produk Tersedia</p>
        </div>
        <?php
        $sellerCount = $conn->query("SELECT COUNT(DISTINCT seller_id) AS c FROM products WHERE stock>0")->fetch_assoc()['c'];
        $savedCount  = $conn->query("SELECT SUM(price) AS s FROM products WHERE stock>0")->fetch_assoc()['s'];
        ?>
        <div class="mp-stat-card">
            <h2><?= number_format($sellerCount) ?>+</h2>
            <p>Penjual Aktif</p>
        </div>
        <div class="mp-stat-card">
            <h2>Rp <?= number_format(($savedCount ?? 0) / 1000, 0, ',', '.') ?>K</h2>
            <p>Total Nilai Produk</p>
        </div>
        <div class="mp-stat-card">
            <h2>100%</h2>
            <p>Bebas Biaya Platform</p>
        </div>
    </div>

</div><!-- /mainContent -->

<script>
/* Sidebar toggle sync */

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const sidebar =
            document.getElementById('sidebar');

        const toggleBtn =
            document.getElementById('sidebarToggle');

        const content =
            document.getElementById('mainContent');

        if(
            !sidebar ||
            !toggleBtn ||
            !content
        ){
            return;
        }

        function updateLayout(){

            if(
                sidebar.classList.contains(
                    'closed'
                )
            ){

                content.classList.add(
                    'expanded'
                );

            }else{

                content.classList.remove(
                    'expanded'
                );

            }

        }

        updateLayout();

        toggleBtn.addEventListener(
            'click',
            function(){

                setTimeout(
                    updateLayout,
                    20
                );

            }
        );

    }
);

</script>
    
    </body>
</html>