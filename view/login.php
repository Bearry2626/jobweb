<?php
session_start();
include '../control/index.php';
include '../view/navbar.php';
require_once '../config/db.php';
?>


<div class="container col-12 col-md-3 ">
    <div class="card mt-5">
        <div class="card-body p-5">
            <h4 class="card-title text-center mb-5 mt-2">เข้าสู่ระบบสำหรับบริษัท</h4>
            <!-- ตรวจสอบเมื่อมีการส่งฟอร์ม -->
            <form action="../config/login.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" id="email" name="email" placeholder="อีเมล">
                </div>
                <div class="mb-3" >
                    <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน">
                </divclass=>
                <a href="forgot.php" class="float-end forgot-link">ลืมรหัสผ่าน</a>
                <div class="d-grid gap-2 col-6 mx-auto mt-5">
                    <button class="btn btn-primary custom-btn" name="submit" type="submit">เข้าสู่ระบบ</button>
                </div>
            </form>
            <!-- จบฟอร์ม -->

            <p class="mt-5 text-center">ยังไม่ได้เป็นสมาชิก Jobjab? </p>
            <p class=" text-center "><a class="register-link" href="register.php">สมัครสมาชิก</a></p>
        </div>
    </div>
</div>


