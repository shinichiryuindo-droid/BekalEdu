<?php
session_start();
require_once '../includes/config.php';

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];

$stmt = $conn->prepare(
    "SELECT 
        c.id,
        u.id AS other_user_id,
        u.username,
        u.role,
        (SELECT m.message FROM messages m WHERE m.conversation_id = c.id ORDER BY m.created_at DESC LIMIT 1) AS last_message,
        (SELECT m.created_at FROM messages m WHERE m.conversation_id = c.id ORDER BY m.created_at DESC LIMIT 1) AS last_time
     FROM conversations c
     JOIN users u ON u.id = CASE WHEN c.user1_id = ? THEN c.user2_id ELSE c.user1_id END
     WHERE c.user1_id = ? OR c.user2_id = ?
     ORDER BY last_time DESC, c.id DESC"
);
$stmt->bind_param("iii", $currentUserId, $currentUserId, $currentUserId);
$stmt->execute();
$conversations = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - Bekal Edu</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            background: #f1f5f9;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .chatlist-container{

    max-width:900px;

    margin:40px auto 40px 300px;

    padding:20px;

    transition:.35s ease;

}

.chatlist-container.expanded{

    margin-left:40px;

}

@media(max-width:992px){

    .chatlist-container,
    .chatlist-container.expanded{

        margin-left:auto;
        margin-right:auto;

    }

}
        .chatlist-header h1 { margin: 0; font-size: 28px; color: #0f172a; }
        .chatlist-header p { color: #64748b; margin-top: 5px; }
        .chat-card {
            display: flex;
            flex-direction: column;
            background: white;
            text-decoration: none;
            color: #1e293b;
            padding: 20px;
            margin-bottom: 12px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,.02);
            transition: all 0.2s ease;
            border: 1px solid #e2e8f0;
        }
        .chat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,.05);
            border-color: #cbd5e1;
        }
        .chat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        .chat-name { font-weight: 700; font-size: 16px; }
        .chat-role {
            font-size: 12px;
            color: #2563eb;
            background: #eff6ff;
            padding: 2px 8px;
            border-radius: 20px;
            display: inline-block;
            margin-left: 8px;
        }
        .chat-preview {
            color: #64748b;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .empty-chat {
            background: white;
            padding: 50px;
            border-radius: 25px;
            text-align: center;
            color: #64748b;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <?php
    if($_SESSION['role'] == 'buyer') include '../includes/sidebar-buyer.php';
    elseif($_SESSION['role'] == 'seller') include '../includes/sidebar-seller.php';
    elseif(in_array($_SESSION['role'], ['partner', 'pending_partner'])) include '../includes/sidebar-partner.php';
    ?>

    <div id="mainContent" class="chatlist-container">
        <div class="chatlist-header">
            <h1>💬 Percakapan</h1>
            <p>Kelola semua pesan masuk dan keluar Anda di platform.</p>
        </div>
        <br>
        <?php if($conversations->num_rows > 0): ?>
            <?php while($chat = $conversations->fetch_assoc()): ?>
                <a href="percakapan.php?conversation_id=<?php echo $chat['id']; ?>" class="chat-card">
                    <div class="chat-top">
                        <div style="display: flex; align-items: center;">
                            <span class="chat-name"><?php echo htmlspecialchars($chat['username']); ?></span>
                            <span class="chat-role">
                                <?php
                                if($chat['role'] == 'buyer') echo '🎒 Siswa';
                                elseif($chat['role'] == 'seller') echo '📚 Penjual';
                                elseif($chat['role'] == 'partner') echo '🎓 Mitra';
                                else echo '⏳ Pending';
                                ?>
                            </span>
                        </div>
                        <div style="font-size: 12px; color: #94a3b8;">
                            <?php echo !empty($chat['last_time']) ? date('d M H:i', strtotime($chat['last_time'])) : ''; ?>
                        </div>
                    </div>
                    <div class="chat-preview">
                        <?php echo htmlspecialchars($chat['last_message'] ?? 'Belum ada pesan.'); ?>
                    </div>
                </a>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-chat">
                <div style="font-size: 40px;">📭</div>
                <h3>Belum ada percakapan</h3>
                <p>Mulai percakapan Anda melalui detail produk marketplace atau detail program beasiswa.</p>
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

            setTimeout(updateLayout, 20);

        }
    );

});

</script>
</body>
</html>