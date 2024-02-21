<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../control/index.php';
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-underline">
    <div class="container d-flex justify-content-between">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand mx-auto" href="">
            <img src="../img/JOB.png" alt="" width="110" height="50">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['role'] == 'user'): ?>
                        <!-- เมนูสำหรับผู้ใช้ -->
                        <li class="nav-item">
                            <a class="nav-link" href="#"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../user/main.php">งานที่ประกาศทั้งหมด</a>
                        </li>
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="../user/profile.php">โปรไฟล์</a>
                            </li>
                        </ul>
                    <?php endif; ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <!-- เมนูสำหรับ Admin -->
                        <li class="nav-item">
                            <a class="nav-link"href=""></a>
                        </li>
                        

                        <li class="nav-item">
                            <a class="nav-link" href="../admin/manage.php">จัดการบริษัท</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/type.php">จัดการประเภทบริษัท</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if(isset($_SESSION['user'])): ?>
                    <!-- เมนูสำหรับผู้ใช้ทุกคน -->
                    <li class="nav-item">
                        <a class="nav-link" href="../config/logout.php">ออกจากระบบ</a>
                    </li>
                <?php else: ?>
                    <!-- เมนูสำหรับผู้ที่ยังไม่ได้เข้าสู่ระบบ -->
                    <li class="nav-item line">
                        <a class="nav-link active" aria-current="page" href="../view/login.php">เข้าสู่ระบบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">สำหรับบริษัท</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#jobSearchOffcanvas"
                aria-controls="jobSearchOffcanvas">
            <i class="bi bi-search"></i> <!-- ใช้ไอคอน search ของ Bootstrap Icons -->
        </button>
    </div>
</nav>
