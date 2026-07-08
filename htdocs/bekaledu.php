<?php
session_start();
require_once 'includes/config.php';

$loggedIn = isset($_SESSION['user_id']);
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bekal Edu</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

body{
    margin:0;
    font-family:Arial,sans-serif;
    background:#f5f7fb;
    color:#1f2937;
}

.main-content{
    margin-left:0;
    padding:35px;
    transition:.3s;
}

.main-content.expanded{
    margin-left:80px;
}

.hero{

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color:white;

    padding:60px;

    border-radius:24px;

    margin-bottom:30px;

    box-shadow:
    0 10px 30px
    rgba(37,99,235,.25);

}

.hero h1{

    margin:0;

    font-size:46px;

}

.hero p{

    margin-top:15px;

    max-width:700px;

    line-height:1.8;

    font-size:18px;

}

.btn{

    display:inline-block;

    margin-top:25px;

    margin-right:10px;

    padding:13px 22px;

    border-radius:12px;

    text-decoration:none;

    font-weight:bold;

    transition:.25s;

}

.btn-primary{

    background:white;

    color:#2563eb;

}

.btn-primary:hover{

    transform:translateY(-2px);

}

.btn-outline{

    border:2px solid white;

    color:white;

}

.btn-outline:hover{

    background:white;

    color:#2563eb;

}

.card{

    background:white;

    border-radius:22px;

    padding:30px;

    margin-bottom:25px;

    box-shadow:
    0 8px 25px
    rgba(0,0,0,.05);

}

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(300px,1fr));

    gap:20px;

}

.info{

    background:#eff6ff;

    padding:18px;

    border-radius:15px;

    margin-bottom:15px;

}

input,
select,
textarea{

    width:100%;

    padding:13px;

    border-radius:12px;

    border:1px solid #d1d5db;

    box-sizing:border-box;

    margin-top:8px;

    margin-bottom:18px;

}

button{

    background:#2563eb;

    color:white;

    border:none;

    padding:13px 24px;

    border-radius:12px;

    cursor:pointer;

    font-weight:bold;

}

button:hover{

    background:#1d4ed8;

}

footer{

    text-align:center;

    color:#6b7280;

    padding:30px;

}

@media(max-width:992px){

.main-content,
.main-content.expanded{

    margin-left:0;

}

.hero{

    padding:35px;

}

.hero h1{

    font-size:34px;

}

}

</style>

</head>

<body>

<?php

if($loggedIn){

    if($role=='buyer'){

        include 'includes/sidebar-buyer.php';

    }elseif($role=='seller'){

        include 'includes/sidebar-seller.php';

    }elseif($role=='partner'){

        include 'includes/sidebar-partner.php';

    }

}else{

    include 'includes/topbar.php';

}

?>

<div
id="mainContent"
class="main-content">

<div class="hero">

<h1>
🎓 Bekal Edu
</h1>

<p>

Bekal Edu adalah marketplace perlengkapan sekolah bekas yang membantu siswa mendapatkan kebutuhan belajar berkualitas dengan harga lebih terjangkau sekaligus mengurangi limbah melalui penggunaan kembali barang yang masih layak pakai.

</p>

<a
href="marketplace.php"
class="btn btn-primary">

Lihat Produk

</a>

<a
href="beasiswa.php"
class="btn btn-outline">

Lihat Beasiswa

</a>

</div>

<div
class="card"
id="about">

<h2>
Tentang Bekal Edu
</h2>

<p>

Bekal Edu mempertemukan siswa, orang tua, penjual, dan mitra pendidikan dalam satu platform untuk menjual maupun membeli perlengkapan sekolah bekas yang masih berkualitas.

</p>

<p>

Kami percaya bahwa setiap buku, tas, seragam, alat tulis, maupun perlengkapan sekolah lainnya masih memiliki nilai dan dapat membantu siswa lain memperoleh pendidikan dengan biaya yang lebih ringan.

</p>

<div class="grid">

<div>

<h3>
🎯 Visi
</h3>

<p>

Menjadi marketplace pendidikan terpercaya yang mendukung akses pendidikan yang lebih terjangkau bagi seluruh pelajar Indonesia.

</p>

</div>

<div>

<h3>
🚀 Misi
</h3>

<ul>

<li>Membantu siswa memperoleh perlengkapan sekolah dengan harga terjangkau.</li>

<li>Mengurangi limbah melalui budaya reuse.</li>

<li>Membuka peluang usaha bagi masyarakat.</li>

<li>Menghubungkan komunitas pendidikan dalam satu platform.</li>

</ul>

</div>

</div>

</div>

<div class="card">

<h2>
💬 Contact Support
</h2>

<p>

Butuh bantuan?

Tim Bekal Edu siap membantu Anda.

</p>

<div class="info">

<b>
📧 Email
</b>

<br>

support@bekaledu.id

</div>

<div class="info">

<b>
📱 WhatsApp
</b>

<br>

+62 812-3456-7890

</div>

<div class="info">

<b>
🕒 Jam Operasional
</b>

<br>

Senin - Sabtu

<br>

08.00 - 20.00 WIB

</div>

</div>

<footer>

© 2026 Bekal Edu

<br>

Marketplace Perlengkapan Sekolah Bekas

</footer>

</div>

<?php if($loggedIn): ?>

<script>

document.addEventListener(

'DOMContentLoaded',

function(){

const sidebar=
document.getElementById(
'sidebar'
);

const toggleBtn=
document.getElementById(
'sidebarToggle'
);

const content=
document.getElementById(
'mainContent'
);

if(
!sidebar||
!toggleBtn||
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

<?php endif; ?>

</body>
</html>