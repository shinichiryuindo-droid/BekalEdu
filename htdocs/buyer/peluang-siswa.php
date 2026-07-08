<?php
session_start();

require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'buyer') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$user = $conn->query("
SELECT
    full_name,
    school,
    city
FROM users
WHERE id = $user_id
")->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pusat Peluang Siswa | Bekal Edu</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

<style>

body{
    background:#f4f8fd;
}

.page{
    max-width:1300px;
    margin:auto;
    padding:35px;
}

.hero-opportunity{

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color:white;

    border-radius:26px;

    padding:55px;

    margin-bottom:35px;

    position:relative;

    overflow:hidden;

}

.hero-opportunity::after{

    content:"🚀";

    position:absolute;

    right:40px;

    top:25px;

    font-size:120px;

    opacity:.12;

}

.hero-opportunity h1{

    font-size:44px;

    margin-bottom:15px;

}

.hero-opportunity p{

    font-size:18px;

    max-width:800px;

    opacity:.95;

    line-height:1.8;

}

.search-box{

    margin-top:35px;

    display:flex;

    gap:15px;

    flex-wrap:wrap;

}

.search-box input{

    flex:1;

    padding:18px;

    border:none;

    border-radius:14px;

    font-size:16px;

}

.search-box button{

    border:none;

    background:#111827;

    color:white;

    padding:18px 28px;

    border-radius:14px;

    cursor:pointer;

    font-weight:bold;

}

.ai-card{

    margin-top:35px;

    background:white;

    border-radius:22px;

    padding:30px;

    box-shadow:0 12px 30px rgba(0,0,0,.06);

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:25px;

    flex-wrap:wrap;

}

.ai-card h2{

    margin-bottom:10px;

}

.ai-card button{

    background:#2563eb;

    color:white;

    border:none;

    padding:15px 28px;

    border-radius:14px;

    cursor:pointer;

    font-weight:bold;

}

.category-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(220px,1fr));

    gap:25px;

    margin-top:35px;

}

.category-card{

    background:white;

    padding:30px;

    border-radius:20px;

    text-align:center;

    transition:.3s;

    cursor:pointer;

    box-shadow:0 8px 25px rgba(0,0,0,.05);

}

.category-card:hover{

    transform:translateY(-8px);

}

.category-card .icon{

    font-size:60px;

    margin-bottom:20px;

}

.category-card h3{

    margin-bottom:12px;

}

.category-card p{

    color:#6b7280;

    line-height:1.7;

}

.section-title{

    margin-top:50px;

    margin-bottom:20px;

}

.filter-bar{

    display:flex;

    gap:15px;

    flex-wrap:wrap;

    margin-bottom:30px;

}

.filter-bar select{

    padding:12px 18px;

    border-radius:12px;

    border:1px solid #ddd;

}

@media(max-width:768px){

.hero-opportunity{

padding:30px;

}

.hero-opportunity h1{

font-size:32px;

}

.page{

padding:18px;

}

.search-box{

flex-direction:column;

}

.search-box button{

width:100%;

}

}

</style>

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="page">

<div class="hero-opportunity">

<h1>
🚀 Pusat Peluang Siswa
</h1>

<p>

Halo
<b><?php echo htmlspecialchars($user['full_name']); ?></b>.

Temukan berbagai peluang untuk meningkatkan pengalaman,
portofolio,
dan kariermu.

Cari magang,
kompetisi,
bootcamp,
program relawan,
hingga peluang kreatif
dalam satu tempat.

</p>

<div class="search-box">

<input
type="text"
placeholder="Cari peluang... contoh: UI/UX, Programming, Data Science">

<button>

🔍 Cari Peluang

</button>

</div>

</div>

<div class="ai-card">

<div>

<h2>
🤖 AI Rekomendasi Peluang
</h2>

<p>

AI akan menganalisis profilmu,
sekolah,
kota,
dan aktivitasmu
untuk memberikan rekomendasi peluang
yang paling sesuai.

</p>

</div>

<button>

Buat Rekomendasi AI

</button>

</div>

<h2 class="section-title">

Kategori Peluang

</h2>

<div class="category-grid">

<div class="category-card">

<div class="icon">

💼

</div>

<h3>

Magang

</h3>

<p>

Temukan program magang
dari perusahaan,
startup,
dan organisasi.

</p>

</div>

<div class="category-card">

<div class="icon">

🏆

</div>

<h3>

Kompetisi

</h3>

<p>

Hackathon,
olimpiade,
kompetisi bisnis,
UI/UX,
dan lainnya.

</p>

</div>

<div class="category-card">

<div class="icon">

📚

</div>

<h3>

Bootcamp

</h3>

<p>

Pelajari skill baru
melalui bootcamp
online maupun offline.

</p>

</div>

<div class="category-card">

<div class="icon">

🤝

</div>

<h3>

Relawan

</h3>

<p>

Ikut kegiatan sosial
untuk menambah pengalaman
dan relasi.

</p>

</div>

<div class="category-card">

<div class="icon">

🎨

</div>

<h3>

Peluang Kreatif

</h3>

<p>

Lomba desain,
fotografi,
penulisan,
video,
musik,
dan karya kreatif lainnya.

</p>

</div>

</div>

<h2 class="section-title">

Filter Peluang

</h2>

<div class="filter-bar">

<select>

<option>Semua Kategori</option>

<option>Magang</option>

<option>Kompetisi</option>

<option>Bootcamp</option>

<option>Relawan</option>

<option>Peluang Kreatif</option>

</select>

<select>

<option>Semua Lokasi</option>

<option>Online</option>

<option>Offline</option>

<option>Hybrid</option>

</select>

<select>

<option>Semua Tingkat</option>

<option>SMA/SMK</option>

<option>Mahasiswa</option>

<option>Umum</option>

</select>

</div>

<div class="ai-card">

    <h2>🎯 Jenis Peluang</h2>

    <div class="type-grid">

        <label class="type-item">
            <input type="checkbox" name="types[]" value="internship" checked>
            <span>💼 Magang</span>
        </label>

        <label class="type-item">
            <input type="checkbox" name="types[]" value="competition" checked>
            <span>🏆 Lomba</span>
        </label>

        <label class="type-item">
            <input type="checkbox" name="types[]" value="bootcamp" checked>
            <span>💻 Bootcamp</span>
        </label>

        <label class="type-item">
            <input type="checkbox" name="types[]" value="volunteer" checked>
            <span>🤝 Volunteer</span>
        </label>

        <label class="type-item">
            <input type="checkbox" name="types[]" value="creative" checked>
            <span>🎨 Creative Opportunity</span>
        </label>

    </div>

</div>

<div class="ai-card">

    <h2>📍 Lokasi</h2>

    <select name="location">

        <option value="">Seluruh Indonesia</option>

        <option>Jakarta</option>
        <option>Bandung</option>
        <option>Surabaya</option>
        <option>Yogyakarta</option>
        <option>Semarang</option>
        <option>Malang</option>
        <option>Bali</option>
        <option>Online</option>

    </select>

</div>

<div class="ai-card">

    <h2>🎓 Jenjang Pendidikan</h2>

    <select name="education">

        <option value="">Semua Jenjang</option>
        <option>SMA / SMK</option>
        <option>Mahasiswa D3</option>
        <option>Mahasiswa S1</option>
        <option>S2</option>

    </select>

</div>

<div class="ai-card">

    <h2>📝 Kata Kunci Tambahan</h2>

    <textarea
        name="prompt"
        rows="5"
        placeholder="Contoh:
Saya ingin magang AI di Jakarta yang menerima mahasiswa semester 4, bersertifikat, dan memiliki uang saku."></textarea>

</div>

<button class="search-btn">
    🔍 Cari Peluang Menggunakan AI
</button>

</form>

</div>

<div class="tips-grid">

    <div class="tip-card">
        <h3>💼 Magang</h3>
        <p>
            AI mencari peluang magang terbaru dari perusahaan,
            startup, universitas, dan instansi pemerintah.
        </p>
    </div>

    <div class="tip-card">
        <h3>🏆 Lomba</h3>
        <p>
            Temukan lomba nasional maupun internasional,
            hackathon, business case, karya tulis,
            olimpiade, dan kompetisi teknologi.
        </p>
    </div>

    <div class="tip-card">
        <h3>💻 Bootcamp</h3>
        <p>
            Cari bootcamp gratis maupun berbayar,
            program pelatihan bersertifikat,
            hingga kelas online.
        </p>
    </div>

    <div class="tip-card">
        <h3>🤝 Volunteer</h3>
        <p>
            Temukan kegiatan sosial,
            organisasi,
            NGO,
            kepanitiaan,
            dan volunteer internasional.
        </p>
    </div>

    <div class="tip-card">
        <h3>🎨 Creative Opportunity</h3>
        <p>
            AI juga mencari open submission,
            inkubator startup,
            fellowship,
            research assistant,
            creator program,
            ambassador,
            hingga talent scouting.
        </p>
    </div>

    <div class="tip-card">
        <h3>🤖 AI Powered</h3>
        <p>
            Sistem akan menggunakan profil akunmu,
            kata kunci pencarian,
            serta Gemini AI untuk menemukan peluang
            yang paling relevan dari internet.
        </p>
    </div>

</div>

</div>

</body>

</html>