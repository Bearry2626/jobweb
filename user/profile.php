<?php
session_start();
include '../control/index.php';
include('../config/db.php');
include '../view/navbar.php';

?>
<?php

$query = "SELECT * FROM users WHERE id = '" . $_SESSION['id'] . "'";
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $_SESSION['data'] = $row;
    }
}
?>

<div class="container col-md-8 py-3">
    <form method="post" action="../config/editprofile.php" enctype="multipart/form-data" id="profileForm">
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img name="editimg" id="avatarImage"
                            src="<?= isset($_SESSION['data']['img']) ? '../img/' . $_SESSION['data']['img'] : '../img/default.png' ?>"
                            class="rounded img-fluid" style="width: 250px;">
                        <input type="file" class="form-control mt-3" id="avatarInput" name="editimg"
                            style="display: none;">
                        <div id="roleContainer"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">ข้อมูลบริษัท</h5>
                            <button type="button" class="btn btn-primary btn-sm custom-btn" onclick="editProfile()">
                                แก้ไขข้อมูล
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            $sql = "SELECT users.*, type.type_name, thai_tambons.tambon_name, thai_amphures.amphures_name, thai_provinces.provinces_name FROM users 
                            JOIN type ON users.type_id = type.type_id
                            JOIN thai_tambons ON users.tambon_id = thai_tambons.tambon_id
                            JOIN thai_amphures ON users.amphures_id = thai_amphures.amphures_id
                            JOIN thai_provinces ON users.provinces_id = thai_provinces.provinces_id 
                            WHERE users.id = {$_SESSION['id']}";

                            $result = $conn->query($sql);

                            if ($result !== false) {
                                $row = $result->fetch_assoc();
                                if ($row) {
                                    echo "<p id='companyTypeLabel'>ประเภทบริษัท: {$row['type_name']}</p>";
                                    echo "<p id='companyNameLabel'>ชื่อบริษัท: {$row['username']}</p>";
                                    
                                    echo "<p id='companyEmailLabel'>อีเมล: {$row['email']}</p>";
                                    echo "<p id='companyPhoneLabel'>เบอร์โทรศัพท์: {$row['number']}</p>";
                                    echo "<p id='companyAddressLabel'>ที่อยู่: {$row['address']} ตำบล{$row['tambon_name']} อำเภอ{$row['amphures_name']} จังหวัด{$row['provinces_name']} {$row['zip_code']}</p>";

                                    // ฟอร์มแก้ไข (ที่ถูกซ่อนไว้)
                                    $sql_company_type = "SELECT * FROM type";
$result_company_type = $conn->query($sql_company_type);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if ($result_company_type->num_rows > 0) {
    // แสดง <select> ที่ถูกซ่อนไว้
    echo "<select class='form-select' name='editType' id='editCompanyType' style='display: none;'>";
    // เพิ่มตัวเลือกที่เลือกปัจจุบัน
    while ($row_company_type = $result_company_type->fetch_assoc()) {
        $selected = ($row['type_id'] == $row_company_type['type_id']) ? 'selected' : '';
        echo "<option value='{$row_company_type['type_id']}' $selected>{$row_company_type['type_name']}</option>";
    }
    echo "</select>";
}
                                    echo "<input type='text' class='form-control me-2' name='editname' id='editCompanyName' value='{$row['username']}' style='display: none;'>";
                                    echo "<input type='text' class='form-control' name='editemail' id='editCompanyEmail' value='{$row['email']}' style='display: none;'>";
                                    echo "<input type='text' class='form-control' name='editnumber' id='editCompanyPhone' value='{$row['number']}' style='display: none;'>";
                                    echo "<input type='text' class='form-control' name='editaddress' id='editCompanyAddress' value='{$row['address']}' style='display: none;'>";

                                    // ปุ่มบันทึก (ที่ถูกซ่อนไว้)
                                    echo "<button type='submit' class='btn btn-success' name='save_changes' style='display: none;' id='saveChangesButton'>บันทึก</button>";
                                } else {
                                    echo "No data found";
                                }
                            } else {
                                echo "Error: " . $conn->error;
                            }
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- ... (ส่วนที่เหลือถูกเก็บไว้) ... -->

    <script>
    function editProfile() {
        // ซ่อน label และแสดง input
        document.getElementById('companyTypeLabel').style.display = 'none';
        document.getElementById('editCompanyType').style.display = 'block';
        document.getElementById('companyNameLabel').style.display = 'none';
        document.getElementById('companyEmailLabel').style.display = 'none';
        document.getElementById('companyPhoneLabel').style.display = 'none';
        document.getElementById('companyAddressLabel').style.display = 'none';

        document.getElementById('editCompanyName').style.display = 'block';
        document.getElementById('editCompanyEmail').style.display = 'block';
        document.getElementById('editCompanyPhone').style.display = 'block';
        document.getElementById('editCompanyAddress').style.display = 'block';

        // แสดงปุ่มบันทึก
        document.getElementById('saveChangesButton').style.display = 'block';

        // แสดงปุ่มแก้ไขรูปที่ซ่อนไว้
        document.getElementById('avatarInput').style.display = 'block';

        // เปลี่ยน <p> เป็น <select>
        var roleText = document.getElementById('roleText');
        var roleSelect = document.createElement('select');
        roleSelect.className = 'form-control';
        roleSelect.id = 'editRole';
        var roles = ['Full Stack Developer', 'Frontend Developer', 'Backend Developer', 'DevOps Engineer',
            'UI/UX Designer'
        ];

        // สร้าง <option> สำหรับแต่ละตำแหน่ง
        for (var i = 0; i < roles.length; i++) {
            var option = document.createElement('option');
            option.value = roles[i];
            option.text = roles[i];

            // ตรวจสอบว่าตำแหน่งปัจจุบันตรงกับตำแหน่งในรายการหรือไม่
            if (roles[i] === roleText.innerText) {
                option.selected = true;
            }

            roleSelect.appendChild(option);
        }

        // แทรก <select> ลงในตำแหน่งที่ต้องการ
        var roleContainer = document.getElementById('roleContainer');
        roleContainer.innerHTML = '';
        roleContainer.appendChild(roleSelect);
    }

    function saveChanges() {
        // ดึงข้อมูลจาก input
        var form = document.getElementById('profileForm');
        var formData = new FormData(form);
        var editedName = document.getElementById('editCompanyName').value;
        var editedEmail = document.getElementById('editCompanyEmail').value;
        var editedPhone = document.getElementById('editCompanyPhone').value;
        var editedAddress = document.getElementById('editCompanyAddress').value;

        // แสดงข้อมูลใน label และซ่อน input
        document.getElementById('companyNameLabel').innerHTML = 'ชื่อบริษัท: ' + editedName;
        document.getElementById('companyEmailLabel').innerHTML = 'อีเมล: ' + editedEmail;
        document.getElementById('companyPhoneLabel').innerHTML = 'เบอร์โทรศัพท์: ' + editedPhone;
        document.getElementById('companyAddressLabel').innerHTML = 'ที่อยู่: ' + editedAddress;

        document.getElementById('companyNameLabel').style.display = 'block';
        document.getElementById('companyEmailLabel').style.display = 'block';
        document.getElementById('companyPhoneLabel').style.display = 'block';
        document.getElementById('companyAddressLabel').style.display = 'block';

        document.getElementById('editCompanyName').style.display = 'none';
        document.getElementById('editCompanyEmail').style.display = 'none';
        document.getElementById('editCompanyPhone').style.display = 'none';
        document.getElementById('editCompanyAddress').style.display = 'none';

        // ซ่อนปุ่มบันทึก
        document.getElementById('saveChangesButton').style.display = 'none';

        // ซ่อน <select> และ <input> ที่แสดงตำแหน่งงาน
        var roleSelect = document.getElementById('editRole');
        roleSelect.style.display = 'none';

        // ซ่อน input รูปภาพ
        document.getElementById('avatarInput').style.display = 'none';
        document.getElementById('avatarImage').style.display = 'none';

        // เรียกฟังก์ชัน editAvatar() เพื่ออัปโหลดรูปภาพใหม่
        editAvatar();

        // ส่งข้อมูลแก้ไขไปยังไฟล์ PHP ผ่าน Fetch API
        fetch('../config/editprofile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // ตรวจสอบผลลัพธ์ใน Console
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function editAvatar() {
        // เปิด input element สำหรับอัปโหลดรูปภาพ
        var avatarInput = document.getElementById('avatarInput');
        avatarInput.click();

        // เพิ่ม event listener เพื่อตรวจจับการเลือกรูปภาพ
        avatarInput.addEventListener('change', function() {
            // แสดงรูปภาพที่ถูกเลือก
            displaySelectedImage(avatarInput);
        });
    }

    function displaySelectedImage(input) {
        // ตรวจสอบว่ามีการเลือกรูปภาพหรือไม่
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                // แสดงรูปภาพที่ถูกเลือก
                document.getElementById('avatarImage').src = e.target.result;
                document.getElementById('avatarImage').style.display = 'block'; // แสดงรูปภาพ
            };

            // อ่านข้อมูลรูปภาพ
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

    <?php
    include '../user/postin.php';
    ?>

</div>