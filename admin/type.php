<?php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';
?>
<?php

function addIfSelected($a, $b) {
    return $a == $b ? "selected" : "";
}
$search_type_id = "";
if (isset($_GET["type_id"]) && $_GET["type_id"] != "") {
    $search_type_id = $_GET["type_id"];
}

?>
<div class="container col-md-8 mx-auto">
    <div class="row">
        <div class="col">
            <h3 class="mt-4 ml-auto">จัดการประเภท</h3>
        </div>
        <div class="col-auto mt-4">
            <?php
            // SQL query เพื่อดึงจำนวนประเภททั้งหมดจากตาราง type
            $count_query = "SELECT COUNT(*) as total_types FROM type";
            $count_result = $conn->query($count_query);

            if ($count_result !== false && $count_result->num_rows > 0) {
                $row = $count_result->fetch_assoc();
                $total_types = $row['total_types'];
            } else {
                $total_types = 0;
            }

            echo "<p>จำนวนประเภททั้งหมด: $total_types ประเภท</p>";
            ?>
        </div>
    </div>
    <hr>
    <div class="row g-3">
        <form id="search_form" class="col">
            <select id="type_id" name="type_id" class="form-select" aria-label="Default select example">
                <option value="" <?php echo addIfSelected($search_type_id, ""); ?>>เลือกประเภท</option>
                <?php
                // SQL query เพื่อดึงข้อมูลประเภทบริษัท
                $types_query = "SELECT * FROM type";
                $types_result = $conn->query($types_query);

                if ($types_result !== false && $types_result->num_rows > 0) {
                    while ($type = $types_result->fetch_assoc()) {
                        echo "<option value='{$type['type_id']}' " . addIfSelected($search_type_id, $type['type_id']) . ">{$type['type_name']}</option>";
                    }
                }
                ?>
            </select>
        </form>
        <div class="col-md-3 d-flex justify-content-end">
            <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" placeholder="เพิ่มประเภท">
            <button type="button" class="btn btn-primary ms-2 custom-btn">เพิ่ม</button>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ชื่อประเภท</th>
                <th scope="col">จำนวน/บริษัท</th>
                <th scope="col">จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query เพื่อดึงข้อมูลประเภทบริษัท
            $whereCondition = "";
            if ($search_type_id != "") {
                $whereCondition = "WHERE type_id=$search_type_id";
            }
            $types_query = "SELECT * FROM type " . $whereCondition;
            $types_result = $conn->query($types_query);

            if ($types_result !== false && $types_result->num_rows > 0) {
                $index = 1;
                while ($type = $types_result->fetch_assoc()) {
                    // SQL query เพื่อดึงจำนวน users ในแต่ละประเภท
                    $users_count_query = "SELECT COUNT(*) as total_users FROM users WHERE type_id = {$type['type_id']}";
                    $users_count_result = $conn->query($users_count_query);
                    $users_count = 0;

                    if ($users_count_result !== false && $users_count_result->num_rows > 0) {
                        $users_row = $users_count_result->fetch_assoc();
                        $users_count = $users_row['total_users'];
                    }

                    echo "<tr>";
                    echo "<th scope='row'>$index</th>";
                    echo "<td>{$type['type_name']}</td>";
                    echo "<td>$users_count</td>";
                    echo "<td><button type='button' class='btn btn-danger'>ลบ</button></td>";
                    echo "</tr>";
                    $index++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<script>
    const search_form = document.getElementById("search_form");
    const type_id = document.getElementById("type_id");
    type_id.onchange = (e) => {
        search_form.submit();
    }
</script>