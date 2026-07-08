<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/config.php");

$levels = $conn->query("
SELECT DISTINCT level
FROM scholarships
ORDER BY level
");
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>AI Rekomendasi Beasiswa</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

.ai-container{
    max-width:900px;
    margin:40px auto;
}

.ai-card{
    background:white;
    border-radius:18px;
    padding:35px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.ai-card h1{
    margin-top:0;
    font-size:30px;
}

.ai-card p{
    color:#64748b;
    line-height:1.7;
}

.form-group{
    margin-top:25px;
}

.form-group label{
    display:block;
    font-weight:700;
    margin-bottom:10px;
}

.form-group select,
.form-group textarea{

    width:100%;

    padding:15px;

    border:1px solid #dbe3ee;

    border-radius:12px;

    font-size:15px;

    font-family:inherit;

}

.form-group textarea{

    min-height:220px;

    resize:vertical;

}

.ai-btn{

    margin-top:25px;

    width:100%;

    padding:16px;

    border:none;

    border-radius:12px;

    background:#2563eb;

    color:white;

    font-size:16px;

    font-weight:bold;

    cursor:pointer;

}

.ai-btn:hover{

    background:#1d4ed8;

}

.tip{

    margin-top:20px;

    padding:18px;

    background:#eff6ff;

    border-radius:12px;

    color:#1e3a8a;

    line-height:1.7;

}

</style>

</head>

<body>

<?php include("../includes/sidebar-buyer.php"); ?>

<div class="main-content">

<div class="ai-container">

<div class="ai-card">

<h1>🤖 AI Rekomendasi Beasiswa</h1>

<p>

Masukkan informasi mengenai diri Anda agar AI dapat memilih
<b>5 beasiswa yang paling cocok</b> berdasarkan seluruh database
Bekal Edu.

</p>

<form action="beasiswa-ai-result.php" method="POST">

<div class="form-group">

<label>Jenjang Pendidikan</label>

<select name="level" required>

<option value="">Pilih Jenjang</option>

<?php while($lvl = $levels->fetch_assoc()): ?>

<option value="<?= htmlspecialchars($lvl['level']) ?>">
<?= htmlspecialchars($lvl['level']) ?>
</option>

<?php endwhile; ?>

</select>

</div>

<div class="form-group">

<label>Ceritakan tentang diri Anda</label>

<textarea
name="userInput"
required
placeholder="Contoh:

- Saya siswa kelas 12 SMA.
- Nilai rata-rata 89.
- Ingin kuliah Teknik Informatika.
- Orang tua berpenghasilan rendah.
- Lebih memilih beasiswa penuh.
- Bersedia kuliah di luar kota.
- Aktif organisasi.
- Memiliki prestasi lomba.
"></textarea>

</div>

<div class="tip">

<b>AI akan mempertimbangkan:</b>

<ul>

<li>Jenjang pendidikan</li>

<li>Lokasi beasiswa</li>

<li>Institusi penyelenggara</li>

<li>Kecocokan dengan profil Anda</li>

<li>Persyaratan beasiswa</li>

<li>Peluang diterima</li>

</ul>

</div>

<button class="ai-btn">

✨ Cari 5 Beasiswa Terbaik

</button>

</form>

</div>

</div>

</div>

</body>
</html>