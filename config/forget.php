<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && isset($_POST['password'])) { // เปลี่ยนจาก 'number' เป็น 'email'
        $email = $_POST['email']; // เปลี่ยนจาก 'number' เป็น 'email'
        $password = $_POST['password'];
        
        // เช็คอีเมลในฐานข้อมูล
        $sql = "SELECT * FROM company WHERE email='$email'"; // เปลี่ยนจาก 'number' เป็น 'email'
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // มีอีเมลในระบบ
            // อัปเดตรหัสผ่านใหม่ในฐานข้อมูล
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateSql = "UPDATE company SET password='$hashedPassword' WHERE email='$email'"; // เปลี่ยนจาก 'number' เป็น 'email'
            if (mysqli_query($conn, $updateSql)) {
                echo "<script>alert('รหัสผ่านถูกอัปเดตแล้ว');</script>";
                echo "<script>window.location.href='../view/login.php';</script>";
                exit;
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตรหัสผ่านใหม่');</script>";
            }
        } else {
            // ไม่พบอีเมลในระบบ
            echo "<script>alert('ไม่พบอีเมลในระบบ');</script>";
            echo "<script>window.location.href='../view/forgot.php';</script>";
            exit;
        }
        mysqli_close($conn);
    }
}
?>
