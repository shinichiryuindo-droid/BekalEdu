<?php
session_start();

/*
=========================================================
GEMINI CONFIG
=========================================================
*/
$fileapi = '../includes/gemini-api-key.txt';

$lines = file($fileapi, FILE_IGNORE_NEW_LINES);

if ($lines !== false && isset($lines[2])) {
    $GEMINI_API_KEY = $lines[2];
} else {
    $GEMINI_API_KEY = null;
}

$response = "";
$error = "";

$form = [

    "keyword" => "",
   "location" => "",
    "achievement" => "",
    "portofolio" => "",
    "financial" => "",
    "international" => "",

];

/*
=========================================================
baca from
=========================================================
*/

if($_SERVER["REQUEST_METHOD"]=="POST"){

    foreach($form as $k=>$v){
        $form[$k]=trim($_POST[$k] ?? "");
    }

    /*
    =========================================================
    prompt
    =========================================================
    */

$prompt = "
Anda adalah konsultan beasiswa profesional.

Carikan beasiswa yang paling sesuai dengan profil pengguna.

Cari beasiswa yang:
- Masih dibuka ATAU diperkirakan akan segera dibuka.
- Beasiswa yang benar-benar ada.
- Jika sudah ditutup, tuliskan bahwa periode pendaftarannya telah berakhir.

Untuk setiap beasiswa tampilkan:

1. Nama Beasiswa
2. Negara
3. Universitas (jika ada)
4. Cakupan Beasiswa
5. Persyaratan
6. Deadline
7. Website Resmi
8. Link Pendaftaran
9. Alasan beasiswa cocok dengan profil pengguna
10. Tingkat persaingan (Rendah/Sedang/Tinggi)

Kemudian berikan TOP 5 rekomendasi terbaik berdasarkan profil pengguna.

Gunakan Bahasa Indonesia sepenuhnya dan gunakan format Markdown yang rapi.

Kata Kunci:
{$form["keyword"]}

Lokasi:
{$form["location"]}

Prestasi:
{$form["achievement"]}

Portofolio / Deskripsi Diri:
{$form["portofolio"]}

Need Based:
{$form["financial"]}

International:
{$form["international"]}

Terapkan semuanya dalam bahasa indonesia dalam format markdown
dan jangan katakan seperti sebagai konsultan beasiswa profesional... pada pengguna
mulai dari berdasarkan profilmu..	

";

    /*
    =========================================================
    GEMINI
    =========================================================
    */

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$GEMINI_API_KEY;

    $payload = [

        "contents"=>[
            [
                "parts"=>[
                    [
                        "text"=>$prompt
                    ]
                ]
            ]
        ]

    ];

    $ch = curl_init($url);

    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    curl_setopt($ch,CURLOPT_POST,true);

    curl_setopt($ch,CURLOPT_HTTPHEADER,[

        "Content-Type: application/json"

    ]);

    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($payload));

    $result = curl_exec($ch);

    if(curl_errno($ch)){

        $error = curl_error($ch);

    }

    curl_close($ch);

    if(empty($error)){

        $json = json_decode($result,true);

        if(isset($json["candidates"][0]["content"]["parts"][0]["text"])){

            $response = $json["candidates"][0]["content"]["parts"][0]["text"];

        }elseif(isset($json["error"]["message"])){

            $error = $json["error"]["message"];

        }else{

            $error = "Gemini returned an unexpected response.";

        }

    }
}
	
?>



<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

AI Pencari Beasiswa Web

</title>

<link
href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
rel="stylesheet">

<style>

*{

margin:0;
padding:0;
box-sizing:border-box;

}

body{

font-family:Inter,sans-serif;

background:#f3f6fb;

color:#1f2937;

}

.container{

max-width:1200px;

margin:auto;

padding:40px;

}

.hero{

background:linear-gradient(135deg,#2563eb,#4f46e5);

color:white;

padding:45px;

border-radius:22px;

margin-bottom:35px;

box-shadow:0 12px 40px rgba(0,0,0,.12);

}

.hero h1{

font-size:40px;

margin-bottom:10px;

}

.hero p{

font-size:17px;

opacity:.9;

}

.card{

background:white;

border-radius:18px;

padding:35px;

box-shadow:0 8px 25px rgba(0,0,0,.08);

margin-bottom:30px;

}

.grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:20px;

}

.input-group{

display:flex;

flex-direction:column;

}

.input-group label{

font-weight:700;

margin-bottom:8px;

}

.input-group input,

.input-group textarea,

.input-group select{

padding:13px 15px;

border-radius:12px;

border:1px solid #d1d5db;

font-size:15px;

outline:none;

transition:.2s;

}

.input-group input:focus,

.input-group textarea:focus,

.input-group select:focus{

border-color:#2563eb;

}

textarea{

resize:vertical;

min-height:120px;

}

.full{

grid-column:1/3;

}

button{

background:#2563eb;

color:white;

border:none;

padding:18px;

font-size:17px;

font-weight:700;

border-radius:14px;

cursor:pointer;

transition:.2s;

width:100%;

}

button:hover{

background:#1d4ed8;

}

.response{

margin-top:30px;

padding:25px;

border-radius:18px;

background:white;

box-shadow:0 6px 20px rgba(0,0,0,.08);

}

.loading{

display:none;

text-align:center;

padding:20px;

font-size:17px;

font-weight:bold;

}

@media(max-width:900px){

.grid{

grid-template-columns:1fr;

}

.full{

grid-column:auto;

}

.container{

padding:18px;

}

.hero h1{

font-size:30px;

}

}

.response{
    margin-top:30px;
    background:#fff;
    border-radius:16px;
    padding:30px;
    box-shadow:0 8px 24px rgba(0,0,0,.08);
    line-height:1.8;
}

.response h1,
.response h2,
.response h3{
    color:#1d4ed8;
    margin-top:25px;
    margin-bottom:10px;
}

.response ul{
    padding-left:20px;
}

.response li{
    margin-bottom:8px;
}

.response a{
    color:#2563eb;
    text-decoration:none;
    font-weight:bold;
}

.response a:hover{
    text-decoration:underline;
}

.toolbar{
    display:flex;
    gap:12px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.toolbar button{
    padding:10px 18px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
    background:#2563eb;
    color:white;
}

.toolbar button:hover{
    background:#1d4ed8;
}

.badge{
    display:inline-block;
    padding:4px 10px;
    border-radius:999px;
    background:#dbeafe;
    color:#1d4ed8;
    font-size:12px;
    font-weight:bold;
    margin-right:6px;
    margin-bottom:6px;
}

</style>

</head>

<body>

<div class="container">

<?php 
if($error!=""){
echo "Gemini Error : ".htmlspecialchars($error); 
}
?>

<?php if($response!=""): ?>

<div class="toolbar">

<button onclick="copyResult()">
📋 Copy
</button>

</div>

<div
class="response"
id="result">
<?= nl2br(htmlspecialchars($response)) ?>
</div>
<?php endif; ?>
    
<div class="hero">

<h1>
🎓 Pencari Beasiswa Internet Berbasis AI
</h1>
<p>
Temukan rekomendasi beasiswa yang paling sesuai dengan profil, prestasi, dan portofolio Anda di internet menggunakan Google Gemini AI.
</p>
</div>

<form method="post">
<div class="card">
<div class="grid">
<div class="input-group">
<label>
Kata kunci
</label>
<input
type="text"
name="keyword"
placeholder="Informatika, LPDP, Jepang..."
value="<?=htmlspecialchars($form["keyword"])?>">
</div>

<div class="input-group">
<label>
Lokasi Anda
</label>
<input
type="text"
name="location"
placeholder="Jakarta"
value="<?=htmlspecialchars($form["location"])?>">
</div>
    
<div class="input-group full">
<label>
Prestasi
</label>
<textarea
name="achievement"
placeholder="Contoh: Juara Olimpiade, lomba, sertifikat, penghargaan..."><?=htmlspecialchars($form["achievement"])?></textarea>
</div>

<div class="input-group full">
<label>
Portofolio / Ceritakan Tentang Diri Anda
</label>
<textarea
name="portfolio"
placeholder="Contoh: Saya mahasiswa semester 5 Teknik Informatika yang aktif mengembangkan aplikasi web, mengikuti pelatihan AI, memiliki pengalaman magang, pernah menjadi asisten dosen, aktif menjadi relawan, dan sedang mencari beasiswa untuk melanjutkan studi."><?=htmlspecialchars($form["portfolio"])?></textarea>
</div>

<div class="input-group">
<label>
Beasiswa Berdasarkan Kebutuhan?
</label>
<select name="financial">
<option value="">Tidak Ada Preferensi</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>
</div>

<div class="input-group">
<label>
Beasiswa Internasional?
</label>
<select name="international">
<option value="">Tidak Ada Preferensi</option>
<option value="Yes">Yes</option>
<option value="No">No</option>
</select>

</div>

<div class="full">

<button type="submit">
🔍 Cari Beasiswa
</button>

</div>

</div>

</div>

</form>
    
<div
id="loading"
class="loading">
Sedang mencari beasiswa di internet dengan Gemini...
</div>

</div>

<script>

const form=document.querySelector("form");
const loading=document.getElementById("loading");
form.addEventListener("submit",function(){
loading.style.display="block";

});

</script>

<script>

function copyResult(){
    const text =
    document.getElementById("result").innerText;
    navigator.clipboard.writeText(text);
    alert("Hasil berhasil disalin.");

}

/*
Url bs diklik
*/

document.addEventListener("DOMContentLoaded",function(){
    const result =
    document.getElementById("result");
    if(!result) return;
    let html = result.innerHTML;
    html = html.replace(
        /(https?:\/\/[^\s<]+)/g,
        '<a href="$1" target="_blank">$1</a>'
    );

    html = html.replace(
        /\*\*(.*?)\*\*/g,
        "<strong>$1</strong>"
    );

    html = html.replace(
        /^### (.*)$/gm,
        "<h3>$1</h3>"
    );

    html = html.replace(

        /^## (.*)$/gm,

        "<h2>$1</h2>"

    );

    html = html.replace(

        /^# (.*)$/gm,

        "<h1>$1</h1>"

    );

    html = html.replace(

        /- Fully Funded/gi,

        '<span class="badge">Fully Funded</span>'

    );

    html = html.replace(

        /- Partial/gi,

        '<span class="badge">Partial</span>'

    );

    html = html.replace(

        /Indonesia/gi,

        '<span class="badge">Indonesia</span> Indonesia'

    );

    html = html.replace(

        /International/gi,

        '<span class="badge">International</span> International'

    );

    result.innerHTML = html;

});

</script>


<div class="container">

<a href="../index.php" class="btn btn-outline back">
← Back
</a>

<?php echo $html; ?>

</div>

    
</body>

</html>

