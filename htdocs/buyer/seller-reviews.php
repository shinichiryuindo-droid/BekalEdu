<?php
    
    error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/config.php';

$sellerId = intval($_GET['seller_id'] ?? 0);

if ($sellerId <= 0) {
    die("Seller tidak ditemukan.");
}

/* Seller Info */
$stmt = $conn->prepare("
SELECT username
FROM users
WHERE id=?
LIMIT 1
");
$stmt->bind_param("i",$sellerId);
$stmt->execute();
$seller = $stmt->get_result()->fetch_assoc();

if(!$seller){
    die("Seller tidak ditemukan.");
}

/* Average Rating */
$stmt = $conn->prepare("
SELECT
AVG(r.rating) avg_rating,
COUNT(r.id) total_reviews
FROM product_ratings r
JOIN products p
ON r.product_id=p.id
WHERE p.seller_id=?
");
$stmt->bind_param("i",$sellerId);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

/* Reviews */
$stmt = $conn->prepare("
SELECT

r.rating,
r.review,
r.created_at,

u.username,

p.name product_name

FROM product_ratings r

JOIN users u
ON r.buyer_id=u.id

JOIN products p
ON r.product_id=p.id

WHERE p.seller_id=?

ORDER BY r.created_at DESC
");

$stmt->bind_param("i",$sellerId);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Review Penjual</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

.main-content{
max-width:900px;
margin:auto;
padding:30px;
}

.stats-card{
background:white;
padding:25px;
border-radius:15px;
margin-bottom:25px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.review-card{
background:white;
padding:20px;
border-radius:15px;
margin-bottom:20px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.star{
color:orange;
font-size:20px;
}

.product{
font-weight:bold;
margin-top:8px;
}

.user{
color:#555;
margin-top:10px;
}

.date{
color:#999;
font-size:13px;
margin-top:8px;
}

.review-text{
margin-top:15px;
line-height:1.7;
}

.back{
display:inline-block;
margin-bottom:20px;
text-decoration:none;
}

</style>

</head>

<body>

<?php include '../includes/sidebar-buyer.php'; ?>

<div class="main-content">

<a class="back" href="javascript:history.back()">
← Kembali
</a>

<h1>

<?= htmlspecialchars($seller['username']) ?>

</h1>

<div class="stats-card">

<h2>Ringkasan Rating</h2>

<br>

<h1>

⭐

<?= number_format($stats['avg_rating'] ?: 0,1) ?>

/5

</h1>

<p>

<?= intval($stats['total_reviews']) ?>

Review

</p>

</div>

<h2>Semua Review</h2>

<br>

<?php

if($reviews->num_rows==0):

?>

<div class="review-card">

Belum ada review.

</div>

<?php

endif;

while($r=$reviews->fetch_assoc()):

?>

<div class="review-card">

<div class="star">

<?php

for($i=1;$i<=5;$i++){

if($i<=$r['rating'])
echo "★";
else
echo "☆";

}

?>

</div>

<div class="product">

📦

<?= htmlspecialchars($r['product_name']) ?>

</div>

<div class="user">

Oleh

<b>

<?= htmlspecialchars($r['username']) ?>

</b>

</div>

<?php

if(!empty($r['review'])):

?>

<div class="review-text">

<?= nl2br(htmlspecialchars($r['review'])) ?>

</div>

<?php

endif;

?>

<div class="date">

<?= date("d M Y H:i",strtotime($r['created_at'])) ?>

</div>

</div>

<?php

endwhile;

?>

</div>

</body>
</html>