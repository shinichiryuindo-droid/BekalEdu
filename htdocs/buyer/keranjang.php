<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'buyer') {
    header('Location: ../login.php');
    exit;
}

$buyerId = $_SESSION['user_id'];

if (isset($_GET['action'], $_GET['cart_id'])) {

    $cartId = (int)$_GET['cart_id'];
    $action = $_GET['action'];

    if ($action === 'delete') {

        $stmt = $conn->prepare("
            DELETE FROM cart
            WHERE id = ?
            AND buyer_id = ?
        ");

        $stmt->bind_param(
            'ii',
            $cartId,
            $buyerId
        );

        $stmt->execute();

    }

    if ($action === 'plus') {

        $stmt = $conn->prepare("
            UPDATE cart
            SET quantity = quantity + 1
            WHERE id = ?
            AND buyer_id = ?
        ");

        $stmt->bind_param(
            'ii',
            $cartId,
            $buyerId
        );

        $stmt->execute();

    }

    if ($action === 'minus') {

        $check = $conn->prepare("
            SELECT quantity
            FROM cart
            WHERE id = ?
            AND buyer_id = ?
        ");

        $check->bind_param(
            'ii',
            $cartId,
            $buyerId
        );

        $check->execute();

        $row =
            $check
            ->get_result()
            ->fetch_assoc();

        if ($row) {

            if ($row['quantity'] <= 1) {

                $delete = $conn->prepare("
                    DELETE FROM cart
                    WHERE id = ?
                    AND buyer_id = ?
                ");

                $delete->bind_param(
                    'ii',
                    $cartId,
                    $buyerId
                );

                $delete->execute();

            } else {

                $update = $conn->prepare("
                    UPDATE cart
                    SET quantity = quantity - 1
                    WHERE id = ?
                    AND buyer_id = ?
                ");

                $update->bind_param(
                    'ii',
                    $cartId,
                    $buyerId
                );

                $update->execute();

            }

        }

    }

    header('Location: keranjang.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Add Product
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $productId = intval($_POST['product_id'] ?? 0);

    if ($productId > 0) {

        $check = $conn->prepare("
            SELECT id, quantity
            FROM cart
            WHERE buyer_id = ?
            AND product_id = ?
        ");

        $check->bind_param(
            'ii',
            $buyerId,
            $productId
        );

        $check->execute();

        $existing =
            $check
            ->get_result()
            ->fetch_assoc();

        if ($existing) {

            $newQty =
                $existing['quantity'] + 1;

            $update =
                $conn->prepare("
                    UPDATE cart
                    SET quantity = ?
                    WHERE id = ?
                ");

            $update->bind_param(
                'ii',
                $newQty,
                $existing['id']
            );

            $update->execute();

        } else {

            $insert =
                $conn->prepare("
                    INSERT INTO cart
                    (
                        buyer_id,
                        product_id,
                        quantity
                    )
                    VALUES
                    (?, ?, 1)
                ");

            $insert->bind_param(
                'ii',
                $buyerId,
                $productId
            );

            $insert->execute();

        }

    }

    header('Location: keranjang.php');
    exit;
}

/*
|--------------------------------------------------------------------------
| Fetch Cart
|--------------------------------------------------------------------------
*/

$stmt =
$conn->prepare("
    SELECT
        c.*,
        p.name,
        p.price,
        p.image,
        p.stock
    FROM cart c
    JOIN products p
        ON p.id = c.product_id
    WHERE c.buyer_id = ?
");

$stmt->bind_param(
    'i',
    $buyerId
);

$stmt->execute();

$items =
$stmt->get_result();

$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include '../includes/sidebar-buyer.php'; ?>

<div id="mainContent" class="main-content">

<h1>🛒 Keranjang Saya</h1>

<?php if ($items->num_rows > 0): ?>

<div class="table-card">

<table>

<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

<?php while($item = $items->fetch_assoc()): ?>

<?php
$subtotal =
$item['price'] *
$item['quantity'];

$total += $subtotal;
?>

<tr>

<td>
<?= htmlspecialchars(
    $item['name']
) ?>
</td>

<td>
Rp <?= number_format(
    $item['price'],
    0,
    ',',
    '.'
) ?>
</td>

<td>
<?= $item['quantity'] ?>
</td>

<td>
Rp <?= number_format(
    $subtotal,
    0,
    ',',
    '.'
) ?>
</td>

    <td>

<a
href="?action=minus&cart_id=<?= $item['id'] ?>"
class="btn btn-ghost"
style="padding:6px 10px;"
>
➖
</a>

<a
href="?action=plus&cart_id=<?= $item['id'] ?>"
class="btn btn-primary"
style="padding:6px 10px;"
>
➕
</a>

<a
href="?action=delete&cart_id=<?= $item['id'] ?>"
class="btn btn-danger"
style="padding:6px 10px;"
onclick="return confirm('Hapus produk dari keranjang?')"
>
🗑️
</a>

</td>
    
</tr>

<?php endwhile; ?>

</table>

</div>

<div class="form-card" style="margin-top:20px;">

<h2>
Total:
Rp <?= number_format(
    $total,
    0,
    ',',
    '.'
) ?>
</h2>

<a
href="/buyer/checkout.php"
class="btn btn-primary"
>
Checkout
</a>

</div>

<?php else: ?>

<div class="empty-state">
    <div class="empty-icon">🛒</div>
    <h3>Keranjang kosong</h3>
    <p>Belum ada produk di keranjang.</p>
</div>

<?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

    const sidebar =
        document.getElementById('sidebar');

    const toggleBtn =
        document.getElementById('sidebarToggle');

    const content =
        document.getElementById('mainContent');

    if(!sidebar || !toggleBtn || !content){
        return;
    }

    function updateLayout(){

        if(sidebar.classList.contains('closed')){
            content.classList.add('expanded');
        }else{
            content.classList.remove('expanded');
        }

    }

    updateLayout();

    toggleBtn.addEventListener(
        'click',
        function(){
            setTimeout(
                updateLayout,
                20
            );
        }
    );

});
</script>

</body>
</html>