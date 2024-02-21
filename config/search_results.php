<?php
session_start();
// Include the database connection file
include_once("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle search form submission
    $province = isset($_POST["province"]) ? $_POST["province"] : "";
    $amphur = isset($_POST["amphur"]) ? $_POST["amphur"] : "";
    $tambon = isset($_POST["tambon"]) ? $_POST["tambon"] : "";
    $companyType = isset($_POST["companyType"]) ? $_POST["companyType"] : "";

    // Construct the SQL query
    $sql = "SELECT * FROM ports_id WHERE 1=1"; // Replace 'your_table' with your actual table name

    if ($province != "จังหวัด") {
        $sql .= " AND province = '$province'";
    }

    if ($amphur != "อำเภอ") {
        $sql .= " AND amphur = '$amphur'";
    }

    if ($tambon != "ตำบล") {
        $sql .= " AND tambon = '$tambon'";
    }

    if ($companyType != "กรุณาเลือกประเภทบริษัท") {
        $sql .= " AND companyType = '$companyType'";
    }

    // Execute the SQL query
    $result = $conn->query($sql);
}

?>
