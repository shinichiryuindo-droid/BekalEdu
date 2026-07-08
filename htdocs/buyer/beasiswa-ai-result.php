<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header("Location: ../login.php");
    exit;
}

require_once("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: beasiswa-ai.php");
    exit;
}

$level = trim($_POST['level']);
$userInput = trim($_POST['userInput']);

$fileapi = '../includes/gemini-api-key.txt';

$lines = file($fileapi, FILE_IGNORE_NEW_LINES);

if ($lines !== false && isset($lines[2])) {
    $apiKey = $lines[2];
} else {
    $apiKey = null;
}

/* ==========================
   read beasiswa
========================== */

$stmt = $conn->prepare("
SELECT
title,
institution,
location,
level,
description,
deadline
FROM scholarships
WHERE level = ?
ORDER BY RAND()
");

$stmt->bind_param("s", $level);
$stmt->execute();

$result = $stmt->get_result();

$scholarships = "";

$no = 1;

while($row = $result->fetch_assoc()){

    
    
    $scholarships .=
"Scholarship #{$no}

Title: {$row['title']}
Institution: {$row['institution']}
Location: {$row['location']}
Level: {$row['level']}
Deadline: {$row['deadline']}

Description:
{$row['description']}

----------------------------------------

";

    $no++;
}

$stmt->close();

/* ==========================
   system prompt
========================== */

$prompt = "

PROFIL SISWA INI ADALAH PRIORITAS.

Jangan memberikan rekomendasi umum.

Sesuaikan rekomendasi berdasarkan informasi tambahan siswa. prioritaskan beasiswa yang berkaitan dengan bidang tersebut.

Anda adalah seorang ahli pendidikan dan beasiswa.

Berikut adalah informasi seorang siswa.

Tingkat pendidikan target:
{$level}

Informasi tambahan siswa:
{$userInput}

Berikut adalah semua beasiswa yang tersedia.

{$scholarships}

Tugas Anda:

1. Anda WAJIB membaca SELURUH daftar beasiswa.

2. Bandingkan SATU PER SATU semua beasiswa.

3. Beri skor kecocokan (1-100) untuk setiap beasiswa berdasarkan profil siswa.

4. Pilih 5 skor tertinggi.

5. Jangan memilih berdasarkan urutan kemunculan.

6. Jika ada beasiswa yang lebih cocok meskipun berada di bagian bawah daftar, pilihlah beasiswa tersebut.

7. Gunakan seluruh informasi siswa sebelum mengambil keputusan.

PENTING:

Kembalikan HANYA HTML.

JANGAN kembalikan Markdown.

Gunakan struktur ini:

<h2>Rekomendasi Beasiswa AI</h2>

Untuk setiap rekomendasi:

<div style='background:white;border:1px solid #ddd;padding:20px;margin-bottom:20px;border-radius:12px;'>

<h3>Nama Beasiswa #1</h3>

<p><strong>Institusi:</strong> ...</p>

<p><strong>Lokasi:</strong> ...</p>

<p><strong>Alasan:</strong> ...</p>

<p><strong>Keuntungan:</strong> ...</p>

<p><strong>Kemungkinan kekurangan:</strong> ...</p>

</div>

Akhiri dengan

<h2>Rekomendasi Akhir</h2>

<p>...</p>
";

/* ==========================
   GEMINI
========================== */

/*
btw ges gw pk curl aj lngsng ya 
ribet bgt kl pake yg lain
*/

/* VARIABEL apikey DISETEL DI PALING ATAS FILEEEEEEE */

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey;

$data = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => $prompt
                ]
            ]
        ]
    ],
    "generationConfig" => [
        "temperature" => 1.3,
        "topP" => 0.95,
        "topK" => 40,
    ]
];
$ch = curl_init($url);

curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POST,true);
curl_setopt($ch,CURLOPT_HTTPHEADER,[
    "Content-Type: application/json"
]);
curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));

$response = curl_exec($ch);

curl_close($ch);

$response = json_decode($response,true);

$html =
$response['candidates'][0]['content']['parts'][0]['text']
?? "<h2>Unable to generate recommendations.</h2>";

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<title>Rekomendasi Beasiswa dari Analisis AI</title>

<link rel="stylesheet" href="../assets/css/style.css">

<style>

body{
    background:#f8fafc;
    margin:0;
    font-family:Segoe UI;
}

.container{

    max-width:1000px;

    margin:40px auto;

    background:white;

    padding:40px;

    border-radius:18px;

    box-shadow:0 10px 30px rgba(0,0,0,.08);

}

.back{

    display:inline-block;

    margin-bottom:25px;

}

.container h2{

    color:#2563eb;

}

</style>

</head>

<body>

<div class="container">

<a href="beasiswa-ai.php" class="btn btn-outline back">
← Back
</a>

<?php echo $html; ?>

</div>

</body>
</html>