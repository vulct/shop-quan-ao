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
                        <h2><strong>Chỉnh Sửa </strong>Thông Tin Khách Hàng</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_add_customer" method="POST" onsubmit="return false">
                            <div class="row clearfix" >
                                <div class="col-sm-6">
                                    <label for="first_name"><b>Tên <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Nhập tên" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="last_name"><b>Họ <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Nhập họ" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix" >
                                <div class="col-sm-6">
                                    <label for="email"><b>Email <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Nhập địa chỉ email" value="" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="mobile"><b>Số Điện Thoại <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Số điện thoại" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-3">
                                    <label for="province"><b>Tỉnh/Thành Phố <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <select id="province" name="province" class="form-control" required>
                                            <option value="" selected>Chọn Tỉnh/Thành Phố</option>

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
                                        <input type="text" id="address" name="address" class="form-control" placeholder="Địa chỉ" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-4 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" checked name="status_customer">
                                        <label for="checkbox2">
                                            Hoạt Động <span style="color: red">(Bỏ Tick Sẽ Cấm Tài Khoản.)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="add-customer" type="submit">THÊM MỚI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>
<script src="public/assets/plugins/address/address.js"></script>