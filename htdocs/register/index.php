<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['user_id'])){

    if($_SESSION['role'] == 'buyer'){
        header('Location: ../dashboard/buyer.php');
        exit;
    }

    if($_SESSION['role'] == 'seller'){
        header('Location: ../dashboard/seller.php');
        exit;
    }

    if($_SESSION['role'] == 'partner'){
        header('Location: ../dashboard/partner.php');
        exit;
    }

    if($_SESSION['role'] == 'pending_partner'){
        header('Location: ../menunggu-verifikasi.php');
        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pilih Jenis Akun - Bekal Edu</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

</head>
<body>

<?php include '../includes/topbar.php'; ?>

<div class="bekal-login-wrapper">

<div class="bekal-card">

<div class="bekal-logo">
🎓
</div>

<h2>
Pilih Jenis Akun
</h2>

<p>
Daftar sesuai kebutuhan Anda di Bekal Edu.
</p>

<div class="bekal-role-grid">

<button
class="bekal-role-card"
onclick="location.href='buyer.php'">

<div style="font-size:48px;">
🎒
</div>

<h3>Pembeli</h3>

<p>
Cari buku, seragam, dan perlengkapan sekolah bekas.
</p>

</button>

<button
class="bekal-role-card"
onclick="location.href='seller.php'">

<div style="font-size:48px;">
📚
</div>

<h3>Penjual</h3>

<p>
Jual buku, seragam, dan perlengkapan sekolah bekas.
</p>

</button>

<button
class="bekal-role-card"
onclick="location.href='partner.php'">

<div style="font-size:48px;">
🎓
</div>

<h3>Mitra</h3>

<p>
Publikasikan informasi beasiswa dan program pendidikan.
</p>

</button>

</div>

<div style="margin-top:30px;">

<p>

Sudah punya akun?

<a
href="../login.php"
style="
font-weight:bold;
text-decoration:none;
">
Login
</a>

</p>

</div>

</div>

</div>

</body>
</html>