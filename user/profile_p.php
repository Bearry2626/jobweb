<?php
// job_details.php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT job_posts.*, users.address,users.img,users.username, users.email, users.number, users.img, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
            FROM job_posts
            JOIN type ON job_posts.type_id = type.type_id
            JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
            JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
            JOIN users ON job_posts.user_id = users.id
            JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id
            WHERE job_posts.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="container col-md-8 mx-auto mt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="card-body ">
                                <div class="d-flex text-black">
                                    <div class="flex-shrink-0">
                                        <img src="<?= isset($row['img']) ? '../img/' . $row['img'] : '../img/default.png' ?>"
                                            alt="Generic placeholder image" class="img-fluid"
                                            style="width: 150px; border-radius: 10px;">
                                    </div>
                                    <div class="flex-grow-1 ms-3 mt-1">
                                        <h3 class="mb-1"><?php echo $row['username']; ?></h3>
                                        <p class="mb-2 pb-1" style="color: #2b2a2a;"><?php echo $row['type_name']; ?></p>
                                        <p class="mb-2 pb-1" style="color: #2b2a2a;">ที่อยู่ </i> <?php echo $row['address']; ?> ตำบล<?php echo $row['tambon_name']; ?>
                                        อำเภอ<?php echo $row['amphures_name']; ?> จังหวัด<?php echo $row['provinces_name']; ?> </p>
                                        <p class="mb-2 pb-1" style="color: #2b2a2a;">เบอร์โทรศัพท์ <?php echo $row['number']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="mt-3">งานที่ประกาศ</h4>
                        <?php


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT job_posts.*, users.address,users.img,users.username, users.email, users.number, users.img, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
            FROM job_posts
            JOIN type ON job_posts.type_id = type.type_id
            JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
            JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
            JOIN users ON job_posts.user_id = users.id
            JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id
            WHERE job_posts.user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== false) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="card mt-2" style="border-radius: 15px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 py-2">ตำแหน่งงาน <?php echo $row['position']; ?></h4>
                    </div>
                    <div class="row g-0">
                        <p class="col-sm-6 col-md-12 "><i class="bi bi-shop"></i> ตำบล<?php echo $row['tambon_name']; ?>
                            อำเภอ<?php echo $row['amphures_name']; ?> จังหวัด<?php echo $row['provinces_name']; ?></p>
                        <p class="col-6 col-md-12"><i class="bi bi-coin"></i> <?php echo $row['salary_from']; ?> -
                            <?php echo $row['salary_to']; ?></p>
                        <p class="col-6 col-md-12"><i class="bi bi-people"></i> <?php echo $row['people']; ?></p>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="post.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary custom-btn" type="button">ดูรายละเอียด</a>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo "ไม่ได้ระบุ ID ของผู้ใช้";
}

// Close the database connection
$conn->close();
?>

                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    
} else {
    echo "ไม่ได้ระบุ ID ของผู้ใช้";
}

?>
