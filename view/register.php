<?php
    session_start();
    include '../control/index.php';
    include '../view/navbar.php';
    require_once '../config/db.php';
?>

<div class="container col-12 col-md-3 ">
    <div class="card mt-5">
        <div class="card-body p-3">
            <h4 class="card-title text-center mb-5 mt-2">สมัครสมาชิกสำหรับบริษัท</h4>
            <form action="../config/register.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="name" name="name" placeholder="ชื่อบริษัท">
                </div>
                <div class="mb-3">
                    <label for="companyType" class="form-label">ประเภทบริษัท</label>
                    <select class="form-select" id="companyType" name="companyType">
                        <option selected>กรุณาเลือกประเภทบริษัท</option>
                        <?php
                            $sql_company_type = "SELECT * FROM type";
                            $result_company_type = $conn->query($sql_company_type);

                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                            if ($result_company_type->num_rows > 0) {
                                // วนลูปแสดงผลทุกรายการ
                                while ($row_company_type = $result_company_type->fetch_assoc()) {
                                    echo "<option value='" . $row_company_type['type_id'] . "'>" . $row_company_type['type_name'] . "</option>";
                                }
                            } else 
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <textarea name="address" id="address" class="form-control" rows="3"
                        placeholder="ที่อยู่เลขที่ ซอย"></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" name="province" id="province">
                        <option selected>จังหวัด</option>
                        <?php
                            $sql_province = "SELECT * FROM thai_provinces";
                            $result_province = $conn->query($sql_province);

                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                            if ($result_province->num_rows > 0) {
                                // วนลูปแสดงผลทุกรายการ
                                while ($row_province = $result_province->fetch_assoc()) {
                                    echo "<option value='" . $row_province['provinces_id'] . "'>" . $row_province['provinces_name'] . "</option>";
                                }
                            } else
                        ?>
                    </select>
                </div>


                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" name="amphur" id="amphur">
                        <option selected>อำเภอ</option>
                        <?php
                            $sql_amphur = "SELECT * FROM thai_amphures";
                            $result_amphur = $conn->query($sql_amphur);

                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                            if ($result_amphur->num_rows > 0) {
                                // วนลูปแสดงผลทุกรายการ
                                while ($row_amphur = $result_amphur->fetch_assoc()) {
                                    echo "<option value='" . $row_amphur['amphures_id'] . "'>" . $row_amphur['amphures_name'] . "</option>";
                                }
                            } 
                        ?>
                    </select>
                </div>


                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" name="district" id="district">
                        <option selected>ตำบล</option>
                        <?php
                            $sql_district = "SELECT * FROM thai_tambons";
                            $result_district = $conn->query($sql_district);

                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                            if ($result_district->num_rows > 0) {
                                // วนลูปแสดงผลทุกรายการ
                                while ($row_district = $result_district->fetch_assoc()) {
                                    echo "<option value='" . $row_district['tambon_id'] . "'>" . $row_district['tambon_name'] . "</option>";
                                }
                            } 
                        ?>
                    </select>
                </div>

                <div class="mb-3" id="zipcode-container">
                    <select class="form-select zipcode" aria-label="Default select example" name="zipcode" id="zipcode">
                        <option selected>รหัสไปรษณีย์</option>
                        <option selected>รหัสไปรษณีย์</option>
                        <?php
                            $sql_district = "SELECT * FROM thai_tambons";
                            $result_district = $conn->query($sql_district);

                            // ตรวจสอบว่ามีข้อมูลหรือไม่
                            if ($result_district->num_rows > 0) {
                                // วนลูปแสดงผลทุกรายการ
                                while ($row_district = $result_district->fetch_assoc()) {
                                    echo "<option value='" . $row_district['zip_code'] . "'>" . $row_district['zip_code'] . "</option>";
                                }
                            }
                        ?>
                    </select>
                </div>


                <div class="mb-3">
                    <input type="text" class="form-control" id="number" name="number" placeholder="เบอร์โทรศัพท์">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="อีเมล">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="cpassword" name="cpassword"
                        placeholder="ยืนยันรหัสผ่าน">
                </div>

                <div class="d-grid gap-2 col-6 mx-auto mt-5">
                    <button class="btn btn-primary custom-btn" name="submit" type="submit">สมัครสมาชิก</button>
                </div>
            </form>
            <p class="mt-5 text-center">เป็นสมาชิกอยู่แล้ว? <a class="register-link" href="login.php">เข้าสู่ระบบ</a></p>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
// เมื่อมีการเลือกจังหวัด
$('#province').change(function() {
    // ตรวจสอบว่าถูกเลือกหรือไม่
    if ($(this).val() != 'จังหวัด') {
        // ใช้ AJAX เพื่อดึงข้อมูลอำเภอ
        $.ajax({
            type: 'POST',
            url: '../config/get_amphur.php',
            data: {
                provinceId: $(this).val()
            },
            success: function(data) {
                // แสดงข้อมูลอำเภอ
                $('#amphur').html(
                    "<option selected disabled>อำเภอก่อนคลิกเลือกข้อมูล</option>" +
                    data);

                // ล้างข้อมูลที่เลือกใน dropdown ที่เกี่ยวข้อง
                $('#district').html("<option selected disabled>ตำบล</option>");
                $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
            }
        });
    } else {
        // ถ้าไม่ได้เลือกจังหวัดให้กำหนด placeholder ใหม่
        $('#amphur').html(amphurPlaceholder);
        $('#district').html(districtPlaceholder);
        $('.zipcode').html(zipcodePlaceholder);
    }
});

// เมื่อมีการเลือกอำเภอ
$('#amphur').change(function() {
    // ตรวจสอบว่าถูกเลือกหรือไม่
    if ($(this).val() != 'อำเภอ') {
        // ใช้ AJAX เพื่อดึงข้อมูลตำบล
        $.ajax({
            type: 'POST',
            url: '../config/get_district.php',
            data: {
                amphurId: $(this).val()
            },
            success: function(data) {
                // แสดงข้อมูลตำบล
                $('#district').html(
                    "<option selected disabled>ตำบลก่อนคลิกเลือกข้อมูล</option>" +
                    data);

                // ล้างข้อมูลที่เลือกใน dropdown รหัสไปรษณีย์
                $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
            }
        });
    } else {
        // ถ้าไม่ได้เลือกอำเภอให้กำหนด placeholder ใหม่
        $('#district').html("<option selected disabled>ตำบล</option>");
        $('.zipcode').html(zipcodePlaceholder);
    }
});

// เมื่อมีการเลือกตำบล
$('#district').change(function() {
    // ตรวจสอบว่าถูกเลือกหรือไม่
    if ($(this).val() != 'ตำบล') {
        // ใช้ AJAX เพื่อดึงข้อมูลรหัสไปรษณีย์
        $.ajax({
            type: 'POST',
            url: '../config/get_zipcode.php',
            data: {
                tambonId: $(this).val()
            },
            success: function(data) {
                // แสดงข้อมูลรหัสไปรษณีย์
                $('.zipcode').html("<option selected disabled>ตำบลก่อนคลิกเลือกข้อมูล</option>" +
                    data);

            }
        });
    } else {
        // ถ้าไม่ได้เลือกตำบลให้กำหนด placeholder ใหม่
        $('.zipcode').html(zipcodePlaceholder);
    }
});
</script>