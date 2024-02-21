<?php
require_once 'db.php';
    session_start();
    session_destroy();
    header("Location: ../view/login.php");
    exit;  // เพิ่มบรรทัดนี้เพื่อหยุดการทำงานทันที
?>
