<?php
session_start();

if (isset($_POST['submit'])) {
    include '../config/db.php';

    $name = $_POST['name'];
    $type_id = $_POST['companyType'];
    $address = $_POST['address'];
    $provinces_id = $_POST['province'];
    $amphures_id = $_POST['amphur'];
    $tambon_id = $_POST['district'];
    $zip_code = $_POST['zipcode'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // เช็ครหัสผ่าน
    if ($password !== $cpassword) {
        echo "รหัสผ่านไม่ตรงกัน";
        exit;
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, type_id, address, provinces_id, amphures_id, tambon_id, zip_code, number, email, password)
            VALUES ('$name', '$type_id', '$address', '$provinces_id', '$amphures_id', '$tambon_id', '$zip_code','$number', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo  "<script>alert('สมัครบริษัทสำเร็จ'); window.location.href = '../view/login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
