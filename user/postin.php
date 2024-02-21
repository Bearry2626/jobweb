<?php
include '../control/index.php';
?>
<h4><span class="text-primary font-italic me-1  mt-5">การประกาศของคุณ</span></h4>
<hr>
<?php
// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบและมี 'role' เป็น 'user'
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    // ดึงข้อมูลงานที่ผู้ใช้ได้ประกาศจากฐานข้อมูล
    $jobQuery = "SELECT job_posts.*, users.username, users.address, users.img, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
    FROM job_posts
    JOIN type ON job_posts.type_id = type.type_id
    JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
    JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
    JOIN users ON job_posts.user_id = users.id
    JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id
    WHERE job_posts.user_id = {$_SESSION['id']}";

    $jobResult = mysqli_query($conn, $jobQuery);

    if ($jobResult) {
        // ตรวจสอบว่ามีงานที่ถูกประกาศหรือไม่
        if(mysqli_num_rows($jobResult) > 0) {
            while ($row = mysqli_fetch_assoc($jobResult)) {
?>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-3">
                            <div class="card-body py-3 nav-item" name="cardp">
                                <!-- Inside the while loop where you display user's posts -->
                                <div class="d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0"><?php echo $row['position']; ?></h5>
    <div class="d-flex">
        <a href='post.php?id=<?php echo $row['post_id']; ?>' class='btn btn-primary btn-sm me-2 custom-btn'>รายละเอียดงาน</a>
        <!-- Add Delete Button -->
        <a href='../config/delete_post.php?id=<?php echo $row['post_id']; ?>' class='btn btn-danger btn-sm'>ลบ</a>
    </div>
</div>
                                <div class="row g-0">
                                    <p>
                                        <i class="bi bi-geo-alt"></i> ที่อยู่: <?php echo $row['address']; ?> ตำบล
                                        <?php echo $row['tambon_name']; ?> อำเภอ <?php echo $row['amphures_name']; ?> จังหวัด
                                        <?php echo $row['provinces_name']; ?> <?php echo $row['zip_code']; ?>
                                    </p>
                                    <p class="col-6 col-md-6"><i class="bi bi-coin"></i> เงินเดือน: <?php echo $row['salary_from']; ?> -
                                        <?php echo $row['salary_to']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
            }
        } else {
            // ถ้าไม่มีงานที่ถูกประกาศ
?>
                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                           
                            <div class="card-body py-3 nav-item" name="cardp">
                                <p>คุณยังไม่มีการประกาศงาน</p>
                            </div>
                        </div>
                    </div>
                </div>
<?php
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
