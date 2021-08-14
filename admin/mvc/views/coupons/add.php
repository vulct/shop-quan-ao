<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Thêm Mới Mã Giảm Giá
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=coupon">Quản Lý Mã Giảm Giá</a></li>
                    <li class="breadcrumb-item active">Thêm Mới Mã Giảm Giá</li>
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
                        <h2><strong>Thêm Mới </strong>Mã Giảm Giá</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_add_coupon" method="POST" onsubmit="return false">
                            <div class="row clearfix" >
                                <div class="col-sm-6">
                                    <label for="name_coupon"><b>Mã Giảm Giá <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="name_coupon" name="name_coupon" class="form-control" placeholder="Mã giảm giá" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="value_coupon"><b>Giá Trị (%)<span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="number" id="value_coupon" name="value_coupon" class="form-control" placeholder="Giá trị" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <label for="date_start"><b>Thời Gian Bắt Đầu <span class="text-danger">*</span></b></label>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-calendar"></i>
                                    </span>
                                        <input type="text" id="date_start" name="date_start" class="form-control datetimepicker" placeholder="Please choose a time..." required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="date_end"><b>Thời Gian Kết Thúc <span class="text-danger">*</span></b></label>
                                    <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="zmdi zmdi-calendar"></i>
                                    </span>
                                        <input type="text" id="date_end" name="date_end" class="form-control datetimepicker" placeholder="Please choose a time..." required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix" >
                                <div class="col-sm-6">
                                    <label for="amount_coupon"><b>Số Lượng <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="amount_coupon" name="amount_coupon" class="form-control" placeholder="Số lượng" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" checked name="show_coupon">
                                        <label for="checkbox2">
                                            Hiển thị (Được phép sử dụng)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="add-coupon" type="submit">THÊM MỚI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>
