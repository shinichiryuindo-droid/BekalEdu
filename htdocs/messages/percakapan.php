<?php
session_start();
require_once '../includes/config.php';

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];
$conversationId = intval($_GET['conversation_id'] ?? 0);

// Check if conversation exists and user is part of it
$stmt = $conn->prepare("SELECT user1_id, user2_id FROM conversations WHERE id = ? AND (user1_id = ? OR user2_id = ?)");
$stmt->bind_param("iii", $conversationId, $currentUserId, $currentUserId);
$stmt->execute();
$convo = $stmt->get_result()->fetch_assoc();

if(!$convo){
    die("Percakapan tidak ditemukan atau Anda tidak memiliki akses.");
}

$otherUserId = ($convo['user1_id'] == $currentUserId) ? $convo['user2_id'] : $convo['user1_id'];

// Get other user's name
$stmt = $conn->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->bind_param("i", $otherUserId);
$stmt->execute();
$otherUser = $stmt->get_result()->fetch_assoc();

// Handle New Message
if($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])){
    $message = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO messages (conversation_id, sender_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $conversationId, $currentUserId, $message);
    $stmt->execute();
    header("Location: percakapan.php?conversation_id=$conversationId");
    exit;
}

// Fetch Messages
$stmt = $conn->prepare("SELECT * FROM messages WHERE conversation_id = ? ORDER BY created_at ASC");
$stmt->bind_param("i", $conversationId);
$stmt->execute();
$messages = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan <?php echo htmlspecialchars($otherUser['username']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
body{
    margin:0;
    background:#f5f7fb;
    font-family:Arial,sans-serif;
}

.chat-container{
    max-width:900px;
    height:85vh;
    margin:20px auto;
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
}

.chat-header{
    background:#2563eb;
    color:#fff;
    padding:18px 24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.chat-header a{
    color:#fff;
    text-decoration:none;
    font-weight:600;
}

.chat-box{
    flex:1;
    overflow-y:auto;
    padding:20px;
    display:flex;
    flex-direction:column;
    gap:12px;
    background:#f8fafc;
}

.msg{
    max-width:70%;
    padding:12px 16px;
    border-radius:16px;
    word-wrap:break-word;
    line-height:1.5;
}

.msg.me{
    align-self:flex-end;
    background:#2563eb;
    color:white;
    border-bottom-right-radius:5px;
}

.msg.them{
    align-self:flex-start;
    background:white;
    border:1px solid #e5e7eb;
    color:#111827;
    border-bottom-left-radius:5px;
}

.chat-inp{
    padding:12px;
    border-top:1px solid #e5e7eb;
    display:flex;
    gap:10px;
    background:white;
}

.chat-inp input{
    flex:1;
    height:44px;
    border:1px solid #d1d5db;
    border-radius:12px;
    padding:0 15px;
    font-size:14px;
    outline:none;
}

.chat-inp input:focus{
    border-color:#2563eb;
}

.chat-inp button{
    height:44px;
    padding:0 20px;
    border:none;
    border-radius:12px;
    background:#2563eb;
    color:white;
    cursor:pointer;
    font-weight:600;
}

.chat-inp button:hover{
    background:#1d4ed8;
}
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <div>
                <h3 style="margin: 0;"><?php echo htmlspecialchars($otherUser['username']); ?></h3>
                <small style="opacity: 0.8;"><?php echo ucfirst($otherUser['role']); ?></small>
            </div>
            <a href="index.php">✕ Tutup</a>
        </div>
        
        <div class="chat-box" id="chatBox">
            <?php while($msg = $messages->fetch_assoc()): ?>
                <div class="msg <?php echo $msg['sender_id'] == $currentUserId ? 'me' : 'them'; ?>">
                    <?php echo htmlspecialchars($msg['message']); ?>
                </div>
            <?php endwhile; ?>
        </div>

<form
    class="chat-inp"
    method="post"
    onsubmit="return validateMessage();"
>

    
    <input
        type="text"
        id="messageInput"
        name="message"
        placeholder="Tulis pesan..."
        autocomplete="off"
    >

    <button type="submit">
        Kirim
    </button>

</form>
        
    </div>
    <script>
        // Auto scroll to bottom
        const chatBox = document.getElementById('chatBox');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
    
    <script>

const chatBox =
    document.getElementById('chatBox');

chatBox.scrollTop =
    chatBox.scrollHeight;

function validateMessage(){

    const value =
        document
        .getElementById('messageInput')
        .value
        .trim();

    return value.length > 0;

}

</script>
    
</body>
</html>