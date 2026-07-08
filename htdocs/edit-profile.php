<?php

session_start();

/* no komen */

require_once 'includes/config.php';

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare(
    "SELECT *
     FROM users
     WHERE id = ?"
);

$stmt->bind_param(
    "i",
    $_SESSION['user_id']
);

$stmt->execute();

$user =
$stmt->get_result()->fetch_assoc();

if(!$user){
    die('User tidak ditemukan');
}

$success = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username =
    trim($_POST['username']);

    $email =
    trim($_POST['email']);

    $fullName =
trim($_POST['full_name'] ?? '');

$phone =
trim($_POST['phone'] ?? '');

$school =
trim($_POST['school'] ?? '');

$jenjang =
trim($_POST['jenjang'] ?? '');

$institution =
trim($_POST['institution'] ?? '');

$website =
trim($_POST['website'] ?? '');

$address =
trim($_POST['address'] ?? '');

    $namaBank =
trim($_POST['nama_bank'] ?? '');

$noRekening =
trim($_POST['no_rekening'] ?? '');
    
    $oldPassword =
    trim($_POST['old_password'] ?? '');

    $newPassword =
    trim($_POST['new_password'] ?? '');

    $confirmPassword =
    trim($_POST['confirm_password'] ?? '');

    if(
    empty($username) ||
    empty($email)
){

    $error =
    'Username dan email wajib diisi.';

}elseif(
    !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    )
){

    $error =
    'Format email tidak valid.';

}else{

        $changePassword = false;

        if(
            !empty($oldPassword) ||
            !empty($newPassword) ||
            !empty($confirmPassword)
        ){

            if(
                empty($oldPassword) ||
                empty($newPassword) ||
                empty($confirmPassword)
            ){

                $error =
                'Lengkapi seluruh kolom password.';

            }elseif(
                !password_verify(
                    $oldPassword,
                    $user['password']
                )
            ){

                $error =
                'Password lama salah.';

            }elseif(
                $newPassword !==
                $confirmPassword
            ){

                $error =
                'Konfirmasi password tidak cocok.';

            }elseif(
                strlen($newPassword) < 8
            ){

                $error =
                'Password minimal 8 karakter.';

            }else{

                $changePassword = true;

                $hashedPassword =
                password_hash(
                    $newPassword,
                    PASSWORD_DEFAULT
                );

            }

        }

        $check = $conn->prepare(
    "SELECT id
     FROM users
     WHERE (username = ? OR email = ?)
     AND id != ?"
);

$check->bind_param(
    "ssi",
    $username,
    $email,
    $_SESSION['user_id']
);

$check->execute();

if($check->get_result()->num_rows > 0){

    $error =
    'Username atau email sudah digunakan.';

}
        
        if(empty($error)){

            if($changePassword){

$stmt = $conn->prepare("
UPDATE users
SET
username=?,
email=?,
full_name=?,
phone=?,
school=?,
jenjang=?,
institution=?,
website=?,
nama_bank=?,
no_rekening=?,
address=?,
password=?
WHERE id=?
");

$stmt->bind_param(
"ssssssssssssi",
$username,
$email,
$fullName,
$phone,
$school,
$jenjang,
$institution,
$website,
$namaBank,
$noRekening,
$address,
$hashedPassword,
$_SESSION['user_id']
);            }else{

$stmt = $conn->prepare("
UPDATE users
SET
username=?,
email=?,
full_name=?,
phone=?,
school=?,
jenjang=?,
institution=?,
website=?,
nama_bank=?,
no_rekening=?,
address=?
WHERE id=?
");

$stmt->bind_param(
"sssssssssssi",
$username,
$email,
$fullName,
$phone,
$school,
$jenjang,
$institution,
$website,
$namaBank,
$noRekening,
$address,
$_SESSION['user_id']
);                
            }

            if($stmt->execute()){

                $_SESSION['username'] =
                $username;

                $success =
                'Profil berhasil diperbarui.';

                $stmt = $conn->prepare(
                    "SELECT *
                     FROM users
                     WHERE id=?"
                );

                $stmt->bind_param(
                    "i",
                    $_SESSION['user_id']
                );

                $stmt->execute();

                $user =
                $stmt->get_result()
                ->fetch_assoc();

            }else{

                $error =
                'Gagal menyimpan perubahan.';

            }

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
Edit Profil
</title>

<link
rel="stylesheet"
href="assets/css/style.css">

<style>

body{
    margin:0;
    background:#f8fafc;
    font-family:Arial,sans-serif;
}

.page{

    max-width:900px;

    margin:40px auto 40px 300px;

    padding:20px;

    transition:.3s ease;

}

.page.expanded{

    margin-left:80px;

}

.card{

    background:white;

    border-radius:24px;

    padding:35px;

    box-shadow:
    0 8px 25px rgba(0,0,0,.05);

}

.card h1{

    margin-top:0;

}

.form-group{

    margin-bottom:20px;

}

label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

}

input,
textarea{

    width:100%;

    padding:14px;

    border:1px solid #d1d5db;

    border-radius:12px;

    box-sizing:border-box;

}

textarea{

    min-height:120px;

    resize:vertical;

}

.save-btn{

    border:none;

    background:#2563eb;

    color:white;

    padding:14px 20px;

    border-radius:12px;

    cursor:pointer;

    font-weight:bold;

}

.save-btn:hover{

    background:#1d4ed8;

}

.success{

    background:#dcfce7;

    color:#166534;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

.error{

    background:#fee2e2;

    color:#991b1b;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

.section-title{

    margin-top:35px;
    margin-bottom:20px;

    font-size:18px;
    font-weight:bold;

}

@media(max-width:992px){

.page,
.page.expanded{

    margin-left:auto;
    margin-right:auto;

}

}

</style>

</head>

<body>

<?php

if($user['role'] === 'buyer'){

    include 'includes/sidebar-buyer.php';

}elseif($user['role'] === 'seller'){

    include 'includes/sidebar-seller.php';

}elseif(
    $user['role'] === 'partner'
){

    include 'includes/sidebar-partner.php';

}

?>

<div
id="mainContent"
class="page">

<div class="card">

<h1>
👤 Edit Profil
</h1>

<br>

<?php if($success): ?>

<div class="success">

<?php echo $success; ?>

</div>

<?php endif; ?>

<?php if($error): ?>

<div class="error">

<?php echo $error; ?>

</div>

<?php endif; ?>

<form method="post">

<div class="form-group">

<label>
Username
</label>

<input
type="text"
name="username"
required
value="<?php echo htmlspecialchars($user['username']); ?>">

</div>

<div class="form-group">

<label>
Email
</label>

<input
type="email"
name="email"
required
value="<?php echo htmlspecialchars($user['email']); ?>">

</div>

<div class="form-group">

<label>
Nama Lengkap
</label>

<input
type="text"
name="full_name"
value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>">

</div>

<div class="form-group">

<label>
Nomor Telepon
</label>

<input
type="text"
name="phone"
value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">

</div>
    
    <?php if($user['role'] === 'buyer'): ?>

<div class="form-group">

<label>
Jenjang
</label>

<input
type="text"
name="jenjang"
value="<?php echo htmlspecialchars($user['jenjang'] ?? ''); ?>">

</div>

    <div class="form-group">

<label>
Sekolah
</label>

<input
type="text"
name="school"
value="<?php echo htmlspecialchars($user['school'] ?? ''); ?>">

</div>
    

    <div class="form-group">
    <label>
Alamat
</label>

<textarea
name="address"><?php
echo htmlspecialchars(
$user['address'] ?? ''
);
?></textarea>

        </div>
        
<?php endif; ?>
    
    
<?php if($user['role'] === 'partner'): ?>

<div class="form-group">

<label>
Institusi
</label>

<input
type="text"
name="institution"
value="<?php echo htmlspecialchars($user['institution'] ?? ''); ?>">

</div>

<div class="form-group">

<label>
Website
</label>

<input
type="url"
name="website"
value="<?php echo htmlspecialchars($user['website'] ?? ''); ?>">

</div>
    
<div class="form-group">

<label>
Alamat
</label>

<textarea
name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

</div>

<?php endif; ?>

<?php if($user['role'] === 'seller'): ?>

<div class="form-group">
<label>Nama Bank</label>

<input
type="text"
name="nama_bank"
value="<?php echo htmlspecialchars($user['nama_bank'] ?? ''); ?>">

</div>

<div class="form-group">
<label>Nomor Rekening</label>

<input
type="text"
name="no_rekening"
value="<?php echo htmlspecialchars($user['no_rekening'] ?? ''); ?>">

</div>

<div class="form-group">
<label>Alamat</label>

<textarea
name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

</div>

<?php endif; ?>

<div class="section-title">
🔒 Ubah Password
</div>

<div class="form-group">

<label>
Password Lama
</label>

<input
type="password"
name="old_password">

</div>

<div class="form-group">

<label>
Password Baru
</label>

<input
type="password"
name="new_password">

</div>

<div class="form-group">

<label>
Konfirmasi Password Baru
</label>

<input
type="password"
name="confirm_password">

</div>

<button
type="submit"
class="save-btn">

💾 Simpan Perubahan

</button>

<a
href="profile.php"
style="
margin-left:10px;
text-decoration:none;
font-weight:bold;
">

Batal

</a>

</form>

</div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

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

});

</script>

</body>
</html>