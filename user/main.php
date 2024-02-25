<?php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';
?>
<?php
// Search Condition Addon START //
$condition = [];

$search_province = "";
$search_amphur = "";
$search_tambon = "";
$search_companyType = "";

function toWhereCause($condition) {
    $where = "";
    if (count($condition) >= 1) {
        $where  = "WHERE " . $condition[0];
        for ($i = 1; $i < count($condition); $i++) {
            $where = $where . " AND " . $condition[$i];
        }
    }
    return $where;
}
function addIfSelected($a, $b) {
    return $a == $b ? "selected" : "";
}
function hideIfNotShow($a) {
    return $a == "" ? 'style="display: none;"' : "";
}
if (isset($_GET["province"]) && $_GET["province"] != "") {
    $search_province = $_GET["province"];
    array_push($condition, "job_posts.provinces_id=" . $search_province . "");
}
if (isset($_GET["amphur"]) && $_GET["amphur"] != "") {
    $search_amphur = $_GET["amphur"];
    array_push($condition, "job_posts.amphures_id=" . $search_amphur . "");
}
if (isset($_GET["tambon"]) && $_GET["tambon"] != "") {
    $search_tambon = $_GET["tambon"];
    array_push($condition, "job_posts.tambon_id=" . $search_tambon . "");
}
if (isset($_GET["companyType"]) && $_GET["companyType"] != "") {
    $search_companyType = $_GET["companyType"];
    array_push($condition, "job_posts.type_id=" . $search_companyType . "");
}
$where_condition = toWhereCause($condition);
// Search Condition Addon END //
?>
<?php
// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบและมี 'role' เป็น 'user'
if (isset($_SESSION['role']) && $_SESSION['role'] == 'user') {
    // ตรวจสอบว่าผู้ใช้มีรูปโปรไฟล์หรือไม่
    if (isset($_SESSION['data']['img']) && !empty($_SESSION['data']['img'])) {
        echo '<div class="container col-md-10 mx-auto">
                <div class="container col-md-8">
                    <div class="card mt-2 d-lg-block">
                        <div class="card-body">
                            <h3 class="card-title">ประกาศงาน</h3>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
                                <button type="button" class="btn btn-primary custom-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    ประกาศงาน
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    } else {
        echo '<div class="container col-md-10 mx-auto">
                <div class="alert alert-warning mt-2" role="alert">
                    คุณไม่มีสิทธิ์ในการประกาศงาน กรุณาเพิ่มรูปโปรไฟล์ก่อนเริ่มประกาศงาน
                </div>
            </div>';
    }
}
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ประกาศงาน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="../config/post.php">
                    <div class="mb-3">
                        <label class="form-label">ตำแหน่งงาน</label>
                        <input type="text" class="form-control" name="position" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">จำนานอัตตรา</label>
                        <input type="number" class="form-control" name="people" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ประเภทงาน</label>
                        <select class="form-select" id="companyType" name="companyType">
                            <option selected disabled>กรุณาเลือกประเภทงาน</option>
                            <?php
                            $sql_company_type = "SELECT * FROM type";
                            $result_company_type = $conn->query($sql_company_type);

                            if ($result_company_type->num_rows > 0) {
                                while ($row_company_type = $result_company_type->fetch_assoc()) {
                                    echo "<option value='" . $row_company_type['type_id'] . "'>" . $row_company_type['type_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <label for="exampleInputEmail1" class="form-label">สถานที่ปฏิบัติงาน</label>
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select" aria-label="Default select example" name="provinces" id="provinces">
                                <option selected disabled>จังหวัด</option>
                                <?php
                                $sql_province = "SELECT * FROM thai_provinces";
                                $result_province = $conn->query($sql_province);

                                if ($result_province->num_rows > 0) {
                                    while ($row_province = $result_province->fetch_assoc()) {
                                        echo "<option value='" . $row_province['provinces_id'] . "'>" . $row_province['provinces_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select" aria-label="Default select example" name="amphurs" id="amphurs">
                                <option selected disabled>อำเภอ</option>
                                <?php
                                $sql_amphur = "SELECT * FROM thai_amphures";
                                $result_amphur = $conn->query($sql_amphur);

                                if ($result_amphur->num_rows > 0) {
                                    while ($row_amphur = $result_amphur->fetch_assoc()) {
                                        echo "<option value='" . $row_amphur['amphures_id'] . "'>" . $row_amphur['amphures_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" name="districts" id="districts">
                                    <option selected disabled>ตำบล</option>
                                    <?php
                                    $sql_district = "SELECT * FROM thai_tambons";
                                    $result_district = $conn->query($sql_district);

                                    if ($result_district->num_rows > 0) {
                                        while ($row_district = $result_district->fetch_assoc()) {
                                            echo "<option value='" . $row_district['tambon_id'] . "'>" . $row_district['tambon_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <select class="form-select zipcode" aria-label="Default select example" name="zipcodes" id="zipcodes">
                                <option selected disabled>รหัสไปรษณีย์</option>
                                <?php
                                $sql_zipcode = "SELECT DISTINCT zip_code FROM thai_tambons";
                                $result_zipcode = $conn->query($sql_zipcode);

                                if ($result_zipcode->num_rows > 0) {
                                    while ($row_zipcode = $result_zipcode->fetch_assoc()) {
                                        echo "<option value='" . $row_zipcode['zip_code'] . "'>" . $row_zipcode['zip_code'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <label for="exampleInputEmail1" class="form-label">เงินเดือน</label>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="ตั้งแต่" name="salaryFrom" aria-label="First name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="ถึง" name="salaryTo" aria-label="Last name">
                        </div>
                    </div>
                    <label for="exampleInputEmail1" class="form-label">รายละเอียดงาน
                        <button type="button" class="btn btn-primary custom-btn" onclick="addJobDetail('jobDetailContainer')">+</button>
                    </label>
                    <div id="jobDetailContainer">
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <div style="flex: 0 0 auto; padding-right: 10px;">1.</div>
                            <input type="text" class="form-control" name="jobDetails[]" aria-describedby="emailHelp">
                        </div>
                    </div>

                    
<label for="exampleInputEmail1" class="form-label">คุณสมบัติ
    <button type="button" class="btn btn-primary custom-btn" onclick="addJobDetail('qualificationContainer')">+</button>
</label>
                    <div id="qualificationContainer">
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <div style="flex: 0 0 auto; padding-right: 10px;">1.</div>
                            <input type="text" class="form-control" name="qualifications[]" aria-describedby="emailHelp">
                        </div>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">สวัสดิการ
    <button type="button" class="btn btn-primary custom-btn" onclick="addJobDetail('benefitContainer')">+</button>
</label>
                    <div id="benefitContainer">
                        <div class="mb-3" style="display: flex; align-items: center;">
                            <div style="flex: 0 0 auto; padding-right: 10px;">1.</div>
                            <input type="text" class="form-control" name="benefits[]" aria-describedby="emailHelp">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">วิธีการสมัคร</label>
                        <input type="text" class="form-control" name="applicationMethods" aria-describedby="emailHelp">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary custom-btn">ประกาศงาน</button>
                    </div>

                  
                </form>

            </div>
        </div>
    </div>
</div>


<div class="container mx-auto">
    <div class="mt-5">
    <?php
        $countQuery = "SELECT COUNT(*) as total FROM job_posts $where_condition";
        $countResult = $conn->query($countQuery);

        if ($countResult !== false) {
            $countRow = $countResult->fetch_assoc();
            $totalJobs = $countRow['total'];
        } else {
            $totalJobs = 0;
        }

        echo "<h5>พบการค้นหาทั้งหมด $totalJobs รายการ</h5>";
        ?>
    </div>
    <hr>
    <div class="row">
        <?php
        require_once 'search.php'; ?>
        <!-- ส่วนโพส -->
        <div class="col-sm-8">
            <?php
            $sql = "SELECT job_posts.*, users.username, users.img, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name 
    FROM job_posts
    JOIN type ON job_posts.type_id = type.type_id
    JOIN thai_tambons ON job_posts.tambon_id = thai_tambons.tambon_id
    JOIN thai_amphures ON job_posts.amphures_id = thai_amphures.amphures_id
    JOIN users ON job_posts.user_id = users.id
    JOIN thai_provinces ON job_posts.provinces_id = thai_provinces.provinces_id 
    $where_condition
    ";

            $result = $conn->query($sql);

            if ($result !== false) {
                while ($row = $result->fetch_assoc()) {
                    // Your display logic here
            ?>
                    <div class="card mb-3 nav-item">
                        <div class="card-body d-flex align-items-center">
                            <div class="card-body ">
                                <h5 class="card-title">ตำแหน่งงาน: <?php echo $row['position']; ?></h5>
                                <p id='companyNameLabel'>ชื่อบริษัท: <?php echo $row['username']; ?></p>
                                <p id='companyAddressLabel'>ที่อยู่: ตำบล<?php echo $row['tambon_name']; ?>
                                    อำเภอ<?php echo $row['amphures_name']; ?> จังหวัด<?php echo $row['provinces_name']; ?> </p>
                                <p id='companyNameLabel'>เงินเดือน: <?php echo $row['salary_from']; ?> -
                                    <?php echo $row['salary_to']; ?></p>
                                <a href='post.php?id=<?php echo $row['post_id']; ?>' class='btn btn-primary btn-sm custom-btn'>รายละเอียดงาน</a>
                            </div>
                            <div class="ms-auto">
                                <div class="card" style="max-width: 150px;">
                                    <div class="aspect-ratio ratio-1x1">
                                        <img src="<?= isset($row['img']) ? '../img/' . $row['img'] : '../img/default.png' ?>" class="img-fluid rounded logo-image" alt="โลโก้" style="max-width: 100%; height: auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "Error in the query: " . $conn->error;
            }
            ?>
        </div>
        <!-- ส่วนโพส -->


        <?php
        require_once 'script.php';
        ?>