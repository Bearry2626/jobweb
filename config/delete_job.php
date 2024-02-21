<?php
session_start();
require_once '../config/db.php';

if (isset($_POST['job_post_id'])) {
    $job_post_id = $_POST['job_post_id'];

    $delete_sql = "DELETE FROM job_posts WHERE post_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);

    if ($delete_stmt) {
        $delete_stmt->bind_param("i", $job_post_id);

        if ($delete_stmt->execute()) {
            $delete_stmt->close();
            $conn->close();

            $_SESSION['success_message'] = "ลบประกาศงานเรียบร้อยแล้ว";

            // Show JavaScript alert and then redirect
            echo "<script>alert('{$_SESSION['success_message']}'); window.location.href = '../user/main.php';</script>";
            exit();
        } else {
            $_SESSION['error_message'] = "เกิดข้อผิดพลาดในการลบประกาศงาน: " . $delete_stmt->error;
        }

        $delete_stmt->close();
    } else {
        $_SESSION['error_message'] = "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
    }
} else {
    $_SESSION['error_message'] = "คำขอไม่ถูกต้อง";
}

$conn->close();

// Show JavaScript alert and then redirect in case of an error
if (isset($_SESSION['error_message'])) {
    echo "<script>alert('{$_SESSION['error_message']}'); window.location.href = '../user/main.php';</script>";
} else {
    // Show success message and then redirect
    echo "<script>alert('แก้ไขงานแล้ว'); window.location.href = '../user/main.php';</script>";
}
exit();
?>
