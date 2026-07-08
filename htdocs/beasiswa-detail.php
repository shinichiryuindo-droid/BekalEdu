<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once 'includes/config.php';

if(
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'buyer'
){
    header('Location: index.php?login_required=1');
    exit;
}

$id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare(
    "SELECT * FROM scholarships WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows === 0){
    die('Beasiswa tidak ditemukan.');
}

$scholarship = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>
<?php echo htmlspecialchars($scholarship['title']); ?>
- Detail
</title>

<link
rel="stylesheet"
href="assets/css/style.css">

<style>

body{
    background:#f8fafc;
    margin:0;
    font-family:'Segoe UI',Arial,sans-serif;
}

.detail-container{
    max-width:950px;
    margin:40px auto 40px 300px;
    padding:20px;
    transition:.35s ease;
}

.detail-container.expanded{
    margin-left:40px;
}

@media(max-width:992px){

    .detail-container,
    .detail-container.expanded{
        margin-left:auto;
        margin-right:auto;
    }

}

.detail-card{

    background:white;

    border-radius:24px;

    overflow:hidden;

    box-shadow:
    0 10px 30px rgba(0,0,0,.05);

    border:1px solid #e2e8f0;

}

.scholarship-image-wrap{

    background:
    linear-gradient(
        135deg,
        #2563eb,
        #1d4ed8
    );

    padding:30px;

    display:flex;
    justify-content:center;
    align-items:center;

}

.scholarship-image{

    max-width:100%;
    max-height:450px;

    border-radius:18px;

    background:white;

    box-shadow:
    0 15px 35px rgba(0,0,0,.15);

}

.scholarship-placeholder{

    width:100%;
    height:260px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:90px;
    color:white;

}

.detail-content{
    padding:40px;
}

.detail-card h1{
    margin-top:0;
    font-size:32px;
    color:#0f172a;
}

.info-grid{

    display:grid;

    grid-template-columns:
    repeat(
        auto-fit,
        minmax(200px,1fr)
    );

    gap:20px;

    margin:25px 0;

    background:#f8fafc;

    padding:20px;

    border-radius:16px;

    border:1px solid #f1f5f9;

}

.info-item b{

    display:block;

    color:#64748b;

    font-size:13px;

    text-transform:uppercase;

    margin-bottom:4px;

}

.info-item span{

    color:#1e293b;

    font-weight:600;

    font-size:16px;

}

.btn-group{

    display:flex;

    gap:12px;

    margin-top:30px;

    flex-wrap:wrap;

}

.back-btn{

    display:inline-block;

    padding:14px 24px;

    border-radius:12px;

    background:#e2e8f0;

    color:#475569;

    text-decoration:none;

    font-weight:600;

    transition:.2s;

}

.back-btn:hover{
    background:#cbd5e1;
}

.chat-btn{

    display:inline-block;

    padding:14px 24px;

    border-radius:12px;

    background:#2563eb;

    color:white;

    text-decoration:none;

    font-weight:600;

    transition:.2s;

    box-shadow:
    0 4px 12px rgba(37,99,235,.2);

}

.chat-btn:hover{
    background:#1d4ed8;
}

</style>

</head>

<body>

<?php include 'includes/sidebar-buyer.php'; ?>

<div
id="detailContainer"
class="detail-container">

<div class="detail-card">

<?php if(!empty($scholarship['image'])): ?>

<div class="scholarship-image-wrap">

<img
src="<?php echo htmlspecialchars($scholarship['image']); ?>"
alt="<?php echo htmlspecialchars($scholarship['title']); ?>"
class="scholarship-image">

</div>

<?php else: ?>

<div class="scholarship-image-wrap">

<div class="scholarship-placeholder">
🎓
</div>

</div>

<?php endif; ?>

<div class="detail-content">

<h1>
🎓
<?php echo htmlspecialchars($scholarship['title']); ?>
</h1>

<div class="info-grid">

<div class="info-item">
<b>Institusi</b>
<span>
<?php echo htmlspecialchars($scholarship['institution']); ?>
</span>
</div>

<div class="info-item">
<b>Lokasi</b>
<span>
<?php echo htmlspecialchars($scholarship['location']); ?>
</span>
</div>

<div class="info-item">
<b>Jenjang</b>
<span>
<?php echo htmlspecialchars($scholarship['level']); ?>
</span>
</div>

<div class="info-item">
<b>Batas Registrasi</b>
<span style="color:#ef4444;">
<?php echo date('d F Y', strtotime($scholarship['deadline'])); ?>
</span>
</div>

</div>

<hr
style="
border:0;
border-top:1px solid #e2e8f0;
margin:30px 0;
">

<h3>
Deskripsi & Persyaratan
</h3>

<p
style="
line-height:1.8;
color:#334155;
white-space:pre-line;
">

<?php
echo htmlspecialchars(
    $scholarship['description']
);
?>

</p>

<div class="btn-group">

<a
href="beasiswa.php"
class="back-btn">

← Kembali

</a>

<a
href="messages/cc.php?user_id=<?php echo $scholarship['partner_id']; ?>"
class="chat-btn">

💬 Chat Kontak Mitra

</a>

</div>

</div>

</div>

</div>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function(){

        const sidebar =
            document.getElementById(
                'sidebar'
            );

        const toggleBtn =
            document.getElementById(
                'sidebarToggle'
            );

        const content =
            document.getElementById(
                'detailContainer'
            );

        if(
            !sidebar ||
            !toggleBtn ||
            !content
        ){
            return;
        }

        function updateLayout(){

            if(
                sidebar.classList.contains(
                    'closed'
                )
            ){

                content.classList.add(
                    'expanded'
                );

            }else{

                content.classList.remove(
                    'expanded'
                );

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

    }
);

</script>

</body>
</html>