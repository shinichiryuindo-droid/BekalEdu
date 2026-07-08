<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['user_id'])){

    if($_SESSION['role'] == 'buyer'){
        header('Location: dashboard/buyer.php');
        exit;
    }

    if($_SESSION['role'] == 'seller'){
        header('Location: dashboard/seller.php');
        exit;
    }

    if($_SESSION['role'] == 'partner'){
        header('Location: dashboard/partner.php');
        exit;
    }

    if($_SESSION['role'] == 'pending_partner'){
        header('Location: menunggu-verifikasi.php');
        exit;
    }

}

require_once 'includes/config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        empty($username) ||
        empty($password)
    ) {

        $message =
        '<p class="bekal-error">
        Username dan password wajib diisi.
        </p>';

    } else {

        $stmt = $conn->prepare(
            "SELECT *
             FROM users
             WHERE username = ?
             OR email = ?"
        );

        $stmt->bind_param(
            "ss",
            $username,
            $username
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 0) {

            $message =
            '<p class="bekal-error">
            Username atau password salah.
            </p>';

        } else {

            $user = $result->fetch_assoc();

            if (
                password_verify(
                    $password,
                    $user['password']
                )
            ) {

                $_SESSION['user_id'] =
                    $user['id'];

                $_SESSION['username'] =
                    $user['username'];

                $_SESSION['role'] =
                    $user['role'];

                if (
                    $user['role'] ===
                    'pending_partner'
                ) {

                    header(
                        'Location: menunggu-verifikasi.php'
                    );
                    exit;
                }

                if (
                    $user['role'] ===
                    'buyer'
                ) {

                    header(
                        'Location: dashboard/buyer.php'
                    );
                    exit;
                }

                if (
                    $user['role'] ===
                    'seller'
                ) {

                    header(
                        'Location: dashboard/seller.php'
                    );
                    exit;
                }

                if (
                    $user['role'] ===
                    'partner'
                ) {

                    header(
                        'Location: dashboard/partner.php'
                    );
                    exit;
                }

                $message =
                '<p class="bekal-error">
                Role tidak dikenali.
                </p>';

            } else {

                $message =
                '<p class="bekal-error">
                Username atau password salah.
                </p>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Login</title>

<link
rel="stylesheet"
href="assets/css/style.css">
<?php include 'includes/topbar.php'; ?>

</head>

<body>

<div class="bekal-login-wrapper">

<div class="bekal-card">

<div class="bekal-logo">
🔐
</div>

<h2>
Login Bekal Edu
</h2>

<p>
Masuk ke akun Anda.
</p>

<?php echo $message; ?>

<?php if(isset($_GET['registered'])): ?>

<p class="bekal-success">
Pendaftaran berhasil. Silakan login.
</p>

<?php endif; ?>

<form method="post">

<input
type="text"
name="username"
placeholder="Username atau Email"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">
Masuk
</button>

</form>

<p style="margin-top:20px;">

Belum punya akun?

<a href="register/index.php">
Daftar
</a>

</p>

</div>

</div>

</body>
</html>