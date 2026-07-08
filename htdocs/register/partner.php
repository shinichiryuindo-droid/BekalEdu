<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] == 'buyer') {
        header('Location: ../dashboard/buyer.php');
        exit;
    }

    if ($_SESSION['role'] == 'seller') {
        header('Location: ../dashboard/seller.php');
        exit;
    }

    if ($_SESSION['role'] == 'partner') {
        header('Location: ../dashboard/partner.php');
        exit;
    }

    if ($_SESSION['role'] == 'pending_partner') {
        header('Location: ../menunggu-verifikasi.php');
        exit;
    }
}

require_once '../includes/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username    = trim($_POST['username'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $rawPassword = $_POST['password'] ?? '';

    $full_name    = trim($_POST['full_name'] ?? '');
    $institution = trim($_POST['institution'] ?? '');
    $website     = trim($_POST['website'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $address     = trim($_POST['address'] ?? '');

    if (
        empty($username) ||
        empty($email) ||
        empty($rawPassword) ||
        empty($full_name) ||
        empty($institution) ||
        empty($website) ||
        empty($phone) ||
        empty($address)
    ) {

        $message = '
        <p class="bekal-error">
        Semua field wajib diisi.
        </p>';

    } elseif (strlen($username) < 3) {

        $message = '
        <p class="bekal-error">
        Username minimal 3 karakter.
        </p>';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = '
        <p class="bekal-error">
        Format email tidak valid.
        </p>';

    } elseif (strlen($rawPassword) < 8) {

        $message = '
        <p class="bekal-error">
        Password minimal 8 karakter.
        </p>';

    } elseif (!filter_var($website, FILTER_VALIDATE_URL)) {

        $message = '
        <p class="bekal-error">
        Website tidak valid.
        </p>';

    } elseif (!preg_match('/^[0-9+\-\s]{8,20}$/', $phone)) {

        $message = '
        <p class="bekal-error">
        Nomor telepon tidak valid.
        </p>';

    } else {

        $password = password_hash($rawPassword, PASSWORD_DEFAULT);

        $check = $conn->prepare("
            SELECT id
            FROM users
            WHERE username = ?
               OR email = ?
        ");

        $check->bind_param(
            "ss",
            $username,
            $email
        );

        $check->execute();

        if ($check->get_result()->num_rows > 0) {

            $message = '
            <p class="bekal-error">
            Username atau email sudah digunakan.
            </p>';

        } else {

            $stmt = $conn->prepare("
                INSERT INTO users
                (
                    username,
                    email,
                    password,
                    role,
                    full_name,
                    institution,
                    website,
                    phone,
                    address
                )
                VALUES
                (?, ?, ?, 'pending_partner', ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "ssssssss",
                $username,
                $email,
                $password,
                $full_name,
                $institution,
                $website,
                $phone,
                $address
            );

            if ($stmt->execute()) {

                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'pending_partner';

                header("Location: ../menunggu-verifikasi.php");
                exit;

            } else {

                $message = '
                <p class="bekal-error">
                Gagal membuat akun.<br>'
                . htmlspecialchars($stmt->error) .
                '</p>';

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

<title>Daftar Mitra</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include '../includes/topbar.php'; ?>

<div class="bekal-login-wrapper">

    <div class="bekal-card">

        <div class="bekal-logo">
            🎓
        </div>

        <h2>Daftar Sebagai Mitra</h2>

        <p>
            Untuk universitas, lembaga pendidikan,
            dan penyedia program beasiswa.
        </p>

        <?php echo $message; ?>

        <form method="post">

            <input
                type="text"
                name="username"
                placeholder="Username"
                required
                value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">

            <input
                type="email"
                name="email"
                placeholder="Email Institusi"
                required
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

            <input
                type="password"
                name="password"
                placeholder="Password"
                required
                minlength="8">

            <input
                type="text"
                name="full_name"
                placeholder="Nama Lengkap"
                required
                value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>">

            <input
                type="text"
                name="institution"
                placeholder="Nama Universitas / Institusi"
                required
                value="<?php echo htmlspecialchars($_POST['institution'] ?? ''); ?>">

            <input
                type="url"
                name="website"
                placeholder="https://example.com"
                required
                value="<?php echo htmlspecialchars($_POST['website'] ?? ''); ?>">

            <input
                type="text"
                name="phone"
                placeholder="Nomor Telepon"
                required
                value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">

            <textarea
                name="address"
                placeholder="Alamat Institusi"
                required
                style="width:100%;min-height:100px;padding:12px;border:1px solid #ddd;border-radius:8px;margin-bottom:15px;"><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>

            <button type="submit">
                Daftar Sebagai Mitra
            </button>

        </form>

    </div>

</div>

</body>
</html>