<?php

session_start();
require_once '../includes/config.php';

if(
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'partner'
){
    header('Location: ../login.php');
    exit;
}

$userId =
$_SESSION['user_id'];

$username =
$_SESSION['username'] ?? 'Mitra';

/*
|--------------------------------------------------------------------------
| TOTAL BEASISWA
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT COUNT(*) total
     FROM scholarships
     WHERE partner_id = ?"
);

$stmt->bind_param(
    "i",
    $userId
);

$stmt->execute();

$beasiswaAktif =
$stmt
->get_result()
->fetch_assoc()['total'];

/*
|--------------------------------------------------------------------------
| TOTAL CHAT
|--------------------------------------------------------------------------
*/

$stmt = $conn->prepare(
    "SELECT COUNT(*) total
     FROM conversations
     WHERE user1_id = ?
     OR user2_id = ?"
);

$stmt->bind_param(
    "ii",
    $userId,
    $userId
);

$stmt->execute();

$totalChat =
$stmt
->get_result()
->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - Bekal Edu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/sidebar-partner.php'; ?>

<div class="main" id="mainContent">
    <div class="header-card">
        <h1>Halo, <?php echo htmlspecialchars($username); ?> 🏛️</h1>
        <p>Kelola program beasiswa, pantau pelamar, dan jangkau lebih banyak pelajar melalui platform terintegrasi Bekal Edu.</p>
    </div>

    <div class="stats">

    <div class="stat-card">

        <div style="font-size:24px;">
            🎓
        </div>

        <div class="stat-number">
            <?php echo $beasiswaAktif; ?>
        </div>

        <div style="color:#64748b;font-weight:600;font-size:14px;">
            Beasiswa Aktif
        </div>

    </div>

    <div class="stat-card">

        <div style="font-size:24px;">
            💬
        </div>

        <div class="stat-number">
            <?php echo $totalChat; ?>
        </div>

        <div style="color:#64748b;font-weight:600;font-size:14px;">
            Total Chat
        </div>

    </div>

    <div class="stat-card">

        <div style="font-size:24px;">
            ⭐
        </div>

        <div class="stat-number">
            ✓
        </div>

        <div style="color:#64748b;font-weight:600;font-size:14px;">
            Terverifikasi
        </div>

    </div>

</div>
    
    

    <div class="actions">
        <a href="../partner/tambah-beasiswa.php" class="action-card">
            <div style="font-size:32px;">➕</div><h3>Tambah Beasiswa</h3><p>Publikasikan informasi program bantuan baru untuk dijangkau pelajar.</p>
        </a>
        <a href="../partner/beasiswa.php" class="action-card">
            <div style="font-size:32px;">📋</div><h3>Kelola Program</h3><p>Lihat, verifikasi, dan edit program beasiswa yang sedang berjalan.</p>
        </a>
        <a href="../messages/index.php" class="action-card">
            <div style="font-size:32px;">💬</div><h3>Pesan Pelamar</h3><p>Berkomunikasi langsung dengan kandidat yang berminat.</p>
        </a>
    </div>

    <a href="../logout.php" class="logout-btn">Keluar Akun</a>
</div>
</body>
</html>