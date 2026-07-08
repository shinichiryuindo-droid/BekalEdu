<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php'); exit;
}

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: produk.php'); exit; }

/* Verify ownership */
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param('ii', $id, $_SESSION['user_id']);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) { header('Location: produk.php'); exit; }

$message  = '';
$msgClass = 'alert-error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']        ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price']   ?? 0);
    $stock       = intval($_POST['stock']     ?? 1);
    $category    = trim($_POST['category']    ?? '');

    if (empty($name) || $price <= 0) {
        $message = 'Nama produk dan harga wajib diisi.';
    } else {
        $imagePath = $product['image']; /* keep existing */

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $allowed = ['jpg','jpeg','png','webp'];
            $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed) && $_FILES['image']['size'] <= 5 * 1024 * 1024) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/media/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

                $newName = 'product_' . uniqid() . '.' . $ext;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName)) {
                    /* Delete old image */
                    if (!empty($product['image'])) {

    $oldImage = $_SERVER['DOCUMENT_ROOT'] . '/media/' . $product['image'];

    if (file_exists($oldImage)) {
        unlink($oldImage);
    }

}
$imagePath = $newName;
                }
            }
        }

        $upd = $conn->prepare(
            "UPDATE products SET name=?, description=?, price=?, stock=?, category=?, image=?
             WHERE id=? AND seller_id=?"
        );
        $upd->bind_param('ssdissii',
            $name, $description, $price, $stock, $category, $imagePath,
            $id, $_SESSION['user_id']
        );

        if (!$upd) {
            /* Fallback without category */
            $upd = $conn->prepare(
                "UPDATE products SET name=?, description=?, price=?, stock=?, image=?
                 WHERE id=? AND seller_id=?"
            );
            $upd->bind_param('ssdiis',
                $name, $description, $price, $stock, $imagePath,
                $id, $_SESSION['user_id']
            );
        }

        if ($upd->execute()) {
            $message  = '✅ Produk berhasil diperbarui!';
            $msgClass = 'alert-success';
            /* Refresh */
            $stmt->execute();
            $product = $stmt->get_result()->fetch_assoc();
        } else {
            $message = 'Gagal memperbarui produk: ' . $conn->error;
        }
    }
}

$categories = ['Buku Pelajaran','Seragam','Tas Sekolah','Kalkulator','Alat Tulis','Elektronik','Lainnya'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Produk — Bekal Edu</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include '../includes/sidebar-seller.php'; ?>

<div id="mainContent" class="main-content">

    <a href="produk.php" class="back-link">← Produk Saya</a>

    <div class="form-card">
        <h1>✏️ Edit Produk</h1>
        <p>Perbarui informasi produk Anda</p>

        <?php if ($message): ?>
        <div class="alert <?= $msgClass ?>"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Produk *</label>
                <input type="text" name="name" required
                       value="<?= htmlspecialchars($product['name']) ?>">
            </div>

            <div class="form-group">
                <label>Kategori</label>
                <select name="category">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"
                        <?= ($product['category'] ?? '') === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Harga (Rp) *</label>
                    <input type="number" name="price" required min="1000" step="500"
                           value="<?= htmlspecialchars($product['price']) ?>">
                </div>
                <div class="form-group">
                    <label>Stok *</label>
                    <input type="number" name="stock" required min="0"
                           value="<?= htmlspecialchars($product['stock']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <?php if (!empty($product['image'])): ?>
                <div style="margin-bottom:10px;">
                    <img src="/media/<?= htmlspecialchars($product['image']) ?>"
                         style="height:120px;border-radius:10px;object-fit:cover;">
                    <p style="font-size:13px;color:var(--text-soft);margin:6px 0 0;">
                        Upload baru untuk mengganti foto lama
                    </p>
                </div>
                <?php endif; ?>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                       onchange="previewImage(this)">
                <div class="image-preview-wrap">
                    <img id="imgPreview" class="image-preview" alt="Preview">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                <a href="produk.php" class="btn btn-ghost">Batal</a>
            </div>

        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
(function(){
    const sidebar = document.getElementById('sidebar');
    const btn     = document.getElementById('sidebarToggle');
    const content = document.getElementById('mainContent');
    if (!sidebar || !btn || !content) return;
    btn.addEventListener('click', () => setTimeout(() => {
        content.classList.toggle('expanded', sidebar.classList.contains('closed'));
    }, 20));
})();
</script>
</body>
</html>