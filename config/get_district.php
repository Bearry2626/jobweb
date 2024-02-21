<?php
require_once 'db.php'; // ไฟล์เชื่อมต่อฐานข้อมูล

if (isset($_POST['amphurId'])) {
    $amphurId = $_POST['amphurId'];

    // คำสั่ง SQL เพื่อดึงข้อมูลตำบลจากฐานข้อมูล
    $sql = "SELECT * FROM thai_tambons WHERE amphures_id = $amphurId";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['tambon_id'] . "'>" . $row['tambon_name'] . "</option>";
        }
    } else {
        echo "<option value=''>ไม่มีข้อมูล</option>";
    }
} else {
    echo "<option value=''>ไม่มีข้อมูล</option>";
}

$conn->close();
?>
