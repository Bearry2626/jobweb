<?php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';
?>

<?php
// Search Condition Addon START //
$condition = [];

$search_name = "";
$search_type = "";

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
if (isset($_GET["name"]) && $_GET["name"] != "") {
    $search_name = $_GET["name"];
    array_push($condition, "users.username LIKE '%" . $search_name . "%'");
}
if (isset($_GET["type_id"]) && $_GET["type_id"] != "") {
    $search_type = $_GET["type_id"];
    array_push($condition, "users.type_id=" . $search_type . "");
}
$where_condition = toWhereCause($condition);
// Search Condition Addon END //
?>
<div class="container col-md-8 mx-auto">
    <div class="row">
        <div class="col">
            <h3 class="mt-4 ml-auto">จัดการบริษัท</h3>
        </div>
        <div class="col-auto mt-4">
            <?php
            // SQL query เพื่อดึงจำนวนบริษัททั้งหมดจากตาราง users
            $count_query = "SELECT COUNT(*) as total_companies FROM users";
            $count_result = $conn->query($count_query);

            if ($count_result !== false && $count_result->num_rows > 0) {
                $row = $count_result->fetch_assoc();
                $total_companies = $row['total_companies'];
            } else {
                $total_companies = 0;
            }

            echo "<p>จำนวนบริษัททั้งหมด: $total_companies บริษัท</p>";
            ?>
        </div>
    </div>
    <hr>
    <form id="search_form" class="row g-3" method="GET">
        <div class="col d-flex justify-content-end">
            <input type="text" name="name" class="form-control" value="<?php echo $search_name; ?>" placeholder="ค้นหา">
            <button type="submit" class="btn btn-primary ms-2 custom-btn">ค้นหา</button>
        </div>
        <div class="col-md-3">
            <select id="select_type_data" class="form-select" name="type_id" aria-label="Type selection" name="type_id">
                <option value="" <?php echo addIfSelected($search_type, ""); ?>>โปรดเลือกประเภทบริษัท</option>
                <?php
                // Fetch types from the database
                $type_sql = "SELECT * FROM type";
                $type_result = $conn->query($type_sql);

                if ($type_result !== false && $type_result->num_rows > 0) {
                    // Loop through each type and generate options
                    while ($type_row = $type_result->fetch_assoc()) {
                        $type_id = $type_row['type_id'];
                        $type_name = $type_row['type_name'];
                        echo "<option value=\"$type_id\" " . addIfSelected($search_type, $type_id) . ">$type_name</option>";
                    }
                } else {
                    // Display a default option if no types are available
                    echo "<option value=\"\">No types available</option>";
                }
                ?>
            </select>
        </div>

    </form>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ชื่อบริษัท</th>
                <th scope="col">ประเภทบริษัท</th>
                <th scope="col">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query เพื่อดึงข้อมูลบริษัทและประเภทบริษัท
            $companies_query = "SELECT users.id, users.username, type.type_name FROM users
                               JOIN type ON users.type_id = type.type_id $where_condition";
            $companies_result = $conn->query($companies_query);

            if ($companies_result !== false && $companies_result->num_rows > 0) {
                while ($company = $companies_result->fetch_assoc()) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $company['id']; ?></th>
                        <td><?php echo $company['username']; ?></td>
                        <td><?php echo $company['type_name']; ?></td>
                        <td>
                            <a class="btn btn-primary custom-btn" href="profile_c.php?id=<?php echo $company['id']; ?>">ดูรายละเอียดบริษัท</a>
                            <button type="button" class="btn btn-danger">ลบ</button>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='4'>ไม่พบข้อมูลบริษัท</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    const search_form = document.getElementById("search_form");
    const select_type_data = document.getElementById("select_type_data");
    select_type_data.onchange = (e) => {
        search_form.submit();
    }
</script>
<script>
    function viewCompany(companyId) {
        // ส่ง request ไปที่ไฟล์ที่มีข้อมูลบริษัทโดยใช้ Ajax
        $.ajax({
            url: 'view_company.php?id=' + companyId,
            method: 'GET',
            success: function(response) {
                // แสดงข้อมูลบริษัทในหน้า profile_c.php
                window.location.href = 'profile_c.php?companyData=' + encodeURIComponent(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
</script>