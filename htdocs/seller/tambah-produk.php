<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit;
}

$message = '';
$msgClass = 'alert-error';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price       = floatval($_POST['price'] ?? 0);
    $stock       = intval($_POST['stock'] ?? 1);
    $category    = trim($_POST['category'] ?? '');

    if (empty($name) || $price <= 0) {

        $message = 'Nama produk dan harga wajib diisi.';

    } else {

        $imagePath = '';

        if (
            isset($_FILES['image']) &&
            $_FILES['image']['error'] === 0
        ) {

            $allowed = ['jpg','jpeg','png','webp'];

            $ext = strtolower(
                pathinfo(
                    $_FILES['image']['name'],
                    PATHINFO_EXTENSION
                )
            );

            if (!in_array($ext, $allowed)) {

                $message =
                    'Format gambar harus JPG, PNG, atau WEBP.';

            } elseif (
                $_FILES['image']['size']
                > 5 * 1024 * 1024
            ) {

                $message =
                    'Ukuran gambar maksimal 5MB.';

            } else {

                $uploadDir =
                    $_SERVER['DOCUMENT_ROOT'] .
                    '/media/';

                if (!is_dir($uploadDir)) {

                    mkdir(
                        $uploadDir,
                        0755,
                        true
                    );

                }

                $newName =
                    'product_' .
                    uniqid() .
                    '.' .
                    $ext;

                if (
                    move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        $uploadDir . $newName
                    )
                ) {

                    $imagePath = $newName;
                } else {

                    $message =
                        'Gagal upload gambar.';

                }

            }

        }

        if (empty($message)) {

            $stmt = $conn->prepare(
                "INSERT INTO products
                (
                    seller_id,
                    name,
                    description,
                    price,
                    stock,
                    category,
                    image
                )
                VALUES
                (?, ?, ?, ?, ?, ?, ?)"
            );

            if (!$stmt) {

                $message =
                    'Prepare gagal: ' .
                    $conn->error;

            } else {

                $stmt->bind_param(
                    'issdiss',
                    $_SESSION['user_id'],
                    $name,
                    $description,
                    $price,
                    $stock,
                    $category,
                    $imagePath
                );

                if ($stmt->execute()) {

                    header(
                        'Location: produk.php?success=1'
                    );
                    exit;

                } else {

                    $message =
                        'Gagal menyimpan produk: ' .
                        $stmt->error;

                }

                $stmt->close();

            }

        }

    }

}

$categories = [
    'Buku Pelajaran',
    'Seragam',
    'Tas Sekolah',
    'Kalkulator',
    'Alat Tulis',
    'Elektronik',
    'Lainnya'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Tambah Produk
</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

</head>
<body>

<?php include '../includes/sidebar-seller.php'; ?>

<div
id="mainContent"
class="main-content">

<a
href="produk.php"
class="back-link">
← Produk Saya
</a>

<div class="form-card">

<h1>
➕ Tambah Produk
</h1>

<p>
Isi informasi produk yang ingin dijual
</p>

<?php if($message): ?>

<div class="alert alert-error">

<?php echo htmlspecialchars($message); ?>

</div>

<?php endif; ?>

<form
method="post"
enctype="multipart/form-data">

<div class="form-group">

<label>
Nama Produk *
</label>

<input
type="text"
name="name"
required
value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">

</div>

<div class="form-group">

<label>
Kategori
</label>

<select name="category">

<option value="">
Pilih Kategori
</option>

<?php foreach($categories as $cat): ?>

<option
value="<?php echo htmlspecialchars($cat); ?>"
<?php echo (($_POST['category'] ?? '') == $cat) ? 'selected' : ''; ?>>

<?php echo htmlspecialchars($cat); ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="form-row">

<div class="form-group">

<label>
Harga (Rp)
</label>

<input
type="number"
name="price"
required
min="1000"
value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>">

</div>

<div class="form-group">

<label>
Stok
</label>

<input
type="number"
name="stock"
required
min="1"
value="<?php echo htmlspecialchars($_POST['stock'] ?? '1'); ?>">

</div>

</div>

<div class="form-group">

<label>
Deskripsi
</label>

<textarea
name="description"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>

</div>

<div class="form-group">

<label>
Foto Produk
</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.webp"
onchange="previewImage(this)">

<div class="image-preview-wrap">

<img
id="imgPreview"
class="image-preview"
style="display:none;max-width:250px;margin-top:15px;">

</div>

</div>

<div class="form-actions">

<button
type="submit"
class="btn btn-primary">

💾 Simpan Produk

</button>

<a
href="produk.php"
class="btn btn-ghost">

Batal

</a>

</div>

</form>

</div>

</div>

<script>

function previewImage(input){

    const preview =
        document.getElementById(
            'imgPreview'
        );

    if(
        input.files &&
        input.files[0]
    ){

        const reader =
            new FileReader();

        reader.onload =
        function(e){

            preview.src =
                e.target.result;

            preview.style.display =
                'block';

        };

        reader.readAsDataURL(
            input.files[0]
        );

    }

}

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const sidebar =
            document.getElementById(
                'sidebar'
            );

        const btn =
            document.getElementById(
                'sidebarToggle'
            );

        const content =
            document.getElementById(
                'mainContent'
            );

        if(
            !sidebar ||
            !btn ||
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

        btn.addEventListener(
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