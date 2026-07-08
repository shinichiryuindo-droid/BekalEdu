<?php

session_start();

require_once 'includes/config.php';

if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

$stmt = $conn->prepare(
    "SELECT role
     FROM users
     WHERE id = ?"
);

$stmt->bind_param(
    "i",
    $_SESSION['user_id']
);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    session_destroy();
    header('Location: login.php');
    exit;
}

/*
|--------------------------------------------------
| Update session role otomatis
|--------------------------------------------------
*/

$_SESSION['role'] = $user['role'];

if($user['role'] === 'partner'){

    header('Location: index.php');
    exit;

}

if($user['role'] !== 'pending_partner'){

    header('Location: index.php');
    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Menunggu Verifikasi</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:
        radial-gradient(
            circle at top left,
            #dbeafe,
            #f8fafc 45%
        );
    font-family:Arial,sans-serif;
}

.verify-card{
    width:100%;
    max-width:650px;
    background:white;
    border-radius:24px;
    padding:45px;
    text-align:center;
    box-shadow:
        0 20px 50px rgba(0,0,0,.08);
    animation:fadeIn .5s ease;
}

.verify-icon{
    font-size:80px;
    margin-bottom:20px;
}

.verify-card h1{
    margin:0;
    margin-bottom:15px;
    color:#111827;
}

.verify-card p{
    color:#6b7280;
    line-height:1.7;
    margin-bottom:15px;
}

.verify-status{
    margin:25px 0;
    padding:16px;
    border-radius:14px;
    background:#eff6ff;
    color:#1d4ed8;
    font-weight:600;
}

.verify-btn{
    display:inline-block;
    margin-top:20px;
    padding:14px 24px;
    border-radius:12px;
    text-decoration:none;
    background:#2563eb;
    color:white;
    font-weight:600;
    transition:.25s;
}

.verify-btn:hover{
    transform:translateY(-3px);
}

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(25px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

</style>

</head>

<body>

<div class="verify-card">

<div class="verify-icon">
⏳
</div>

<h1>
Pendaftaran Berhasil
</h1>

<p>
Terima kasih telah mendaftar sebagai mitra Bekal Edu.
</p>

<div class="verify-status">
Status: Menunggu Verifikasi Admin
</div>

<p>
Tim kami akan meninjau data institusi Anda terlebih dahulu sebelum akun dapat digunakan.
</p>

<p>
Proses verifikasi biasanya memerlukan waktu 1–3 hari kerja.
</p>

<p>
Setelah disetujui, Anda dapat mengelola program beasiswa dan menjangkau siswa dari berbagai sekolah.
</p>

</div>

</body>
</html>