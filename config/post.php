<?php
require_once 'db.php';

// Start the session
session_start();

// ตรวจสอบว่ามีการส่งข้อมูลจากฟอร์มหรือไม่
if (isset($_POST['submit'])) {
    // ดึงข้อมูลจากฟอร์ม
    $position = htmlspecialchars($_POST["position"]);
    $companyType = $_POST["companyType"];
    $province = $_POST["provinces"];
    $amphur = $_POST["amphurs"];
    $district = $_POST["districts"];
    $zipcode = $_POST["zipcodes"];
    $salaryFrom = $_POST["salaryFrom"];
    $salaryTo = $_POST["salaryTo"];
    $applicationMethods = htmlspecialchars($_POST["applicationMethods"]);
    
    // ดึงข้อมูลจาก array และแปลงเป็น string
    $jobDetailsArray = $_POST["jobDetails"];
    $qualificationsArray = $_POST["qualifications"];
    $benefitsArray = $_POST["benefits"];
    
    // Loop through each element of the array and apply htmlspecialchars
    $jobDetailsString = implode(', ', array_map('htmlspecialchars', $jobDetailsArray));
    $qualificationsString = implode(', ', array_map('htmlspecialchars', $qualificationsArray));
    $benefitsString = implode(', ', array_map('htmlspecialchars', $benefitsArray));

    $people = $_POST["people"];

    // Check if user_id is set in the session
    if (isset($_SESSION['id'])) {
        // ดึง id ของผู้ใช้จากระบบลงทะเบียนหรือล็อกอิน
        $user_id = $_SESSION['id'];

        // SQL สำหรับบันทึกข้อมูล
        $sql = "INSERT INTO job_posts (position, type_id, provinces_id, amphures_id, tambon_id, zip_code, salary_from, salary_to, job_details, qualifications, application_method, benefits, user_id, people)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // ใช้คำสั่ง prepare เพื่อเตรียม SQL statement
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssssssssssss", $position, $companyType, $province, $amphur, $district, $zipcode, $salaryFrom, $salaryTo, $jobDetailsString, $qualificationsString, $applicationMethods, $benefitsString, $user_id, $people);

            if ($stmt->execute()) {
                echo "บันทึกข้อมูลสำเร็จ";
                // ทำการเปลี่ยนเส้นทางหลังจากบันทึกข้อมูลเรียบร้อย
                header("Location: ../user/main.php");
                exit;
            } else {
                echo "Error: " . $stmt->errno . " - " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error in prepare statement";
        }
    } else {
        echo "Error: User ID not set in the session";
    }

    $conn->close();
}
?>
