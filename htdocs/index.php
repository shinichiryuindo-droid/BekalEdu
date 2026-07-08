<?php

session_start();

/* bole panjang tuh */

if(isset($_SESSION['user_id'])){

    switch($_SESSION['role']){

        case 'buyer':
            header('Location: /dashboard/buyer.php');
            exit;

        case 'seller':
            header('Location: /dashboard/seller.php');
            exit;

        case 'partner':
            header('Location: /dashboard/partner.php');
            exit;

        case 'pending_partner':
            header('Location: /menunggu-verifikasi.php');
            exit;

    }

}

require_once 'includes/config.php';

$featuredScholarships = $conn->query(
    "SELECT
        id,
        title,
        institution,
        deadline
     FROM scholarships
     ORDER BY created_at DESC
     LIMIT 3"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Bekal Edu</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    background:#f8fafc;
    color:#111827;
}

html{
    scroll-behavior:smooth;
}

.container{
    width:90%;
    max-width:1200px;
    margin:auto;
}


/* =======================
HERO
======================= */

.hero{

    min-height:100vh;

    display:flex;

    align-items:center;

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #60a5fa
    );

    color:white;

    padding-top:100px;

}

.hero-content{

    text-align:center;

}

.hero h1{

    font-size:64px;

    margin-bottom:25px;

}

.hero p{

    font-size:22px;

    max-width:900px;

    margin:auto;

    margin-bottom:40px;

    line-height:1.8;

}

.hero-buttons{

    display:flex;

    justify-content:center;

    gap:20px;

    flex-wrap:wrap;
}

.hero-buttons a{

    background:white;

    color:#2563eb;

    padding:16px 28px;

    border-radius:14px;

    text-decoration:none;

    font-weight:bold;

    transition:.3s;

}

.hero-buttons a:hover{

    transform:translateY(-4px);

}

/* =======================
STATS
======================= */

.stats{

    padding:100px 0;

    background:white;

}

.stats-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:25px;

}

.stat-card{

    text-align:center;

    padding:35px;

    border-radius:20px;

    background:#f8fafc;

    transition:.3s;

}

.stat-card:hover{

    transform:translateY(-6px);

}

.stat-number{

    font-size:42px;

    font-weight:bold;

    color:#2563eb;

}

/* =======================
FEATURES
======================= */

.section{

    padding:100px 0;

}

.section-title{

    text-align:center;

    margin-bottom:60px;

}

.section-title h2{

    font-size:42px;

    margin-bottom:10px;

}

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(280px,1fr));

    gap:30px;

}

.card{

    background:white;

    padding:35px;

    border-radius:22px;

    box-shadow:
    0 10px 25px rgba(0,0,0,.05);

    transition:.3s;
}

.card:hover{

    transform:translateY(-8px);

}

.card-icon{

    font-size:50px;

    margin-bottom:20px;
}

/* =======================
SHOWCASE
======================= */

.showcase{

    background:white;

}

.showcase-card{

    background:#f8fafc;

    border-radius:20px;

    padding:25px;

}

.showcase-card h3{

    margin-bottom:10px;

}

.deadline{

    color:#dc2626;
}

/* =======================
TESTIMONIALS
======================= */

.testimonials{

    background:#eff6ff;
}

.testimonial{

    background:white;

    padding:30px;

    border-radius:20px;
}

/* =======================
FAQ
======================= */

.faq-item{

    background:white;

    padding:25px;

    border-radius:16px;

    margin-bottom:15px;

}

.faq-item h3{

    margin-bottom:10px;
}

/* =======================
CTA
======================= */

.cta{

    background:#2563eb;

    color:white;

    text-align:center;

    padding:120px 20px;

}

.cta h2{

    font-size:48px;

    margin-bottom:20px;

}

.cta a{

    display:inline-block;

    margin:10px;

    background:white;

    color:#2563eb;

    text-decoration:none;

    padding:15px 25px;

    border-radius:14px;

    font-weight:bold;
}

/* =======================
FOOTER
======================= */

footer{

    background:#111827;

    color:white;

    text-align:center;

    padding:50px 20px;

}

footer p{

    opacity:.8;
}

</style>

</head>

<body>
<link
rel="stylesheet"
href="assets/css/style.css">

<?php include 'includes/topbar.php'; ?>

<section class="hero">

<div class="container hero-content">

<h1>
Masa Depan Pendidikan Dimulai di Sini
</h1>

<p>

Bekal Edu menghubungkan siswa,
penjual perlengkapan sekolah,
dan penyedia beasiswa dalam satu platform modern.

</p>

<div class="hero-buttons">

<a href="register/index.php">
Daftar Sekarang
</a>

<a href="#features">
Pelajari Lebih Lanjut
</a>

</div>

</div>

</section>

<section class="stats">

<div class="container">

<div class="stats-grid">

<div class="stat-card">
<div class="stat-number">12.543+</div>
Siswa Terdaftar
</div>

<div class="stat-card">
<div class="stat-number">438+</div>
Mitra Aktif
</div>

<div class="stat-card">
<div class="stat-number">8.324+</div>
Produk
</div>

<div class="stat-card">
<div class="stat-number">1.271+</div>
Beasiswa
</div>

</div>

</div>

</section>

<section id="features" class="section">

<div class="container">

<div class="section-title">

<h2>
Kenapa Bekal Edu?
</h2>

</div>

<div class="grid">

<div class="card">
<div class="card-icon">🎓</div>
<h3>Beasiswa</h3>
<p>Temukan peluang pendidikan dari berbagai institusi.</p>
</div>

<div class="card">
<div class="card-icon">🛒</div>
<h3>Marketplace</h3>
<p>Beli kebutuhan sekolah langsung dari penjual terpercaya.</p>
</div>

<div class="card">
<div class="card-icon">💬</div>
<h3>Chat Langsung</h3>
<p>Komunikasi cepat antara siswa, penjual, dan mitra.</p>
</div>


</div>

</section>

<section class="section showcase">

<div class="container">

<div class="section-title">

<h2>
🎓 Beasiswa Terbaru
</h2>

<p>
Program beasiswa terbaru dari institusi mitra.
</p>

</div>

<div class="grid">

<?php

if(
    $featuredScholarships &&
    $featuredScholarships->num_rows > 0
):

while(
    $scholarship =
    $featuredScholarships->fetch_assoc()
):

?>

<div class="showcase-card">

<h3>

<?php

echo htmlspecialchars(
    $scholarship['title']
);

?>

</h3>

<p>

🏛️

<?php

echo htmlspecialchars(
    $scholarship['institution']
);

?>

</p>

<p class="deadline">

📅 Deadline:

<?php

echo date(
    'd M Y',
    strtotime(
        $scholarship['deadline']
    )
);

?>

</p>

<br>

<a
href="beasiswa-detail.php?id=<?php echo $scholarship['id']; ?>"
style="
display:inline-block;
padding:10px 16px;
background:#2563eb;
color:white;
border-radius:10px;
text-decoration:none;
">

Lihat Detail

</a>

</div>

<?php

endwhile;

else:

?>

<div class="showcase-card">

<h3>
Belum Ada Beasiswa
</h3>

<p>
Saat ini belum ada program beasiswa yang tersedia.
</p>

</div>

<?php endif; ?>

</div>

</div>

</section>
    
<section class="section">

<div class="container">

<div class="section-title">
<h2>Produk Populer</h2>
</div>

<div class="grid">

<div class="card">🎒 Tas Sekolah</div>
<div class="card">📚 Buku Tulis</div>
<div class="card">🖊️ Alat Tulis</div>
<div class="card">💻 Laptop Pelajar</div>
<div class="card">📐 Kalkulator</div>
<div class="card">👕 Seragam Sekolah</div>

</div>

</div>

</section>

<section class="section testimonials">

<div class="container">

<div class="section-title">
<h2>Kisah Sukses</h2>
</div>

<div class="grid">

<div class="testimonial">
"Saya mendapatkan beasiswa penuh melalui Bekal Edu."
<br><br>
<b>Andi - Surabaya</b>
</div>

<div class="testimonial">
"Penjualan toko saya meningkat drastis."
<br><br>
<b>Toko Maju Jaya</b>
</div>

<div class="testimonial">
"Kami berhasil menjangkau ribuan siswa."
<br><br>
<b>Yayasan Pendidikan Nusantara</b>
</div>

</div>

</div>

</section>

<section class="section">

<div class="container">

<div class="section-title">
<h2>FAQ</h2>
</div>

<div class="faq-item">
<h3>Apakah Bekal Edu gratis?</h3>
<p>Ya, siswa dapat mendaftar dan menggunakan fitur utama secara gratis.</p>
</div>

<div class="faq-item">
<h3>Bagaimana cara melamar beasiswa?</h3>
<p>Daftar akun siswa lalu pilih program beasiswa yang tersedia.</p>
</div>

<div class="faq-item">
<h3>Apakah bisa chat langsung?</h3>
<p>Ya, siswa dapat menghubungi penjual dan mitra melalui fitur chat.</p>
</div>

<div class="faq-item">
<h3>Apakah aman?</h3>
<p>Kami menggunakan sistem autentikasi dan pengelolaan data yang aman.</p>
</div>

</div>

</section>

<section class="cta">

<h2>
Siap Memulai?
</h2>

<p style="margin-bottom:30px;">
Bergabung bersama ribuan siswa, penjual, dan mitra pendidikan.
</p>

<a href="register/buyer.php">
Daftar Siswa
</a>

<a href="register/seller.php">
Daftar Penjual
</a>

<a href="register/partner.php">
Daftar Mitra
</a>

</section>

<footer>

<h2>
🎓 Bekal Edu
</h2>

<br>

<p>
Platform pendidikan yang menghubungkan siswa,
penjual perlengkapan sekolah,
dan penyedia beasiswa.
</p>

<br>

<p>
© 2026 Bekal Edu
</p>

</footer>

</body>
</html>