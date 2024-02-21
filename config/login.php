<?php
session_start();
require_once 'db.php';

if (isset($_POST['submit'])) {
    // รับข้อมูลจากฟอร์ม
    $email = $_POST['email']; // เปลี่ยนจาก 'number' เป็น 'email'
    $password = $_POST['password'];

    // ตรวจสอบว่ามีข้อมูลทุก field ถูกกรอกหรือไม่
    if (empty($email) || empty($password)) {
        echo "<script>alert('กรุณากรอกข้อมูลให้ครบทุกช่อง');</script>";
        echo "<script>window.location.href='../view/login.php';</script>";
        exit;
    }

    // ค้นหาข้อมูลผู้ใช้จากฐานข้อมูล
    $query = "SELECT * FROM users WHERE email = '$email'"; // เปลี่ยนจาก 'number' เป็น 'email'
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

                // ตรวจสอบรหัสผ่าน
                // ตรวจสอบรหัสผ่าน
        if ($row) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user'] = $row['email'] . " " . $row['password'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['data'] = $row ;
                if ($_SESSION['role'] == 'admin') {
                    header("Location: ../admin/manage.php");
                    exit;
                } elseif ($_SESSION['role'] == 'user') {
                    header("Location: ../user/main.php");
                    exit;
                }
            } else {
                // แจ้งเตือนถึงรหัสผ่านที่ไม่ถูกต้อง
                echo "<script>alert('User หรือ Password ไม่ถูกต้อง'); window.location.href = '../view/login.php';</script>";
                exit;
            }
        } else {
            // แจ้งเตือนถึงไม่พบผู้ใช้
            echo "<script>alert('User หรือ Password ไม่ถูกต้อง'); window.location.href = '../view/login.php';</script>";
            exit;
        }

    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการทำงานกับฐานข้อมูล'); window.location.href = '../view/login.php';</script>";
        exit;
    }
} else {
    header("Location: ../view/login.php");
   exit;
}


?>


