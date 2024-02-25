<?php
include '../view/navbar.php';
include '../control/index.php';
require_once '../config/db.php';
?>

<div class="container col-12 col-md-3 ">
    <div class="card mt-5">
        <div class="card-body p-5">
            <h4 class="card-title text-center mb-5 mt-2">ลืมรหัสผ่าน?</h4>
            <form id="forgetForm" action="../config/forget.php" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="อีเมล">
                </div>
                <div id="passwordSection" style="display: none;">
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่านใหม่">
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-5">
                        <button class="btn btn-primary custom-btn" name="submit" type="submit">ยืนยันการเปลี่ยนรหัสผ่าน</button>
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-5">
                    <button id="checkNumberBtn" class="btn btn-primary custom-btn" name="submit" type="button">ยืนยันอีเมล</button>
                </div>
            </form>
            <p class="mt-5 text-center">กลับเพื่อ <a class="register-link" href="login.php">เข้าสู่ระบบ</a> JOBJAB </p>
        </div>
    </div>
</div>

<script>
   document.getElementById('checkNumberBtn').addEventListener('click', function() {
    var email = document.getElementById('email').value;
    if (email.trim() === '') {
        alert('โปรดป้อนอีเมล');
        return;
    }

    // ส่งคำขอไปยังเซิร์ฟเวอร์เพื่อตรวจสอบอีเมล
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.exists) {
                // มีอีเมลในระบบ
                document.getElementById('passwordSection').style.display = 'block';
                document.getElementById('checkNumberBtn').style.display = 'none';
            } else {
                // ไม่พบอีเมลในระบบ
                alert('ไม่พบอีเมลในระบบ');
            }
        }
    };
    xhr.open('POST', '../config/check_email.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('email=' + email);
});
</script>
