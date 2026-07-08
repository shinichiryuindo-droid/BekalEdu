<?php

session_start();

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

$role = $user['role'];

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
Profil Saya
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

.profile-container{

    max-width:900px;

    margin:40px auto 40px 300px;

    padding:20px;

    transition:.3s;
}

.profile-container.expanded{
    margin-left:80px;
}

.profile-card{

    background:white;

    border-radius:24px;

    padding:35px;

    box-shadow:
    0 8px 25px rgba(0,0,0,.05);
}

.profile-header{

    text-align:center;

    margin-bottom:30px;
}

.avatar{

    width:100px;
    height:100px;

    border-radius:50%;

    background:#2563eb;

    color:white;

    display:flex;

    align-items:center;
    justify-content:center;

    font-size:42px;

    margin:auto;
    margin-bottom:15px;
}

.info-row{

    padding:15px 0;

    border-bottom:
    1px solid #e5e7eb;
}

.info-label{

    font-weight:bold;

    color:#6b7280;
}

.info-value{

    margin-top:5px;

    color:#111827;
}

.edit-btn{

    display:inline-block;

    margin-top:25px;

    background:#2563eb;

    color:white;

    text-decoration:none;

    padding:12px 18px;

    border-radius:10px;
}

@media(max-width:992px){

.profile-container,
.profile-container.expanded{

    margin-left:auto;
    margin-right:auto;
}

}

</style>

</head>

<body>

<?php

if($role == 'buyer'){

    include 'includes/sidebar-buyer.php';

}elseif($role == 'seller'){

    include 'includes/sidebar-seller.php';

}elseif($role == 'partner'){

    include 'includes/sidebar-partner.php';

}

?>

<div
id="mainContent"
class="profile-container">

<div class="profile-card">

<div class="profile-header">

<div class="avatar">

<?php

echo strtoupper(
substr(
$user['username'],
0,
1
)
);

?>

</div>

<h1>

<?php
echo htmlspecialchars(
$user['username']
);
?>

</h1>

<p>

Role:

<b>

<?php
echo htmlspecialchars(
$role
);
?>

</b>

</p>

</div>

<div class="info-row">
<div class="info-label">
Username
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['username']); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Email
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['email']); ?>
</div>
</div>

    <div class="info-row">
<div class="info-label">
Nama Lengkap
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['full_name'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Nomor Telepon
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['phone'] ?? '-'); ?>
</div>
</div>
    
<div class="info-row">
<div class="info-label">
Role
</div>
<div class="info-value">
<?php echo htmlspecialchars($role); ?>
</div>
</div>

<?php if($role == 'buyer'): ?>

<div class="info-row">
<div class="info-label">
Jenjang
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['jenjang'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Alamat
</div>
<div class="info-value">
<?php
echo nl2br(
htmlspecialchars(
$user['address'] ?? '-'
)
);
?>
</div>
</div>
    
<?php endif; ?>

<?php if($role == 'seller'): ?>

<div class="info-row">
<div class="info-label">
Nama Bank
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['nama_bank'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Nomor Rekening
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['no_rekening'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Alamat
</div>
<div class="info-value">
<?php echo nl2br(htmlspecialchars($user['address'] ?? '-')); ?>
</div>
</div>

<?php endif; ?>
    
<?php if($role == 'partner'): ?>

<div class="info-row">
<div class="info-label">
Institusi
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['institution'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Website
</div>
<div class="info-value">
<?php echo htmlspecialchars($user['website'] ?? '-'); ?>
</div>
</div>

<div class="info-row">
<div class="info-label">
Alamat
</div>
<div class="info-value">
<?php echo nl2br(htmlspecialchars($user['address'] ?? '-')); ?>
</div>
</div>

<?php endif; ?>

<div class="info-row">
<div class="info-label">
Tanggal Bergabung
</div>
<div class="info-value">
<?php echo date('d F Y', strtotime($user['created_at'])); ?>
</div>
</div>
    
<a
href="edit-profile.php"
class="edit-btn">

✏️ Edit Profil

</a>

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

    if(!sidebar || !toggleBtn || !content){
        return;
    }

    function updateLayout(){

        if(sidebar.classList.contains('closed')){

            content.classList.add('expanded');

        }else{

            content.classList.remove('expanded');

        }

    }

    updateLayout();

    toggleBtn.addEventListener(
        'click',
        function(){

            setTimeout(updateLayout, 20);

        }
    );

});

</script>

</body>
</html>