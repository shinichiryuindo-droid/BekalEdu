<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == 'buyer'){
        header('Location: ../dashboard/buyer.php');
        exit;
    }
    if($_SESSION['role'] == 'seller'){
        header('Location: ../dashboard/seller.php');
        exit;
    }
    if($_SESSION['role'] == 'partner'){
        header('Location: ../dashboard/partner.php');
        exit;
    }
    if($_SESSION['role'] == 'pending_partner'){
        header('Location: ../menunggu-verifikasi.php');
        exit;
    }
}

require_once '../includes/config.php';

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rawPassword = $_POST['password'] ?? '';

    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // Fitur Baru: Bank dan Rekening
    $nama_bank = trim($_POST['nama_bank'] ?? '');
    $no_rekening = trim($_POST['no_rekening'] ?? '');

    if(
        empty($username) || empty($email) || empty($rawPassword) || 
        empty($full_name) || empty($phone) || 
        empty($address) || empty($nama_bank) || empty($no_rekening)
    ){
        $message = '<p class="bekal-error">Semua field wajib diisi.</p>';
    }
    elseif(strlen($username) < 3){
        $message = '<p class="bekal-error">Username minimal 3 karakter.</p>';
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $message = '<p class="bekal-error">Format email tidak valid.</p>';
    }
    elseif(strlen($rawPassword) < 8){
        $message = '<p class="bekal-error">Password minimal 8 karakter.</p>';
    }
    elseif(!preg_match('/^[0-9+\-\s]{8,20}$/', $phone)){
        $message = '<p class="bekal-error">Nomor WhatsApp tidak valid.</p>';
    }
    else{
        $password = password_hash($rawPassword, PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check->bind_param("ss", $username, $email);
        $check->execute();

        if($check->get_result()->num_rows > 0){
            $message = '<p class="bekal-error">Username atau email sudah digunakan.</p>';
        }
        else{
            $stmt = $conn->prepare(
                "INSERT INTO users 
                (username, email, password, role, full_name, phone, address, nama_bank, no_rekening) 
                VALUES (?, ?, ?, 'seller', ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param("ssssssss", $username, $email, $password, $full_name, $phone, $address, $nama_bank, $no_rekening);

            if($stmt->execute()){
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'seller';
                header('Location: ../dashboard/seller.php');
                exit;
            }
            else{
                $message = '<p class="bekal-error">Gagal membuat akun.<br>'.htmlspecialchars($conn->error).'</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Penjual</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/topbar.php'; ?>

<div class="bekal-login-wrapper">
    <div class="bekal-card">
        <div class="bekal-logo">📚</div>
        <h2>Daftar Sebagai Penjual</h2>
        <p>Jual buku, seragam, dan perlengkapan sekolah bekas.</p>

        <?php echo $message; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            <input type="password" name="password" placeholder="Password (minimal 8 karakter)" required>
            <input type="text" name="full_name" placeholder="Nama Lengkap" required value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">
            <input type="text" name="phone" placeholder="Nomor WhatsApp" required value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">

            <textarea name="address" placeholder="Alamat Lengkap" required style="width:100%;min-height:100px;padding:14px;border:1px solid #dbe2ea;border-radius:12px;margin-bottom:14px;font-family:inherit;resize:vertical;"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>

            <select name="nama_bank" required style="width:100%;padding:14px;border:1px solid #dbe2ea;border-radius:12px;margin-bottom:14px;font-family:inherit;">
                <option value="" disabled selected>Pilih Bank Untuk Terima Pembayaran...</option>
                <option value="BCA">BCA</option>
                <option value="Mandiri">Mandiri</option>
                <option value="BNI">BNI</option>
                <option value="BRI">BRI</option>
                <option value="BSI">BSI</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            
            <input type="text" name="no_rekening" placeholder="Nomor Rekening Anda" required value="<?php echo htmlspecialchars($_POST['no_rekening'] ?? ''); ?>">

            <button type="submit">Daftar Sebagai Penjual</button>
        </form>
    </div>
</div>

</body>
</html>