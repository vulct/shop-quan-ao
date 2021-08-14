<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Chỉnh Sửa Thông Tin Khách Hàng
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=customer">Quản Lý Khách Hàng</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa TT Khách Hàng</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Validation -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Chỉnh Sửa </strong>Thông Tin Khách Hàng</h2>
                        <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <?php if ($dataViews['customer']){?>
                    <div class="body">
                        <form id="form_edit_customer" method="POST" onsubmit="return false">
                            <div class="row clearfix">
                                <input type="hidden" name="uID" value="<?= $dataViews['customer']['uID'] ?>">
                                <div class="col-sm-6">
                                    <label for="first_name"><b>Tên <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="first_name" name="first_name" class="form-control"
                                               placeholder="Tên" value="<?= $dataViews['customer']['uFirstName'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="last_name"><b>Họ <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="last_name" name="last_name" class="form-control"
                                               placeholder="Họ" value="<?= $dataViews['customer']['uLastName'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label for="email"><b>Email <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="email" class="form-control" placeholder="Email"
                                               value="<?= $dataViews['customer']['uEmail'] ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="mobile"><b>Số Điện Thoại <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="mobile" name="mobile" class="form-control"
                                               placeholder="Số điện thoại"
                                               value="<?= $dataViews['customer']['uMobile'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <label for="province"><b>Tỉnh/Thành Phố <span
                                                    class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <select id="province" name="province" class="form-control" required>
                                            <option value="">Chọn Tỉnh/Thành Phố</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="district"><b>Quận/Huyện <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <select id="district" name="district" class="form-control" required>
                                            <option selected>Chọn Quận/Huyện</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="wards"><b>Phường/Xã <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <select id="wards" name="wards" class="form-control" required>
                                            <option selected>Chọn Phường/Xã</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label for="address"><b>Địa Chỉ <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="address" name="address" class="form-control"
                                               placeholder="Địa chỉ" value="<?= $dataViews['customer']['uAddress'] ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row clearfix">
                                <div class="col-sm-4">
                                    <label for="RegisteredAt"><b>Thời Gian Tạo Tài Khoản</b></label>
                                    <div class="form-group">
                                        <input type="text" id="RegisteredAt" class="form-control" placeholder="Disabled"
                                               value="<?= $dataViews['customer']['uRegisteredAt'] ?>" disabled="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="LastLogin"><b>Thời Gian Đăng Nhập Gần Nhất</b></label>
                                    <div class="form-group">
                                        <input type="text" id="LastLogin" class="form-control" placeholder="Disabled"
                                               disabled="" value="<?= $dataViews['customer']['uLastLogin'] ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="UpdateAt"><b>Thời Gian Update Gần Nhất</b></label>
                                    <div class="form-group">
                                        <input type="text" id="UpdateAt" class="form-control" placeholder="Disabled"
                                               disabled="" value="<?= $dataViews['customer']['uUpdateAt'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2"
                                               type="checkbox" <?php if ($dataViews['customer']['uStatus'] == 0) echo 'checked=""'; ?>
                                               name="status_customer">
                                        <label for="checkbox2">
                                            Hoạt Động <span style="color: red">(Bỏ Tick Sẽ Cấm Tài Khoản.)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="edit-customer"
                                    type="submit">CHỈNH SỬA
                            </button>
                        </form>
                    </div>
                    <?php } else {?>
                            <div class="body">
                                <h2>Không tìm thấy khách hàng yêu cầu.</h2>
                            </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    function sortArrayByName(item1, item2) {
        if (item1.name > item2.name) {
            return 1;
        }
        if (item1.name < item2.name) {
            return -1;
        }
        return 0;
    }

    const wardsCurr = "<?=$dataViews['customer']['uWards']?>";
    const districtCurr = "<?=$dataViews['customer']['uDistrict']?>";
    const provinceCurr = "<?=$dataViews['customer']['uProvince']?>";

    const province = document.getElementById('province');
    const district = document.getElementById('district');
    const wards = document.getElementById('wards');
    fetch('public/assets/plugins/address/nested-divisions.json')
        .then(response => response.json())
        .then(dt => {
            if (wardsCurr !== "" && districtCurr !== "" && provinceCurr !== "") {
                dt.sort(sortArrayByName);
                const tinhOp = dt.map((tinh) => `<option value="${tinh.code}">${tinh.name}</option>`)
                province.innerHTML = tinhOp;
                const arrValueProvince = [];

                const arrValueWards = [];

                $('#province option').each(function () {
                    arrValueProvince.push(this.value);
                });

                for (let i = 0; i < arrValueProvince.length; i++) {
                    if (arrValueProvince[i] == parseInt(provinceCurr) ) {
                        $('#province option').eq(i).prop('selected', true);
                    }
                }

                dt.map((tinh, index) => {
                    if (tinh.code == province.value) {
                        const arrHuyen = dt[index].districts;
                        arrHuyen.sort(sortArrayByName);
                        const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`)
                        huyenOp.unshift('<option value="" selected>Select District</option>');
                        district.innerHTML = huyenOp;
                        wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                    }
                })

                const arrValueDistrict = [];
                $('#district option').each(function () {
                    arrValueDistrict.push(this.value);
                });
                for (let i = 0; i < arrValueDistrict.length; i++) {
                    if (arrValueDistrict[i] == parseInt(districtCurr)) {
                        $('#district option').eq(i).prop('selected', true);
                    }
                }

                dt.map((tinh, indexTinh) => {
                    if (tinh.code == province.value) {
                        const arrHuyen = dt[indexTinh].districts;
                        arrHuyen.sort(sortArrayByName);
                        const huyenOp = arrHuyen.map((huyen, index) => {
                            if (huyen.code == district.value) {
                                const arrXa = dt[indexTinh].districts[index].wards;
                                arrXa.sort(sortArrayByName);
                                const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`)
                                xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                wards.innerHTML = xaOp;
                            }
                        });
                    }
                })

                $('#wards option').each(function () {
                    arrValueWards.push(this.value);
                });
                for (let i = 0; i < arrValueWards.length; i++) {
                    if (arrValueWards[i] == parseInt(wardsCurr)) {
                        $('#wards option').eq(i).prop('selected', true);
                    }
                }

                // event change
                province.addEventListener('change', (e) => {
                    e.preventDefault();
                    const tinhOp = dt.map((tinh, index) => {
                        if (tinh.code == e.target.value) {
                            const arrHuyen = dt[index].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`);
                            huyenOp.unshift('<option value="" selected>Select District</option>');
                            district.innerHTML = huyenOp;
                            wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                        }
                    })
                });
                district.addEventListener('change', (e) => {
                    e.preventDefault();
                    dt.map((tinh, indexTinh) => {
                        if (tinh.code == province.value) {
                            const arrHuyen = dt[indexTinh].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen, index) => {
                                if (huyen.code == e.target.value) {
                                    const arrXa = dt[indexTinh].districts[index].wards;
                                    arrXa.sort(sortArrayByName);
                                    const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`);
                                    xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                    wards.innerHTML = xaOp;
                                }
                            });
                        }
                    });
                });
                wards.addEventListener('change', (e) => {
                    e.preventDefault();
                });
            } else {
                dt.sort(sortArrayByName);
                const tinhOp = dt.map((tinh) => `<option value="${tinh.code}">${tinh.name}</option>`)
                province.innerHTML = tinhOp;

                province.addEventListener('change', (e) => {
                    e.preventDefault();
                    const tinhOp = dt.map((tinh, index) => {
                        if (tinh.code == e.target.value) {
                            const arrHuyen = dt[index].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`)
                            huyenOp.unshift('<option value="" selected>Select District</option>');
                            district.innerHTML = huyenOp;
                            wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                        }
                    })
                });


                district.addEventListener('change', (e) => {
                    e.preventDefault();
                    dt.map((tinh, indexTinh) => {
                        if (tinh.code == province.value) {
                            const arrHuyen = dt[indexTinh].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen, index) => {
                                if (huyen.code == e.target.value) {
                                    const arrXa = dt[indexTinh].districts[index].wards;
                                    arrXa.sort(sortArrayByName);

                                    const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`)
                                    xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                    wards.innerHTML = xaOp;
                                }
                            });
                        }
                    })
                })
                wards.addEventListener('change', (e) => {
                    e.preventDefault();
                });
            }

        });

</script>