<head>
    <title>Bekal Edu</title>
    <link rel="icon" href="../assets/favicon.jpg" type="image/jpg">
</head>

<?php

$conn = new mysqli(
    'sql300.infinityfree.com',
    'if0_42235879',
    'bekaledu',
    'if0_42235879_bekaledu'
);

if ($conn->connect_error) {
    die('Database connection failed');
}

if(session_status() === PHP_SESSION_NONE){
    session_start();
}