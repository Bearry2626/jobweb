<?php
require_once 'db.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['provinceId'])) {
    $provinceId = $_POST['provinceId'];
    
    // คำสั่ง SQL เพื่อดึงข้อมูลอำเภอจากฐานข้อมูล
    $sql = "SELECT * FROM thai_amphures WHERE province_id = $provinceId";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['amphures_id'] . "'>" . $row['amphures_name'] . "</option>";
        }
    } else {
        echo "<option value=''>ไม่มีข้อมูล</option>";
    }
} else {
    echo "<option value=''>ไม่มีข้อมูล</option>";
}

$conn->close();
?>
