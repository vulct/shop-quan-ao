<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Thêm Mới Phương Thức Thanh Toán
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=payment">Quản Lý PTTT</a></li>
                    <li class="breadcrumb-item active">Thêm Mới PTTT</li>
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
                        <h2><strong>Thêm Mới</strong> Phương Thức Thanh Toán</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_add_payment" method="POST" onsubmit="return false">
                            <div class="row clearfix" >
                                <div class="col-md-12 m-t-10">
                                    <label for="name_product"><b>Tên Phương Thức Thanh Toán<span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="name_payment" name="name_payment" class="form-control" placeholder="Tên phương thức thanh toán">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" checked="" name="show_payment">
                                        <label for="checkbox2">
                                            Hiển thị phương thức
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="add-payment" type="submit">THÊM PHƯƠNG THỨC</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>