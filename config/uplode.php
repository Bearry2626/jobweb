<?php
session_start();
// Include the database connection file
include_once("../config/db.php");

// ตรวจสอบการส่งฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบและดำเนินการตามต้องการ
    $email = $_POST["email"];

    // ตรวจสอบว่าไฟล์ถูกอัพโหลดหรือไม่
    if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
        $file_name = $_FILES["resume"]["name"];
        $file_tmp = $_FILES["resume"]["tmp_name"];
        $upload_path = "uploads" . $file_name; // ตำแหน่งที่จะบันทึกไฟล์

        // ย้ายไฟล์ไปยังตำแหน่งที่ต้องการ
        move_uploaded_file($file_tmp, $upload_path);

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // เพิ่มข้อมูลลงในฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO uplode (email, file_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $file_name);

        if ($stmt->execute()) {echo "<script>alert('บันทึกข้อมูลและอัพโหลดไฟล์เรียบร้อย'); window.location.href='../user/upfile.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัพโหลดไฟล์');</script>";
    }
}
?>
