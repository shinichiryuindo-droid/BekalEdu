<?php

session_start();

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'partner'
) {
    header('Location: ../login.php');
    exit;
}

require_once '../includes/config.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die('ID beasiswa tidak valid.');
}

$userId = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Ambil data beasiswa + gambar
|--------------------------------------------------------------------------
*/

$check = $conn->prepare(
    "SELECT
        id,
        image
     FROM scholarships
     WHERE id = ?
     AND partner_id = ?"
);

$check->bind_param(
    "ii",
    $id,
    $userId
);

$check->execute();

$result = $check->get_result();

if ($result->num_rows === 0) {

    die(
        'Beasiswa tidak ditemukan atau bukan milik Anda.'
    );

}

$scholarship = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Hapus gambar jika ada
|--------------------------------------------------------------------------
*/

if (
    !empty($scholarship['image'])
) {

    $imageFile =
        $_SERVER['DOCUMENT_ROOT']
        . $scholarship['image'];

    if (
        file_exists($imageFile)
    ) {

        unlink($imageFile);

    }

}

/*
|--------------------------------------------------------------------------
| Hapus data beasiswa
|--------------------------------------------------------------------------
*/

$delete = $conn->prepare(
    "DELETE FROM scholarships
     WHERE id = ?
     AND partner_id = ?"
);

$delete->bind_param(
    "ii",
    $id,
    $userId
);

$delete->execute();

/*
|--------------------------------------------------------------------------
| Kembali ke daftar
|--------------------------------------------------------------------------
*/

header(
    'Location: beasiswa.php'
);

exit;