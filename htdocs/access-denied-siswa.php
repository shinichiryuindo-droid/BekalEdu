<?php

session_start();

$dashboard = 'index.php';

if (isset($_SESSION['role'])) {

    switch ($_SESSION['role']) {

        case 'buyer':
            $dashboard = 'dashboard/buyer.php';
            break;

        case 'seller':
            $dashboard = 'dashboard/seller.php';
            break;

        case 'partner':
        case 'pending_partner':
            $dashboard = 'dashboard/partner.php';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Akses Ditolak</title>

<link
rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="bekal-login-wrapper">

<div class="bekal-card">

<div class="bekal-logo">
🚫
</div>

<h2>
Halaman Khusus Siswa
</h2>

<p>
Fitur beasiswa saat ini hanya dapat
diakses oleh akun siswa.
</p>

<br>

<a
href="<?php echo $dashboard; ?>"
class="hero-btn hero-primary">

Kembali ke Dashboard

</a>

</div>

</div>

</body>
</html>