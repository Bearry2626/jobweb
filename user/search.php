<div class="col-sm-4">
    <div class="card collapse d-lg-block" id="collapseLarge">
        <div class="card-body">
            <h5 class="card-title">ค้นหางาน</h5>
            <form method="get">
                <!-- ส่งข้อมูลไปยังหน้า search_results.php ดังนั้นคุณต้องสร้างหน้านั้นเพื่อประมวลผลข้อมูล -->
                <div class="mb-3">
                    <label for="province" class="form-label">สถานที่ปฏิบัติงาน</label>
                    <select class="form-select" aria-label="Default select example" name="province" id="province">
                        <option value="" <?php echo addIfSelected($search_province, ""); ?>>จังหวัด</option>
                        <?php
                        $sql_province = "SELECT * FROM thai_provinces";
                        $result_province = $conn->query($sql_province);

                        if ($result_province->num_rows > 0) {
                            while ($row_province = $result_province->fetch_assoc()) {
                                echo "<option value='" . $row_province['provinces_id'] . "' " . addIfSelected($search_province, $row_province['provinces_id']) . " >" . $row_province['provinces_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3" id="amphurContainer" <?php echo hideIfNotShow($search_amphur); ?>>
                    <label for="amphur" class="form-label">อำเภอ</label>
                    <select class="form-select" aria-label="Default select example" name="amphur" id="amphur">
                        <option value="" <?php echo addIfSelected($search_amphur, ""); ?>>อำเภอ</option>
                        <?php
                        $sql_amphur = "SELECT * FROM thai_amphures";
                        $result_amphur = $conn->query($sql_amphur);

                        if ($result_amphur->num_rows > 0) {
                            while ($row_amphur = $result_amphur->fetch_assoc()) {
                                echo "<option value='" . $row_amphur['amphures_id'] . "' " . addIfSelected($search_amphur, $row_amphur['amphures_id']) . " >" . $row_amphur['amphures_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3" id="tambonContainer" <?php echo hideIfNotShow($search_tambon); ?>>
                    <label for="tambon" class="form-label">ตำบล</label>
                    <select class="form-select" aria-label="Default select example" name="tambon" id="tambon">
                        <option value="" <?php echo addIfSelected($search_tambon, ""); ?>>ตำบล</option>
                        <?php
                        $sql_district = "SELECT * FROM thai_tambons";
                        $result_district = $conn->query($sql_district);

                        if ($result_district->num_rows > 0) {
                            while ($row_district = $result_district->fetch_assoc()) {
                                echo "<option value='" . $row_district['tambon_id'] . "' " . addIfSelected($search_tambon, $row_district['tambon_id']) . " >" . $row_district['tambon_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="companyType" class="form-label">ประเภทงาน</label>
                    <select class="form-select" id="companyType" name="companyType">
                        <option value="" <?php echo addIfSelected($search_companyType, ""); ?>>กรุณาเลือกประเภทบริษัท</option>
                        <?php
                        $sql_company_type = "SELECT * FROM type";
                        $result_company_type = $conn->query($sql_company_type);

                        if ($result_company_type->num_rows > 0) {
                            while ($row_company_type = $result_company_type->fetch_assoc()) {
                                echo "<option value='" . $row_company_type['type_id'] . "' " . addIfSelected($search_companyType, $row_company_type['type_id']) . " >" . $row_company_type['type_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary custom-btn">ค้นหา</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="jobSearchOffcanvas" aria-labelledby="jobSearchOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="jobSearchOffcanvasLabel">ค้นหางาน</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">สถานที่ปฏิบัติงาน</label>
            <select class="form-select" aria-label="Default select example" name="provincet" id="provincet">
                <option selected>จังหวัด</option>
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
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">อำเภอ</label>
            <select class="form-select" aria-label="Default select example" name="amphurt" id="amphurt">
                <option selected>อำเภอ</option>
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
        <!-- ตำบล -->
        <div class="mb-3" id="tambonContainer">
            <label for="tambont" class="form-label">ตำบล</label>
            <select class="form-select" aria-label="Default select example" name="tambont" id="tambont">
                <option selected>ตำบล</option>
                <!-- ให้เพิ่ม attribute data-amphur="" เพื่อให้ใช้ในการกรองตำบลตามอำเภอที่เลือก -->
                <?php
                $sql_district = "SELECT * FROM thai_tambons";
                $result_district = $conn->query($sql_district);

                if ($result_district->num_rows > 0) {
                    while ($row_district = $result_district->fetch_assoc()) {
                        echo "<option value='" . $row_district['tambon_id'] . "' data-amphur='" . $row_district['amphures_id'] . "'>" . $row_district['tambon_name'] . "</option>";
                    }
                }
                ?>
            </select>

        </div>


        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">ประเภทงาน</label>
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
        <div class="modal-footer">
            <button type="button" class="btn btn-primary">ค้นหา</button>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    // เมื่อมีการเลือกจังหวัด
    $('#provincet').change(function() {
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
                    $('#amphurt').html(
                        "<option selected disabled>อำเภอก่อนคลิกเลือกข้อมูล</option>" +
                        data);

                    // ล้างข้อมูลที่เลือกใน dropdown ที่เกี่ยวข้อง
                    $('#tambont').html("<option selected disabled>ตำบล</option>");
                    $('.zipcodet').html("<option selected disabled>รหัสไปรษณีย์</option>");
                }
            });
        } else {
            // ถ้าไม่ได้เลือกจังหวัดให้กำหนด placeholder ใหม่
            $('#amphurt').html(amphurPlaceholder);
            $('#tambont').html(districtPlaceholder);
            $('.zipcodet').html(zipcodePlaceholder);
        }
    });

    // เมื่อมีการเลือกอำเภอ
    // เมื่อมีการเลือกอำเภอ
    $('#amphurt').change(function() {
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
                    $('#tambont').html(
                        "<option selected disabled>ตำบล</option>" +
                        data);

                    // ล้างข้อมูลที่เลือกใน dropdown รหัสไปรษณีย์
                    $('.zipcodet').html("<option selected disabled>รหัสไปรษณีย์</option>");
                }
            });
        } else {
            // ถ้าไม่ได้เลือกอำเภอให้กำหนด placeholder ใหม่
            $('#tambont').html("<option selected disabled>ตำบล</option>");
            $('.zipcodet').html("<option selected disabled>รหัสไปรษณีย์</option>");
        }
    });

    // เมื่อมีการเลือกตำบล
    $('#tambont').change(function() {
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
                    $('.zipcodet').html(
                        "<option selected disabled>รหัสไปรษณีย์ก่อนคลิกเลือกข้อมูล</option>" +
                        data);
                }
            });
        } else {
            // ถ้าไม่ได้เลือกตำบลให้กำหนด placeholder ใหม่
            $('.zipcodet').html("<option selected disabled>รหัสไปรษณีย์</option>");
        }
    });


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
                    $('#tambon').html("<option selected disabled>ตำบล</option>");
                    $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
                }
            });
        } else {
            // ถ้าไม่ได้เลือกจังหวัดให้กำหนด placeholder ใหม่
            $('#amphur').html(amphurPlaceholder);
            $('#tambon').html(districtPlaceholder);
            $('.zipcode').html(zipcodePlaceholder);
        }
    });

    // เมื่อมีการเลือกอำเภอ
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
                    $('#tambon').html(
                        "<option selected disabled>ตำบล</option>" +
                        data);

                    // ล้างข้อมูลที่เลือกใน dropdown รหัสไปรษณีย์
                    $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
                }
            });
        } else {
            // ถ้าไม่ได้เลือกอำเภอให้กำหนด placeholder ใหม่
            $('#tambon').html("<option selected disabled>ตำบล</option>");
            $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
        }
    });

    // เมื่อมีการเลือกตำบล
    $('#tambon').change(function() {
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
                    $('.zipcode').html(
                        "<option selected disabled>รหัสไปรษณีย์ก่อนคลิกเลือกข้อมูล</option>" +
                        data);
                }
            });
        } else {
            // ถ้าไม่ได้เลือกตำบลให้กำหนด placeholder ใหม่
            $('.zipcode').html("<option selected disabled>รหัสไปรษณีย์</option>");
        }
    });
</script>