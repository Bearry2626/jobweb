<?php
// job_details.php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $job_post_id = $_GET['id'];

    $sql = "SELECT job_posts.*, users.img,users.username, users.email, users.number, users.img, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
    FROM job_posts
    JOIN type ON job_posts.type_id = type.type_id
    JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
    JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
    JOIN users ON job_posts.user_id = users.id
    JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id
    WHERE job_posts.post_id = ?";
 // Prepare the SQL statement
 $stmt = $conn->prepare($sql);

 // Check if prepare was successful
 if ($stmt) {
     // Bind the parameters
     $stmt->bind_param("i", $job_post_id);

     // Execute the statement
     $stmt->execute();

     // Get the result
     $result = $stmt->get_result();

     // Check if there are rows in the result
     if ($result->num_rows > 0) {
         // Fetch the data
         $row = $result->fetch_assoc();
        ?>
<div class="container col-md-8 mx-auto mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row mt-4">
                <div class="card-body ">
                    <div class="d-flex text-black">
                        <div class="flex-shrink-0">
                            <img src="<?= isset($row['img']) ? '../img/' . $row['img'] : '../img/default.png' ?>"
                                alt="Generic placeholder image" class="img-fluid"
                                style="width: 150px; border-radius: 10px;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-1"><?php echo $row['username']; ?></h3>
                            <p class="mb-2 pb-1" style="color: #2b2a2a;"><?php echo $row['type_name']; ?></p>
                            <p class="mb-2 pb-1" style="color: #2b2a2a;">
                                <a class="register-link"
                                    href="profile_p.php?id=<?php echo $row['user_id']; ?>">ดูรายละเอียดบริษัท</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-2" style="border-radius: 15px;">
                <div class="card-body ">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 py-2">ตำแหน่งงาน <?php echo $row['position']; ?></h4>
                    </div>
                    <div class="row g-0">
                        <p class="col-sm-6 col-md-12 "><i class="bi bi-shop"></i> ตำบล<?php echo $row['tambon_name']; ?>
                            อำเภอ<?php echo $row['amphures_name']; ?> จังหวัด<?php echo $row['provinces_name']; ?></p>
                        <p class="col-6 col-md-12"><i class="bi bi-coin"></i> <?php echo $row['salary_from']; ?> -
                            <?php echo $row['salary_to']; ?></p>
                        <p class="col-6 col-md-12"><i class="bi bi-people"></i></i> <?php echo $row['people']; ?></p>
                    </div>
                </div>
            </div>
            <div class="card-body mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 py-2">รายละเอียดงาน</h5>
                </div>
                <?php
                    $jobDetailsArray = explode(', ', $row['job_details']);
                    foreach ($jobDetailsArray as $index => $detail) {
                        echo "<p>" . ($index + 1) . ". $detail</p>";
                    }
                ?>
            </div>

            <div class="card-body mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 py-2">คุณสมบัติผู้สมัคร</h5>
                </div>
                <?php
                    $jobDetailsArray = explode(', ', $row['qualifications']);
                    foreach ($jobDetailsArray as $index => $detail) {
                        echo "<p>" . ($index + 1) . ". $detail</p>";
                    }
                ?>
            </div>
            <div class="card-body mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 py-2">สวัสดิการ</h5>
                </div>
                <?php
                    $jobDetailsArray = explode(', ', $row['benefits']);
                    foreach ($jobDetailsArray as $index => $detail) {
                        echo "<p>" . ($index + 1) . ". $detail</p>";
                    }
                ?>
            </div>
            <div class="card-body mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 py-2">วิธีการสมัคร</h5>
                </div>
                <p><?php echo $row['application_method']; ?></p>
            </div>

            <div class="card-body mt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0 py-2">ติดต่อ</h4>
                </div>
                <h5><?php echo $row['username']; ?></h5>
                <p>อีเมล : <?php echo $row['email']; ?></p>
                <p>เบอร์โทร : <?php echo $row['number']; ?></p>
            </div>
            <div class="">
                <div class="mb-6">
                    <label for="" class="form-label">เลือกวิธีสมัครงาน</label>
                </div>
                <div class="mt-6">
                    <a href="upfile.php" type="button" class="long btn btn-lg btn-primary custom-btn"> <i
                            class="bi bi-file-earmark-arrow-up-fill"></i> ส่งไฟล์ประวัติ</a>
                </div>
                <div class="mb-6">
                <button type="button" class="long btn btn-lg btn-primary custom-btn"> <i class="bi bi-envelope-fill"></i> ส่งอีเมล</button>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
        } else {
            echo "ไม่พบรายละเอียดงาน";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error in prepare statement: " . $conn->error;
    }
} else {
    echo "ไม่ได้ระบุ ID ของงานหรือรูปแบบ ID ไม่ถูกต้อง";
}

// Close the database connection
$conn->close();
?>

<style>
.long {
    width: 100%;
    max-width: 300px;
    margin-bottom: 10px;
    /* ระยะห่างด้านล่างของปุ่ม */
}
</style>