<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once '../includes/config.php';

if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
    exit;
}

$currentUserId = $_SESSION['user_id'];
$targetUserId = intval($_GET['user_id'] ?? 0);

if($targetUserId <= 0 || $targetUserId == $currentUserId){
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
$stmt->bind_param("i", $targetUserId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    die('User tujuan tidak ditemukan.');
}

$userA = min($currentUserId, $targetUserId);
$userB = max($currentUserId, $targetUserId);

$stmt = $conn->prepare("SELECT id FROM conversations WHERE user1_id = ? AND user2_id = ?");
$stmt->bind_param("ii", $userA, $userB);
$stmt->execute();
$conversation = $stmt->get_result()->fetch_assoc();

if(!$conversation){
    $stmt = $conn->prepare("INSERT INTO conversations (user1_id, user2_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userA, $userB);
    $stmt->execute();
    $conversationId = $conn->insert_id;
} else {
    $conversationId = $conversation['id'];
}

header('Location: percakapan.php?conversation_id=' . $conversationId);
exit;