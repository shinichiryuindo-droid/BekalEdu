<?php
session_start();
require_once '../includes/config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'buyer'
) {
    header("Location: ../login.php");
    exit;
}

$buyerId = $_SESSION['user_id'];

$orderId = intval(
    $_GET['order_id']
    ??
    $_POST['order_id']
    ??
    0
);

if ($orderId <= 0) {
    header("Location: pesanan-saya.php");
    exit;
}

/*
==================================================
GET ORDER
==================================================
*/

$stmt = $conn->prepare("
SELECT

o.*,

p.id product_id,
p.name product_name,
p.image,
p.rating_avg,
p.rating_count,

u.id seller_id,
u.username seller_name

FROM orders o

JOIN products p
ON o.product_id=p.id

JOIN users u
ON p.seller_id=u.id

WHERE

o.id=?

AND

o.buyer_id=?

AND

(
o.status='selesai'
OR
o.status='completed'
)

LIMIT 1
");

$stmt->bind_param(
"ii",
$orderId,
$buyerId
);

$stmt->execute();

$order =
$stmt
->get_result()
->fetch_assoc();

if(!$order){

die(
"Pesanan tidak ditemukan atau belum selesai."
);

}

/*
==================================================
CHECK ALREADY REVIEWED
==================================================
*/

$stmt=$conn->prepare("
SELECT id
FROM product_ratings
WHERE
product_id=?
AND buyer_id=?
LIMIT 1
");

$stmt->bind_param(
    "ii",
    $order["product_id"],
    $buyerId
);

$stmt->execute();

if(
$stmt
->get_result()
->num_rows>0
){

header(
"Location: pesanan-saya.php?reviewed=1"
);

exit;

}

/*
==================================================
MESSAGE
==================================================
*/

$message="";
$msgClass="";

/*
==================================================
SUBMIT REVIEW
==================================================
*/

if($_SERVER["REQUEST_METHOD"]==="POST"){

$rating=intval(
$_POST["rating"]??0
);

$review=trim(
$_POST["review"]??""
);

if(
$rating<1
||
$rating>5
){

$message=
"Silakan pilih rating.";

$msgClass="error";

}

elseif(
strlen($review)<10
){

$message=
"Ulasan minimal 10 karakter.";

$msgClass="error";

}

else{

$conn->begin_transaction();

try{

/*
-------------------------------------
INSERT REVIEW
-------------------------------------
*/

$stmt = $conn->prepare("
INSERT INTO product_ratings
(
    product_id,
    buyer_id,
    rating,
    review
)
VALUES
(
    ?, ?, ?, ?
)
");
    
$stmt->bind_param(
    "iiis",
    $order["product_id"],
    $buyerId,
    $rating,
    $review
);
    
if (!$stmt->execute()) {
    die($stmt->error);
}
/*
-------------------------------------
UPDATE PRODUCT RATING
-------------------------------------
*/

$stmt=$conn->prepare("
UPDATE products

SET

rating_avg=(

SELECT
COALESCE(
AVG(rating),
0
)

FROM product_ratings

WHERE product_id=?

),

rating_count=(

SELECT
COUNT(*)

FROM product_ratings

WHERE product_id=?

)

WHERE id=?

");

$stmt->bind_param(

"iii",

$order["product_id"],

$order["product_id"],

$order["product_id"]

);

$stmt->execute();

if($stmt->error){
    die($stmt->error);
}
    
/*
-------------------------------------
COMMIT
-------------------------------------
*/

$conn->commit();

header(
"Location: ../buyer/produk-detail.php?id=".$order["product_id"]."&review_success=1"
);

exit;

}

catch(Exception $e){

    $conn->rollback();

    die($e->getMessage());

}
}

}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Beri Ulasan Produk</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

.main-content{

max-width:850px;

margin:auto;

padding:35px;

}

.back-link{

display:inline-block;

margin-bottom:20px;

text-decoration:none;

color:#2563eb;

font-weight:bold;

}

.review-product{

display:flex;

gap:25px;

background:#fff;

padding:25px;

border-radius:18px;

box-shadow:0 5px 18px rgba(0,0,0,.08);

margin-bottom:30px;

align-items:center;

}

.review-image{

width:120px;

height:120px;

border-radius:15px;

object-fit:cover;

background:#f5f5f5;

}

.review-placeholder{

width:120px;

height:120px;

display:flex;

align-items:center;

justify-content:center;

background:#f3f4f6;

border-radius:15px;

font-size:55px;

}

.review-info h2{

margin-bottom:10px;

font-size:25px;

}

.review-info p{

margin-bottom:7px;

color:#555;

}

.review-card{

background:white;

padding:35px;

border-radius:18px;

box-shadow:0 5px 18px rgba(0,0,0,.08);

}

.review-card h2{

margin-bottom:8px;

}

.review-card p{

color:#666;

margin-bottom:30px;

}

.star-group{

display:flex;

flex-direction:row-reverse;

justify-content:flex-end;

gap:10px;

margin-bottom:12px;

}

.star-group input{

display:none;

}

.star-group label{

font-size:48px;

cursor:pointer;

color:#d1d5db;

transition:.2s;

}

.star-group label:hover,

.star-group label:hover~label,

.star-group input:checked~label{

color:#f59e0b;

transform:scale(1.15);

}

.star-text{

font-size:14px;

font-weight:bold;

margin-bottom:25px;

color:#666;

min-height:20px;

}

.quick-title{

font-weight:bold;

margin-bottom:12px;

}

.quick-list{

display:flex;

flex-wrap:wrap;

gap:10px;

margin-bottom:25px;

}

.quick-chip{

padding:8px 14px;

background:#f5f5f5;

border-radius:30px;

cursor:pointer;

transition:.2s;

font-size:13px;

border:1px solid #ddd;

user-select:none;

}

.quick-chip:hover{

background:#2563eb;

color:white;

border-color:#2563eb;

}

.quick-chip.active{

background:#2563eb;

color:white;

border-color:#2563eb;

}

textarea{

width:100%;

padding:15px;

font-size:15px;

border-radius:12px;

border:1px solid #ddd;

resize:vertical;

min-height:170px;

font-family:inherit;

outline:none;

transition:.2s;

}

textarea:focus{

border-color:#2563eb;

}

.char-counter{

text-align:right;

font-size:12px;

color:#888;

margin-top:8px;

margin-bottom:25px;

}

.submit-btn{

width:100%;

padding:17px;

background:#2563eb;

border:none;

border-radius:12px;

font-size:17px;

font-weight:bold;

color:white;

cursor:pointer;

transition:.2s;

}

.submit-btn:hover{

background:#1d4ed8;

}

.error{

background:#fee2e2;

padding:15px;

border-radius:12px;

margin-bottom:20px;

color:#991b1b;

font-weight:bold;

}

.success{

background:#dcfce7;

padding:15px;

border-radius:12px;

margin-bottom:20px;

color:#166534;

font-weight:bold;

}

@media(max-width:768px){

.main-content{

padding:20px;

}

.review-product{

flex-direction:column;

text-align:center;

}

.review-image,

.review-placeholder{

width:180px;

height:180px;

}

.star-group{

justify-content:center;

}

}

</style>

</head>

<body>

<?php include '../includes/sidebar-buyer.php'; ?>

<div
id="mainContent"
class="main-content">

<a
href="pesanan-saya.php"
class="back-link">

← Kembali ke Pesanan

</a>

<?php if($message!=""): ?>

<div class="<?= $msgClass ?>">

<?= htmlspecialchars($message) ?>

</div>

<?php endif; ?>

<div class="review-product">

<?php if(!empty($order["image"])): ?>

<img

src="../media/<?= htmlspecialchars($order["image"]) ?>"

class="review-image"

>

<?php else: ?>

<div class="review-placeholder">

📦

</div>

<?php endif; ?>

<div class="review-info">

<h2>

<?= htmlspecialchars($order["product_name"]) ?>

</h2>

<p>

👤

<?= htmlspecialchars($order["seller_name"]) ?>

</p>

<p>

📦

<?= intval($order["quantity"]) ?>

item

</p>

<p>

💰 Rp

<?= number_format($order["total_price"],0,",",".") ?>

</p>

<p>

⭐

<?= number_format($order["rating_avg"],1) ?>

(

<?= intval($order["rating_count"]) ?>

Review)

</p>

</div>

</div>

<div class="review-card">

<h2>

Berikan Ulasan

</h2>

<p>

Bagikan pengalamanmu membeli produk ini.

</p>

<form method="post">

<input
type="hidden"
name="order_id"
value="<?= $orderId ?>">

<div class="star-group">

<?php for($i=5;$i>=1;$i--): ?>

<input

type="radio"

name="rating"

id="star<?= $i ?>"

value="<?= $i ?>"

>

<label for="star<?= $i ?>">

★

</label>

<?php endfor; ?>

</div>

<div
id="ratingText"
class="star-text">

Pilih rating

</div>

<div class="quick-title">

Tambahkan kalimat cepat

</div>

<div class="quick-list">

<div class="quick-chip">

Produk sesuai deskripsi.

</div>

<div class="quick-chip">

Pengiriman cepat.

</div>

<div class="quick-chip">

Harga terjangkau.

</div>

<div class="quick-chip">

Packing sangat rapi.

</div>

<div class="quick-chip">

Penjual ramah.

</div>

<div class="quick-chip">

Sangat direkomendasikan.

</div>

</div>

<textarea

name="review"

id="reviewBox"

maxlength="1000"

placeholder="Ceritakan pengalamanmu menggunakan produk ini..."

><?= htmlspecialchars($_POST["review"] ?? "") ?></textarea>

<div class="char-counter">

<span id="counter">

0

</span>

/1000 karakter

</div>

<button
class="submit-btn"
type="submit">

⭐ Kirim Ulasan

</button>

</form>

</div>

</div>
    
<script>

const ratingText = document.getElementById("ratingText");

const ratingMessage = {
    1:"😞 Sangat Buruk",
    2:"😕 Buruk",
    3:"😐 Cukup",
    4:"😊 Bagus",
    5:"🤩 Sangat Bagus"
};

document.querySelectorAll("input[name='rating']").forEach(function(radio){

    radio.addEventListener("change",function(){

        ratingText.innerHTML = ratingMessage[this.value];

    });

});

/* Character Counter */

const reviewBox = document.getElementById("reviewBox");
const counter = document.getElementById("counter");

function updateCounter(){

    counter.innerHTML = reviewBox.value.length;

}

updateCounter();

reviewBox.addEventListener(
    "input",
    updateCounter
);

/* Quick Chips */

document.querySelectorAll(".quick-chip").forEach(function(chip){

    chip.addEventListener("click",function(){

        this.classList.toggle("active");

        const text = this.innerText;

        if(this.classList.contains("active")){

            if(reviewBox.value.trim()!=""){

                reviewBox.value += " ";

            }

            reviewBox.value += text;

        }else{

            reviewBox.value =
            reviewBox.value.replace(text,"");

            reviewBox.value =
            reviewBox.value.replace(/\s+/g," ").trim();

        }

        updateCounter();

    });

});

/* Sidebar */

document.addEventListener(
"DOMContentLoaded",
function(){

const sidebar =
document.getElementById("sidebar");

const toggle =
document.getElementById("sidebarToggle");

const content =
document.getElementById("mainContent");

if(!sidebar || !toggle || !content){

return;

}

function updateLayout(){

if(sidebar.classList.contains("closed")){

content.classList.add("expanded");

}else{

content.classList.remove("expanded");

}

}

updateLayout();

toggle.addEventListener(
"click",
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
