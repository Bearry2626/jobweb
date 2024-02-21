<?php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';

// Check if user ID is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch user data
    $user_sql = "SELECT users.*, type.type_name 
                 FROM users
                 JOIN type ON users.type_id = type.type_id
                 WHERE users.id = ?";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();

    // Check if user data is retrieved successfully
    if ($user_result !== false) {
        $user_row = $user_result->fetch_assoc();

        // Display user information
        ?>
        <div class="container col-md-8 mx-auto mt-2">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="card-body">
                            <div class="d-flex text-black">
                                <div class="flex-shrink-0">
                                    <img src="<?= isset($user_row['img']) ? '../img/' . $user_row['img'] : '../img/default.png' ?>"
                                        alt="Generic placeholder image" class="img-fluid"
                                        style="width: 150px; border-radius: 10px;">
                                </div>
                                <div class="flex-grow-1 ms-3 mt-1">
                                    <h3 class="mb-1"><?php echo $user_row['username']; ?></h3>
                                    <p class="mb-2 pb-1" style="color: #2b2a2a;"><?php echo $user_row['type_name']; ?></p>
                                    <!-- Add other user details here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="mt-3">งานที่ประกาศ</h4>

                    <?php
                    // Fetch job posts for the user
                    $job_sql = "SELECT job_posts.*, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
                                FROM job_posts
                                JOIN type ON job_posts.type_id = type.type_id
                                JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
                                JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
                                JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id
                                WHERE job_posts.user_id = ?";
                    $job_stmt = $conn->prepare($job_sql);
                    $job_stmt->bind_param("i", $user_id);
                    $job_stmt->execute();
                    $job_result = $job_stmt->get_result();

                    // Check if job posts are retrieved successfully
                    if ($job_result !== false && $job_result->num_rows > 0) {
                        while ($job_row = $job_result->fetch_assoc()) {
                            ?>
                            <div class="card mt-2" style="border-radius: 15px;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0 py-2">ตำแหน่งงาน <?php echo $job_row['position']; ?></h4>
                                    </div>
                                    <div class="row g-0">
                                        <p class="col-sm-6 col-md-12"><i class="bi bi-shop"></i> ตำบล<?php echo $job_row['tambon_name']; ?>
                                            อำเภอ<?php echo $job_row['amphures_name']; ?> จังหวัด<?php echo $job_row['provinces_name']; ?></p>
                                        <p class="col-6 col-md-12"><i class="bi bi-coin"></i> <?php echo $job_row['salary_from']; ?> -
                                            <?php echo $job_row['salary_to']; ?></p>
                                        <p class="col-6 col-md-12"><i class="bi bi-people"></i> <?php echo $job_row['people']; ?></p>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="post.php?id=<?php echo $job_row['post_id']; ?>" class="btn btn-primary" type="button">ดูรายละเอียด</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Display a message if no job posts are available
                        echo '<p>ไม่มีงานที่ประกาศ</p>';
                    }

                    // Close the job posts prepared statement
                    $job_stmt->close();
                    ?>

                </div>
            </div>
        </div>
        <?php
    } else {
        echo "Error fetching user data: " . $user_stmt->error;
    }

    // Close the user prepared statement
    $user_stmt->close();
} else {
    echo "ไม่ได้ระบุ ID ของผู้ใช้";
}

// Close the database connection
$conn->close();
?>
