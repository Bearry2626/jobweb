<?php
// job_details.php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';
?>

<div class="container col-12 col-md-5">
    <div class="card-body p-5">
        <p class="card-title text-center mb-5 mt-2 fs-4">ส่งไฟล์ประวัติ</p>
        <!-- ตรวจสอบเมื่อมีการส่งฟอร์ม -->
        <form action="../config/uplode.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="email" class="form-label">อีเมลของคุณ (สำหรับให้บริษัทติดต่อ)</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="ระบุอีเมลของคุณ">
    </div>

    <div class="d-grid gap-2 col-8 mx-auto mt-2">
        <input type="file" class="form-control" id="resume" name="resume" style="display: none"
            onchange="displayFileName()">
        <!-- เพิ่มปุ่มที่จะใช้เลือกไฟล์ -->
        <button type="button" class="btn btn-outline-primary custom-btnn btn-sm"
            onclick="document.getElementById('resume').click()">เลือกไฟล์</button>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <i class="bi bi-clipboard2-fill ms-1 my-1"></i> <span id="file-name"
                class="ms-1">ไม่มีไฟล์ที่เลือก</span>
        </div>
    </div>
    <div class="d-grid gap-2 col-8 mx-auto mt-5">
        <button class="btn btn-primary custom-btn btn-sm" name="submit" type="submit">สมัครงาน</button>
    </div>
</form>

    </div>
</div>
</div>

<style>
/* เพิ่มคลาส custom-btnn สำหรับการปรับแต่งเพิ่มเติม */
.custom-btnn {
    /* สีปกติ */
    color: #FE6D43;
    background-color: transparent;
    border-color: #FE6D43;
}

/* นำเมาส์ไปโดน (hover) จะมีสีเพิ่มเติม */
.custom-btnn:hover {
    color: #fff;
    background-color: #FE6D43;
    border-color: #FE6D43;
}
</style>
<script>
    function displayFileName() {
        var fileInput = document.getElementById('resume');
        var fileNameDisplay = document.getElementById('file-name');

        if (fileInput.files.length > 0) {
            // ตรวจสอบนามสกุลไฟล์
            var allowedExtensions = /(\.png|\.jpg|\.jpeg|\.prf)$/i;
            if (!allowedExtensions.exec(fileInput.files[0].name)) {
                alert('กรุณาเลือกไฟล์ที่มีนามสกุล PNG, JPG, JPEG, PRF เท่านั้น');
                // ล้างค่า input file
                fileInput.value = '';
                // ไม่แสดงชื่อไฟล์
                fileNameDisplay.textContent = 'ไม่มีไฟล์ที่เลือก';
                return;
            }

            fileNameDisplay.textContent = 'ชื่อไฟล์: ' + fileInput.files[0].name;
        } else {
            fileNameDisplay.textContent = 'ไม่มีไฟล์ที่เลือก';
        }
    }
</script>

