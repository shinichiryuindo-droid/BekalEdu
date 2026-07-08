<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php'); exit;
}

/* Only allow POST or GET with confirmation */
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) { header('Location: produk.php'); exit; }

/* Verify ownership */
$stmt = $conn->prepare("SELECT id, image FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: produk.php?error=not_found'); exit;
}

/* GET = confirmation page */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    include '../includes/sidebar-seller.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hapus Produk — Bekal Edu</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;background:var(--bg);padding:20px;">
    <div style="background:white;border-radius:20px;padding:40px;max-width:460px;width:100%;text-align:center;box-shadow:var(--shadow-lg);">
        <div style="font-size:56px;margin-bottom:16px;">🗑️</div>
        <h2 style="margin:0 0 12px;color:var(--text-dark);">Hapus Produk?</h2>
        <p style="color:var(--text-soft);margin:0 0 28px;line-height:1.6;">
            Produk yang dihapus tidak dapat dikembalikan. Apakah Anda yakin ingin menghapus produk ini?
        </p>
        <form method="post" style="display:flex;gap:12px;justify-content:center;">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit" class="btn btn-danger" style="padding:12px 28px;font-size:15px;">Ya, Hapus</button>
            <a href="produk.php" class="btn btn-ghost" style="padding:12px 28px;font-size:15px;">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
<?php
    exit;
}

/* POST = actually delete */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* Remove image file */
if (!empty($product['image'])) {

    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/media/' . $product['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

}

    $del = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
    $del->bind_param('ii', $id, $_SESSION['user_id']);
    $del->execute();

    header('Location: produk.php?deleted=1');
    exit;
}

header('Location: produk.php');