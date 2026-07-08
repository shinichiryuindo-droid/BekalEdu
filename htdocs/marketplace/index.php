<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Marketplace - Bekal Edu</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

body{
    margin:0;
    background:#f8fafc;
    font-family:Arial,sans-serif;
}

.marketplace-container{
    max-width:1200px;
    margin:auto;
    padding:40px 20px;
}

.hero{
    background:white;
    padding:30px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.hero h1{
    margin-top:0;
}

.hero p{
    color:#6b7280;
}

.search-box{
    width:100%;
    padding:16px;
    border:none;
    border-radius:15px;
    font-size:15px;
    margin-top:15px;
    box-sizing:border-box;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.category-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-bottom:30px;
}

.category{
    background:white;
    padding:14px 18px;
    border-radius:14px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
    font-weight:600;
}

.ai-card{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:30px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.ai-card ul{
    margin-bottom:0;
}

.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(280px,1fr));
    gap:20px;
}

.product-card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
    transition:.25s;
}

.product-card:hover{
    transform:translateY(-5px);
}

.product-image{
    height:180px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:70px;
    background:#eef2ff;
}

.product-body{
    padding:20px;
}

.product-title{
    font-size:18px;
    font-weight:bold;
}

.product-price{
    font-size:22px;
    font-weight:bold;
    margin:10px 0;
}

.product-school{
    color:#6b7280;
}

.detail-btn{
    display:inline-block;
    margin-top:15px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:10px 15px;
    border-radius:10px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin-top:30px;
}

.stat-card{
    background:white;
    padding:20px;
    text-align:center;
    border-radius:20px;
    box-shadow:0 8px 25px rgba(0,0,0,.05);
}

.stat-card h2{
    margin:0;
}

.stat-card p{
    color:#6b7280;
}

@media(max-width:768px){

    .stats{
        grid-template-columns:1fr;
    }

}

</style>

</head>

<body>

<?php

if(
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'buyer'
){
    include 'includes/sidebar-buyer.php';
}else{
    include 'includes/topbar.php';
}

?>

<div class="marketplace-container">

<div class="hero">

<h1>
📚 Marketplace Sekolah Bekas
</h1>

<p>
Temukan buku, seragam, dan perlengkapan sekolah bekas dengan harga terjangkau.
</p>

<input
type="text"
class="search-box"
placeholder="Cari buku, seragam, kalkulator, tas sekolah...">

</div>

<div class="category-row">

<div class="category">📖 Buku Pelajaran</div>
<div class="category">👕 Seragam</div>
<div class="category">🎒 Tas Sekolah</div>
<div class="category">🧮 Kalkulator</div>
<div class="category">📚 Buku UTBK</div>

</div>

<div class="ai-card">

<h2>
🤖 Rekomendasi AI
</h2>

<p>
Berdasarkan sekolah dan jenjangmu:
</p>

<ul>
<li>Buku Kimia Kelas XI</li>
<li>Buku Fisika Kelas XI</li>
<li>Kalkulator Scientific</li>
<li>Buku UTBK TPS</li>
</ul>

</div>

<div class="product-grid">

<div class="product-card">

<div class="product-image">
📖
</div>

<div class="product-body">

<div class="product-title">
Matematika Kelas XII
</div>

<div class="product-price">
Rp35.000
</div>

<div class="product-school">
SMAN 1 Bandung
</div>

<a href="#" class="detail-btn">
Lihat Detail
</a>

</div>

</div>

<div class="product-card">

<div class="product-image">
👕
</div>

<div class="product-body">

<div class="product-title">
Seragam Putih Abu
</div>

<div class="product-price">
Rp50.000
</div>

<div class="product-school">
SMAN 3 Jakarta
</div>

<a href="#" class="detail-btn">
Lihat Detail
</a>

</div>

</div>

<div class="product-card">

<div class="product-image">
🎒
</div>

<div class="product-body">

<div class="product-title">
Tas Sekolah Eiger
</div>

<div class="product-price">
Rp80.000
</div>

<div class="product-school">
SMKN 2 Surabaya
</div>

<a href="#" class="detail-btn">
Lihat Detail
</a>

</div>

</div>

<div class="product-card">

<div class="product-image">
🧮
</div>

<div class="product-body">

<div class="product-title">
Kalkulator Scientific
</div>

<div class="product-price">
Rp65.000
</div>

<div class="product-school">
SMAN 5 Yogyakarta
</div>

<a href="#" class="detail-btn">
Lihat Detail
</a>

</div>

</div>

</div>

<div class="stats">

<div class="stat-card">

<h2>
128
</h2>

<p>
Barang Terselamatkan
</p>

</div>

<div class="stat-card">

<h2>
Rp12,5 Juta
</h2>

<p>
Penghematan Siswa
</p>

</div>

<div class="stat-card">

<h2>
25
</h2>

<p>
Sekolah Terdaftar
</p>

</div>

</div>

</div>

</body>
</html>