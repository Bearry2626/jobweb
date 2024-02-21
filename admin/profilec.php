<?php
    include '../control/index.php';
    include '../view/navbar.php';
?>
<div class="container  col-md-8 py-3">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://storage.googleapis.com/techsauce-prod/ugc/uploads/2023/1/1673622208_Glassdoor_%E0%B8%9A%E0%B8%A3%E0%B8%B4%E0%B8%A9%E0%B8%B1%E0%B8%97%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%99%E0%B9%88%E0%B8%B2%E0%B8%97%E0%B8%B3%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%97%E0%B8%B5%E0%B9%88%E0%B8%AA%E0%B8%B8%E0%B8%94_.jpg"
                        alt="avatar" class="rounded img-fluid" style="width: 150px;">
                    <h5 class="my-3">John Smith</h5>
                    <p class="text-muted mb-1">Full Stack Developer</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">ชื่อบริษัท</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">Johnatan Smith</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">อีเมล</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">example@example.com</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">เบอร์โทรศัพท์</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">(098) 765-4321</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">ที่อยู่</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">Bay Area, San Francisco, CA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card   mb-3">
                <div class="card-header">
                    <h4><span class="text-primary font-italic me-1">การประกาศหางาน</span>
                    </h4>
                </div>
                <div class="card-body py-3 nav-item" name="cardp">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">ตำแหน่งงาน</h5>
                        <button type="button" class="btn btn-primary">ปุ่ม</button>
                    </div>
                    <div class="row g-0">
                        <div class="col-sm-6 col-md-6"><i class="bi bi-shop"></i> จังหวัด</div>
                        <div class="col-6 col-md-6"><i class="bi bi-coin"></i> เงินเดือน</div>
                    </div>
                </div>
               
                
            </div>
        </div>
    </div>
</div>

<style>
.card-body:hover {
    background-color: #dcdcdc;
    /* เปลี่ยนเป็นสีที่คุณต้องการ */

}
</style>