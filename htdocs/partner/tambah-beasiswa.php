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

$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $title = trim($_POST['title']);
    $institution = trim($_POST['institution']);
    $location = trim($_POST['location']);
    $level = trim($_POST['level']);
    $description = trim($_POST['description']);
    $deadline = $_POST['deadline'];

    $partnerId = $_SESSION['user_id'];

    $imagePath = '';

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
            "Format gambar harus JPG, JPEG, PNG, atau WEBP.";

        }else{

            $uploadDir =
                    $_SERVER['DOCUMENT_ROOT'] .
                    '/media/beasiswa-gambar/';

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
                "Gagal upload gambar.";

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

        $error = "Semua field wajib diisi.";

    }

    if(empty($error)){

        $stmt = $conn->prepare(
            "INSERT INTO scholarships
            (
                title,
                institution,
                location,
                level,
                description,
                image,
                deadline,
                partner_id
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssssssi",
            $title,
            $institution,
            $location,
            $level,
            $description,
            $imagePath,
            $deadline,
            $partnerId
        );

        if($stmt->execute()){

            $success =
            "🎉 Beasiswa berhasil dipublikasikan.";

        }else{

            $error =
            "Gagal menyimpan beasiswa.";

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
Tambah Beasiswa
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

.page-header{
    margin-bottom:30px;
}

.page-header h1{
    margin:0;
    font-size:34px;
    color:#111827;
}

.page-header p{
    margin-top:10px;
    color:#6b7280;
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
    color:#374151;
}

.form-group input,
.form-group textarea,
.form-group select{
    width:100%;
    padding:14px;
    border:1px solid #d1d5db;
    border-radius:12px;
    font-size:15px;
    box-sizing:border-box;
    transition:.2s;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus{
    outline:none;
    border-color:#2563eb;
    box-shadow:0 0 0 4px rgba(37,99,235,.1);
}

.form-group textarea{
    resize:vertical;
    min-height:180px;
}

.submit-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:14px 24px;
    border-radius:12px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:.25s;
}

.submit-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 25px rgba(37,99,235,.25);
}

.success-box{
    background:#dcfce7;
    color:#166534;
    padding:16px;
    border-radius:12px;
    margin-bottom:20px;
}

.error-box{
    background:#fee2e2;
    color:#991b1b;
    padding:16px;
    border-radius:12px;
    margin-bottom:20px;
}

.info-card{
    background:#eff6ff;
    color:#1d4ed8;
    padding:18px;
    border-radius:14px;
    margin-bottom:25px;
}

</style>

</head>

<body>

<?php include '../includes/sidebar-partner.php'; ?>

<div
id="mainContent"
class="main-content">

<div class="page-header">

<h1>
🎓 Tambah Beasiswa
</h1>

<p>
Publikasikan program beasiswa baru dan jangkau lebih banyak siswa melalui Bekal Edu.
</p>

</div>

<div class="form-card">

<div class="info-card">
💡 Pastikan informasi beasiswa lengkap dan akurat agar lebih mudah ditemukan oleh calon pelamar.
</div>

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

<form method="POST" enctype="multipart/form-data">

<div class="form-group">
<label>Judul Beasiswa</label>
<input type="text" name="title" required>
</div>

<div class="form-group">
<label>Nama Institusi</label>
<input type="text" name="institution" required>
</div>

<div class="form-group">
<label>Lokasi</label>
<input type="text" name="location" required>
</div>

<div class="form-group">
<label>Jenjang Pendidikan</label>

<select name="level" required>

<option value="">Pilih Jenjang</option>
<option>SMP</option>
<option>SMA/SMK</option>
<option>D3</option>
<option>S1</option>
<option>S2</option>
<option>S3</option>

</select>

</div>

<div class="form-group">

<label>
Deadline Pendaftaran
</label>

<input
type="date"
name="deadline"
required>

</div>

<div class="form-group">

<label>
Poster / Gambar Beasiswa
</label>

<input
type="file"
name="image"
accept=".jpg,.jpeg,.png,.webp">

</div>

<div class="form-group">

<label>
Deskripsi Beasiswa
</label>

<textarea
name="description"
required></textarea>

</div>

<button
type="submit"
class="submit-btn">

🚀 Publikasikan Beasiswa

</button>

</form>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const sidebar =
        document.getElementById('sidebar');

    const toggleBtn =
        document.getElementById('sidebarToggle');

    const mainContent =
        document.getElementById('mainContent');

    if(toggleBtn && sidebar){

        toggleBtn.addEventListener(
            'click',
            function(){

                setTimeout(function(){

                    if(
                        sidebar.classList.contains('closed')
                    ){

                        mainContent.classList.add(
                            'expanded'
                        );

                    }else{

                        mainContent.classList.remove(
                            'expanded'
                        );

                    }

                },10);

            }
        );

    }

});

</script>

</body>
</html>