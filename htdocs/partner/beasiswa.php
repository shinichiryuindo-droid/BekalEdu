<?php
session_start();
require_once '../includes/config.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'partner'){
    header('Location: ../index.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM scholarships WHERE partner_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$scholarships = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Beasiswa - Mitra</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { margin: 0; background: #f8fafc; font-family: 'Segoe UI', Arial, sans-serif; }
        .page-container{

    max-width:1200px;

    margin:40px auto 40px 300px;

    padding:20px;

    transition:.35s ease;

}

.page-container.expanded{

    margin-left:90px;

}

@media(max-width:992px){

    .page-container,
    .page-container.expanded{

        margin-left:auto;
        margin-right:auto;

    }

}
        @media(max-width: 992px) { .page-container { margin-left: auto; margin-right: auto; } }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .page-header h1 { margin: 0; font-size: 26px; }
        .add-btn { background: #2563eb; color: white; text-decoration: none; padding: 12px 20px; border-radius: 12px; font-weight: 600; transition: 0.2s; box-shadow: 0 4px 12px rgba(37,99,235,0.2); }
        .add-btn:hover { background: #1d4ed8; transform: translateY(-1px); }
        .table-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.03); border: 1px solid #e2e8f0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 18px; text-align: left; border-bottom: 1px solid #f1f5f9; font-size: 15px; }
        th { background: #f8fafc; color: #64748b; font-weight: 600; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #e2e8f0; color: #475569; }
        .action-btn { text-decoration: none; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 600; transition: 0.2s; display: inline-block; }
        .edit-btn { background: #dbeafe; color: #1e40af; margin-right: 5px; }
        .edit-btn:hover { background: #bfdbfe; }
        .delete-btn { background: #fee2e2; color: #991b1b; }
        .delete-btn:hover { background: #fecaca; }
        .empty { padding: 60px; text-align: center; color: #64748b; }
    </style>
</head>
<body>
    <?php include '../includes/sidebar-partner.php'; ?>
    <div id="mainContent" class="page-container">
        <div class="page-header">
            <h1>🎓 Kelola Beasiswa</h1>
            <a href="tambah-beasiswa.php" class="add-btn">➕ Tambah Beasiswa</a>
        </div>
        <div class="table-card">
            <?php if($scholarships->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Judul Beasiswa</th>
                            <th>Lokasi</th>
                            <th>Jenjang</th>
                            <th>Batas Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $scholarships->fetch_assoc()): ?>
                            <tr>
                                <td style="font-weight: 600; color: #0f172a;"><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><span class="badge"><?php echo htmlspecialchars($row['level']); ?></span></td>
                                <td style="color: #ef4444; font-weight: 500;"><?php echo date('d M Y', strtotime($row['deadline'])); ?></td>
                                <td>
                                    <a class="action-btn edit-btn" href="edit-beasiswa.php?id=<?php echo $row['id']; ?>">✏️ Edit</a>
                                    <a class="action-btn delete-btn" href="hapus-beasiswa.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus beasiswa ini?')">🗑️ Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">
                    <div style="font-size: 40px;">📭</div>
                    <h3>Belum ada program beasiswa</h3>
                    <p>Mulai publikasikan program beasiswa pertama instansi Anda dengan menekan tombol Tambah Beasiswa.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>

document.addEventListener('DOMContentLoaded', function(){

    const sidebar =
        document.getElementById('sidebar');

    const toggleBtn =
        document.getElementById('sidebarToggle');

    const mainContent =
        document.getElementById('mainContent');

    if(!sidebar || !toggleBtn || !mainContent){
        return;
    }

    function updateLayout(){

        if(sidebar.classList.contains('closed')){

            mainContent.classList.add(
                'expanded'
            );

        }else{

            mainContent.classList.remove(
                'expanded'
            );

        }

    }

    updateLayout();

    toggleBtn.addEventListener(
        'click',
        function(){

            setTimeout(updateLayout, 10);

        }
    );

});

</script>
    
</body>
</html>