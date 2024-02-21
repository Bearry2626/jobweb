<?php
require_once 'db.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['tambonId'])) {
    $tambonId = $_POST['tambonId'];

    // ใช้ prepared statement เพื่อป้องกัน SQL Injection
    $sql = "SELECT zip_code FROM thai_tambons WHERE tambon_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tambonId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['zip_code'] . "'>" . $row['zip_code'] . "</option>";
        }
    } else {
        echo "<option value=''>ไม่พบข้อมูลรหัสไปรษณีย์</option>";
    }

    $stmt->close();
} else {
    echo "<option value=''>ไม่พบข้อมูลรหัสไปรษณีย์</option>";
}

$conn->close();
?>
