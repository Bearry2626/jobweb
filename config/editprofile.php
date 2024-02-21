<?php
session_start();
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
    if (isset($_POST['save_changes'])) {
        // ดึงข้อมูลที่ได้จากฟอร์ม
        $editedName = $_POST['editname'];
        $editedEmail = $_POST['editemail'];
        $editedNumber = $_POST['editnumber'];
        $editedAddress = $_POST['editaddress'];
        $editedType = $_POST['editType'];

        // ตรวจสอบการอัปโหลดรูปภาพใหม่
        if (isset($_FILES['editimg']) && $_FILES['editimg']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "../img/";
            $targetFile = $targetDir . basename($_FILES["editimg"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            $newImageName = $_SESSION['id'] . '_' . time() . '.' . $imageFileType;

            // ตรวจสอบว่าไฟล์เป็นไฟล์รูปภาพที่ถูกต้องหรือไม่
            $check = getimagesize($_FILES["editimg"]["tmp_name"]);
            if ($check !== false) {
                move_uploaded_file($_FILES["editimg"]["tmp_name"], $targetDir . $newImageName);

                // อัปเดตข้อมูลในฐานข้อมูล
                $sql = "UPDATE users SET username = '$editedName', email = '$editedEmail', number = '$editedNumber',
        address = '$editedAddress', img = '$newImageName', type_id = '$editedType' WHERE id = {$_SESSION['id']}";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['success_message'] = "บันทึกข้อมูลเรียบร้อย";
                    echo "<script>alert('{$_SESSION['success_message']}'); window.location.href = '../user/profile.php';</script>";
                    exit();
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                echo "ไม่ใช่ไฟล์รูปภาพที่ถูกต้อง";
            }
        } else {
            // กรณีไม่ได้อัปโหลดรูปภาพใหม่
            $sql = "UPDATE users SET username = '$editedName', email = '$editedEmail', number = '$editedNumber',
                    address = '$editedAddress', type_id = '$editedType' WHERE id = {$_SESSION['id']}";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['success_message'] = "บันทึกข้อมูลเรียบร้อย";
                echo "<script>alert('{$_SESSION['success_message']}'); window.location.href = '../user/profile.php';</script>";
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
}
?>
