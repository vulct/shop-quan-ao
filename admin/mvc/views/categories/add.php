<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Thêm Mới Danh Mục
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=category">Quản Lý Danh Mục</a></li>
                    <li class="breadcrumb-item active">Thêm Mới Danh Mục</li>
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
                        <h2><strong>Thêm Mới</strong> Danh Mục</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_add_product" method="POST" onsubmit="return false">
                            <div class="row clearfix" >
                                <div class="col-md-12 m-t-10">
                                    <label for="name_product"><b>Tên Danh Mục<span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="name_category" name="name_category" class="form-control" placeholder="Tên danh mục">
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" checked="" name="show_category">
                                        <label for="checkbox2">
                                            Hiển thị danh mục
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="add-category" type="submit">THÊM SẢN PHẨM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>