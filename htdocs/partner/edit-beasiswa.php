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

if(!isset($_GET['id'])){
    die('ID beasiswa tidak ditemukan.');
}

$id = (int)$_GET['id'];
$partnerId = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT *
     FROM scholarships
     WHERE id = ?
     AND partner_id = ?"
);

$stmt->bind_param(
    "ii",
    $id,
    $partnerId
);

$stmt->execute();

$beasiswa =
$stmt->get_result()->fetch_assoc();

if(!$beasiswa){
    die('Beasiswa tidak ditemukan.');
}

$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title =
    trim($_POST['title']);

    $institution =
    trim($_POST['institution']);

    $location =
    trim($_POST['location']);

    $level =
    trim($_POST['level']);

    $description =
    trim($_POST['description']);

    $deadline =
    $_POST['deadline'];

    $imagePath =
    $beasiswa['image'];

    if(
        isset($_FILES['image']) &&
        $_FILES['image']['error'] === 0
    ){

        $allowed = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $ext =
        strtolower(
            pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            )
        );

        if(
            !in_array(
                $ext,
                $allowed
            )
        ){

            $error =
            'Format gambar harus JPG, JPEG, PNG, atau WEBP.';

        }else{

            $uploadDir =
            $_SERVER['DOCUMENT_ROOT']
            . '/media/beasiswa-gambar/';

            if(
                !is_dir($uploadDir)
            ){

                mkdir(
                    $uploadDir,
                    0777,
                    true
                );

            }

            $fileName =
            'beasiswa_' .
            time() .
            '_' .
            rand(1000,9999) .
            '.' .
            $ext;

            $target =
            $uploadDir .
            $fileName;

            if(
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    $target
                )
            ){

                $imagePath =
                '/media/beasiswa-gambar/' .
                $fileName;

            }else{

                $error =
                'Gagal upload gambar.';

            }

        }

    }

    if(
        empty($title) ||
        empty($institution) ||
        empty($location) ||
        empty($level) ||
        empty($description) ||
        empty($deadline)
    ){

        $error =
        'Semua field wajib diisi.';

    }

    if(empty($error)){

        $stmt = $conn->prepare(
            "UPDATE scholarships
             SET
             title=?,
             institution=?,
             location=?,
             level=?,
             description=?,
             image=?,
             deadline=?
             WHERE id=?
             AND partner_id=?"
        );

        $stmt->bind_param(
            "sssssssii",
            $title,
            $institution,
            $location,
            $level,
            $description,
            $imagePath,
            $deadline,
            $id,
            $partnerId
        );

        if($stmt->execute()){

            $success =
            '✅ Beasiswa berhasil diperbarui.';

            $stmt = $conn->prepare(
                "SELECT *
                 FROM scholarships
                 WHERE id=?"
            );

            $stmt->bind_param(
                "i",
                $id
            );

            $stmt->execute();

            $beasiswa =
            $stmt->get_result()
            ->fetch_assoc();

        }else{

            $error =
            'Gagal memperbarui beasiswa.';

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Edit Beasiswa
</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

<style>

body{
    margin:0;
    background:#f8fafc;
    font-family:Arial,sans-serif;
}

.main-content{
    margin-left:280px;
    padding:40px;
    transition:.3s;
}

.main-content.expanded{
    margin-left:90px;
}

.form-card{
    max-width:950px;
    background:white;
    border-radius:24px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.form-group{
    margin-bottom:22px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:600;
}

.form-group input,
.form-group textarea,
.form-group select{
    width:100%;
    padding:14px;
    border:1px solid #d1d5db;
    border-radius:12px;
    box-sizing:border-box;
}

.form-group textarea{
    min-height:180px;
}

.submit-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:14px 24px;
    border-radius:12px;
    cursor:pointer;
}

.success-box{
    background:#dcfce7;
    color:#166534;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

.error-box{
    background:#fee2e2;
    color:#991b1b;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

.preview{
    max-width:250px;
    border-radius:12px;
    margin-top:10px;
}

</style>

</head>

<body>

<?php include '../includes/sidebar-partner.php'; ?>

<div
id="mainContent"
class="main-content">

<div class="form-card">

<h1>
✏️ Edit Beasiswa
</h1>

<br>

<?php if($success): ?>
<div class="success-box">
<?php echo $success; ?>
</div>
<?php endif; ?>

<?php if($error): ?>
<div class="error-box">
<?php echo $error; ?>
</div>
<?php endif; ?>

<form
method="POST"
enctype="multipart/form-data">

<div class="form-group">
<label>Judul Beasiswa</label>
<input
type="text"
name="title"
required
value="<?php echo htmlspecialchars($beasiswa['title']); ?>">
</div>

<div class="form-group">
<label>Nama Institusi</label>
<input
type="text"
name="institution"
required
value="<?php echo htmlspecialchars($beasiswa['institution']); ?>">
</div>

<div class="form-group">
<label>Lokasi</label>
<input
type="text"
name="location"
required
value="<?php echo htmlspecialchars($beasiswa['location']); ?>">
</div>

<div class="form-group">

<label>Jenjang</label>

<select name="level" required>

<option value="SMP" <?php if($beasiswa['level']=='SMP') echo 'selected'; ?>>SMP</option>

<option value="SMA/SMK" <?php if($beasiswa['level']=='SMA/SMK') echo 'selected'; ?>>SMA/SMK</option>

<option value="D3" <?php if($beasiswa['level']=='D3') echo 'selected'; ?>>D3</option>

<option value="S1" <?php if($beasiswa['level']=='S1') echo 'selected'; ?>>S1</option>

<option value="S2" <?php if($beasiswa['level']=='S2') echo 'selected'; ?>>S2</option>

<option value="S3" <?php if($beasiswa['level']=='S3') echo 'selected'; ?>>S3</option>

</select>

</div>

<div class="form-group">

<label>
Deadline
</label>

<input
type="date"
name="deadline"
required
value="<?php echo $beasiswa['deadline']; ?>">

</div>

<div class="form-group">

<label>
Gambar Baru (Opsional)
</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.webp">

<?php if(!empty($beasiswa['image'])): ?>

<img
src="<?php echo htmlspecialchars($beasiswa['image']); ?>"
class="preview">

<?php endif; ?>

</div>

<div class="form-group">

<label>
Deskripsi
</label>

<textarea
name="description"
required><?php echo htmlspecialchars($beasiswa['description']); ?></textarea>

</div>

<button
type="submit"
class="submit-btn">

💾 Simpan Perubahan

</button>

</form>

</div>

</div>

</body>
</html>