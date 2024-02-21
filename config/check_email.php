<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) { // เปลี่ยนจาก 'number' เป็น 'email'
        $email = $_POST['email']; // เปลี่ยนจาก 'number' เป็น 'email'
        
        // เช็คอีเมลในฐานข้อมูล
        $sql = "SELECT * FROM company WHERE email='$email'"; // เปลี่ยนจาก 'number' เป็น 'email'
        $result = mysqli_query($conn, $sql);
        $exists = mysqli_num_rows($result) > 0;

        // ส่งค่ากลับในรูปแบบ JSON
        header('Content-Type: application/json');
        echo json_encode(['exists' => $exists]);
    }
}
?>
