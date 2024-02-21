<script>
    let jobDetailCounts = {}; // เก็บลำดับเลขสำหรับแต่ละ container

    function addJobDetail(containerId) {
        let container = document.getElementById(containerId);
        let containerNumber = jobDetailCounts[containerId] || 1;
        containerNumber++;

        let newJobDetailContainer = document.createElement('div');
        newJobDetailContainer.className = 'mb-3 job-detail-container';
        newJobDetailContainer.style.display = 'flex';
        newJobDetailContainer.style.alignItems = 'center';

        let newInput = document.createElement('input');
        newInput.type = 'text';
        newInput.className = 'form-control';

        // กำหนดชื่อ input ตามเงื่อนไข
        if (containerId === 'qualificationContainer') {
            newInput.name = 'qualifications[]';
        } else if (containerId === 'benefitContainer') {
            newInput.name = 'benefits[]';
        } else if (containerId === 'jobDetailContainer') {
            newInput.name = 'jobDetails[]';
        }

        newInput.setAttribute('aria-describedby', 'emailHelp');

        let numberLabel = document.createElement('div');
        numberLabel.style.flex = '0 0 auto';
        numberLabel.style.paddingRight = '10px';
        numberLabel.innerText = containerNumber + '.';

        newJobDetailContainer.setAttribute('data-number', containerNumber);

        newJobDetailContainer.appendChild(numberLabel);
        newJobDetailContainer.appendChild(newInput);

        container.appendChild(newJobDetailContainer);

        jobDetailCounts[containerId] = containerNumber;
    }
</script>



 <script>
        function updateTambonDropdown(data) {
            let tambonDropdown = document.getElementById('tambon');
            tambonDropdown.innerHTML = '<option selected>ตำบล</option>'; // Clear previous options

            data.forEach(tambon => {
                let option = document.createElement('option');
                option.value = tambon.tambon_id;
                option.text = tambon.tambon_name;
                tambonDropdown.appendChild(option);
            });
        }

        

        document.getElementById('province').addEventListener('change', function() {
            // ตรวจสอบว่ามีการเลือกจังหวัดหรือไม่
            let selectedProvince = document.getElementById('province').value;
            let amphurContainer = document.getElementById('amphurContainer');
            let amphurDropdown = document.getElementById('amphur');


            if (selectedProvince !== 'จังหวัด') {
                // แสดง dropdown อำเภอ และเปิดให้เลือก
                amphurContainer.style.display = 'block';

                // โหลดข้อมูลอำเภอจากไฟล์ PHP
                fetch('../config/get_amphur.php?province=' + selectedProvince)
                    .then(response => response.json())
                    .then(data => {
                        // เรียกฟังก์ชันสำหรับการอัพเดท dropdown อำเภอ
                        updateAmphurDropdown(data);
                    });
            } else {
                // ปิดให้ไม่สามารถเลือก dropdown อำเภอ
                amphurContainer.style.display = 'none';
            }
        });

        // ฟังก์ชันสำหรับการอัพเดท dropdown อำเภอ
        function updateAmphurDropdown(data) {
            let amphurDropdown = document.getElementById('amphur');

            // เพิ่มตัวเลือกอำเภอใหม่ลงใน dropdown
            data.forEach(amphur => {
                let option = document.createElement('option');
                option.value = amphur.amphur_id;
                option.text = amphur.amphur_name;
                amphurDropdown.appendChild(option);
            });
        }
        document.getElementById('amphur').addEventListener('change', function() {
            let selectedAmphur = document.getElementById('amphur').value;
            let tambonContainer = document.getElementById('tambonContainer');
            let tambonDropdown = document.getElementById('tambon');


            if (selectedAmphur !== 'อำเภอ') {
                // แสดง dropdown ตำบล และเปิดให้เลือก
                tambonContainer.style.display = 'block';

                // โหลดข้อมูลตำบลจากไฟล์ PHP
                fetch('../config/get_tambon.php?amphur=' + selectedAmphur)
                    .then(response => response.json())
                    .then(data => {
                        // เรียกฟังก์ชันสำหรับการอัพเดท dropdown ตำบล
                        updateTambonDropdown(data);
                    });
            } else {
                // ปิดให้ไม่สามารถเลือก dropdown ตำบล
                tambonContainer.style.display = 'none';
            }
        });

        // ฟังก์ชันสำหรับการอัพเดท dropdown ตำบล
        function updateTambonDropdown(data) {
            let tambonDropdown = document.getElementById('tambon');

            // เพิ่มตัวเลือกตำบลใหม่ลงใน dropdown
            data.forEach(tambon => {
                let option = document.createElement('option');
                option.value = tambon.tambon_id; // ใช้ tambon.tambon_id แทน thai_tambons.tambon_id
                option.text = tambon.tambon_name; // ใช้ tambon.tambon_name แทน thai_tambons.tambon_name
                tambonDropdown.appendChild(option);
            });




        }




        $('#provinces').change(function() {
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
                        $('#amphurs').html(
                            "<option selected disabled>อำเภอก่อนคลิกเลือกข้อมูล</option>" +
                            data);

                        // ล้างข้อมูลที่เลือกใน dropdown ที่เกี่ยวข้อง
                        $('#districts').html("<option selected disabled>ตำบล</option>");
                        $('.zipcodes').html("<option selected disabled>รหัสไปรษณีย์</option>");
                    }
                });
            } else {
                // ถ้าไม่ได้เลือกจังหวัดให้กำหนด placeholder ใหม่
                $('#amphurs').html(amphurPlaceholder);
                $('#districts').html(districtPlaceholder);
                $('.zipcodes').html(zipcodePlaceholder);
            }
        });

        // เมื่อมีการเลือกอำเภอ
        $('#amphurs').change(function() {
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
                        $('#districts').html(
                            "<option selected disabled>ตำบลก่อนคลิกเลือกข้อมูล</option>" +
                            data);

                        // ล้างข้อมูลที่เลือกใน dropdown รหัสไปรษณีย์
                        $('.zipcodes').html("<option selected disabled>รหัสไปรษณีย์</option>");
                    }
                });
            } else {
                // ถ้าไม่ได้เลือกอำเภอให้กำหนด placeholder ใหม่
                $('#districts').html("<option selected disabled>ตำบล</option>");
                $('.zipcodes').html(zipcodePlaceholder);
            }
        });

        // เมื่อมีการเลือกตำบล
        $('#districts').change(function() {
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
                            "<option selected disabled>ตำบลก่อนคลิกเลือกข้อมูล</option>" +
                            data);

                    }
                });
            } else {
                // ถ้าไม่ได้เลือกตำบลให้กำหนด placeholder ใหม่
                $('.zipcode').html(zipcodePlaceholder);
            }
        });

        $('#provinces').change(function() {
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
                        $('#amphurs').html(
                            "<option selected disabled>อำเภอก่อนคลิกเลือกข้อมูล</option>" +
                            data);

                        // ล้างข้อมูลที่เลือกใน dropdown ที่เกี่ยวข้อง
                        $('#districts').html("<option selected disabled>ตำบล</option>");
                        $('.zipcodes').html("<option selected disabled>รหัสไปรษณีย์</option>");
                    }
                });
            } else {
                // ถ้าไม่ได้เลือกจังหวัดให้กำหนด placeholder ใหม่
                $('#amphurs').html(amphurPlaceholder);
                $('#districts').html(districtPlaceholder);
                $('.zipcodes').html(zipcodePlaceholder);
            }
        });

        // เมื่อมีการเลือกอำเภอ
        $('#amphurs').change(function() {
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
                        $('#districts').html(
                            "<option selected disabled>ตำบลก่อนคลิกเลือกข้อมูล</option>" +
                            data);

                        // ล้างข้อมูลที่เลือกใน dropdown รหัสไปรษณีย์
                        $('.zipcodes').html("<option selected disabled>รหัสไปรษณีย์</option>");
                    }
                });
            } else {
                // ถ้าไม่ได้เลือกอำเภอให้กำหนด placeholder ใหม่
                $('#districts').html("<option selected disabled>ตำบล</option>");
                $('.zipcodes').html(zipcodePlaceholder);
            }
        });

        
        </script>