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
require_once '../includes/school_selector.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $rawPassword = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $school = trim($_POST['school'] ?? '');
$jenjang = trim($_POST['jenjang'] ?? '');
$address = trim($_POST['address'] ?? '');
    if (
    empty($username) ||
    empty($email) ||
    empty($rawPassword) ||
    empty($full_name) ||
    empty($school) ||
    empty($jenjang) ||
    empty($address)
) {

        $message =
        '<p class="bekal-error">
        Semua field wajib diisi.
        </p>';

    } elseif (strlen($username) < 3) {

        $message =
        '<p class="bekal-error">
        Username minimal 3 karakter.
        </p>';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message =
        '<p class="bekal-error">
        Format email tidak valid.
        </p>';

    } elseif (strlen($rawPassword) < 8) {

        $message =
        '<p class="bekal-error">
        Password minimal 8 karakter.
        </p>';

    } else {

        $password =
        password_hash(
            $rawPassword,
            PASSWORD_DEFAULT
        );

        $check = $conn->prepare(
            "SELECT id
             FROM users
             WHERE username = ?
             OR email = ?"
        );

        $check->bind_param(
            "ss",
            $username,
            $email
        );

        $check->execute();

        if ($check->get_result()->num_rows > 0) {

            $message =
            '<p class="bekal-error">
            Username atau email sudah digunakan.
            </p>';

        } else {

$stmt = $conn->prepare(
    "INSERT INTO users
    (
        username,
        email,
        password,
        role,
        full_name,
        school,
        jenjang,
        address
    )
    VALUES
    (?, ?, ?, 'buyer', ?, ?, ?, ?)"
);

$stmt->bind_param(
    "sssssss",
    $username,
    $email,
    $password,
    $full_name,
    $school,
    $jenjang,
    $address
);

            if ($stmt->execute()) {

                $_SESSION['user_id'] =
                    $conn->insert_id;

                $_SESSION['username'] =
                    $username;

                $_SESSION['role'] =
                    'buyer';

                header(
                    "Location: ../dashboard/buyer.php"
                );

                exit;

            } else {

                $message =
                '<p class="bekal-error">
                Gagal membuat akun.
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

<title>Daftar Siswa</title>

<link
rel="stylesheet"
href="../assets/css/style.css">

</head>

<body>

<?php include '../includes/topbar.php'; ?>

<div class="bekal-login-wrapper">

<div class="bekal-card">

<div class="bekal-logo">🎒</div>

<h2>Daftar Sebagai Siswa</h2>

<p>
Cari buku, seragam, dan perlengkapan sekolah bekas dengan harga terjangkau.
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
placeholder="Email"
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
    
<?php echo bekal_school_selector(); ?>

<textarea
name="address"
placeholder="Alamat lengkap rumah"
required><?php echo htmlspecialchars($_POST['address'] ?? ''); ?></textarea>
    
<select name="jenjang" required>
    <option value="">Pilih Jenjang</option>
    <option value="SD" <?php if(($_POST['jenjang'] ?? '') === 'SD') echo 'selected'; ?>>SD</option>
    <option value="SMP" <?php if(($_POST['jenjang'] ?? '') === 'SMP') echo 'selected'; ?>>SMP</option>
    <option value="SMA" <?php if(($_POST['jenjang'] ?? '') === 'SMA') echo 'selected'; ?>>SMA</option>
    <option value="SMK" <?php if(($_POST['jenjang'] ?? '') === 'SMK') echo 'selected'; ?>>SMK</option>
</select>
    
<button type="submit">
Daftar Sebagai Siswa
</button>

</form>

</div>

</div>

</body>
</html>