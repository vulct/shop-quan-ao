<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Chỉnh Sửa Sản Phẩm
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=product">Quản Lý Sản Phẩm</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa Sản Phẩm</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <?php if ($dataViews['product']){?>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Chỉnh Sửa</strong> Sản Phẩm</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form id="form_edit_product" method="POST" enctype="multipart/form-data" class="basic-repeater" onsubmit="return false">
                                <div class="row clearfix" >
                                    <div class="col-md-12 m-t-10">
                                        <label for="name_product"><b>Tên Sản Phẩm <span class="text-danger">*</span></b></label>
                                        <div class="form-group">
                                            <input type="text" id="name_product" name="name_product" class="form-control" placeholder="Tên sản phẩm" value="<?=$dataViews['product']['proTitle']?>">
                                            <input type="hidden" id="id_product" name="id_product" class="form-control" value="<?=$dataViews['product']['proID']?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix" >
                                    <div class="col-md-6 m-t-10">
                                        <label for="price_product"><b>Giá Sản Phẩm(Dollar) <span class="text-danger">*</span></b></label>
                                        <div class="form-group">
                                            <input type="text" name="price_product" id="price_product" class="form-control" placeholder="Giá sản phẩm. Ex: 99,99 $" value="<?=$dataViews['product']['proPrice']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6 m-t-10">
                                        <label for="discount_product"><b>Giảm Giá(Dollar)</b></label>
                                        <div class="form-group">
                                            <input type="text" name="discount_product" id="discount_product" class="form-control money-dollar" placeholder="Giá sản phẩm sau khi giảm giá. Ex: 99,99 $" value="<?=$dataViews['product']['proDiscount']?>">
                                        </div>
                                    </div>
                                </div>
                                <label for="list_image"><b>Ảnh Sản Phẩm Hiện Tại</b></label>
                                <div class="row clearfix" id="list_image">
                                    <div class="col-lg-3 col-md-4 col-sm-12 file_manager">
                                        <div class="card">
                                            <div class="file">
                                                <a href="#">
                                                    <div class="image" style="text-align: center;">
                                                        <?php $filename = $dataViews['product']['proImage'] ?: 'no-image-product.png'; ?>
                                                        <img src="<?='../public/assets/images/products/'.$filename?>" width="124" alt="img" class="img-fluid">
                                                    </div>
                                                    <?php if ($filename !== 'no-image-product.png'){?>
                                                    <div class="file-name">
                                                        <p class="m-b-5 text-muted"><?=pathinfo('../public/assets/images/products/'.$filename)['basename']?></p>
                                                        <small>Size: <?=number_format(filesize("../public/assets/images/products/".$filename)/1024, 2, '.', '')?>KB <span class="date text-muted"><?=date ("F d Y", filemtime("../public/assets/images/products/".$dataViews['product']['proImage']))?></span></small>
                                                    </div>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 file_manager">
                                        <div class="card">
                                            <div class="file">
                                                <a href="#">
                                                    <div class="image" style="text-align: center;">
                                                        <?php $filename = $dataViews['product']['proImage1'] ?: 'no-image-product.png'; ?>
                                                        <img src="<?='../public/assets/images/products/'.$filename?>" width="124" alt="img" class="img-fluid">
                                                    </div>
                                                    <?php if ($filename !== 'no-image-product.png'){?>
                                                        <div class="file-name">
                                                            <p class="m-b-5 text-muted"><?=pathinfo('../public/assets/images/products/'.$filename)['basename']?></p>
                                                            <small>Size: <?=number_format(filesize("../public/assets/images/products/".$filename)/1024, 2, '.', '')?>KB <span class="date text-muted"><?=date ("F d Y", filemtime("../public/assets/images/products/".$dataViews['product']['proImage']))?></span></small>
                                                        </div>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 file_manager">
                                        <div class="card">
                                            <div class="file">
                                                <a href="#">
                                                    <div class="image" style="text-align: center;">
                                                        <?php $filename = $dataViews['product']['proImage2'] ?: 'no-image-product.png'; ?>
                                                        <img src="<?='../public/assets/images/products/'.$filename?>" width="124" alt="img" class="img-fluid">
                                                    </div>
                                                    <?php if ($filename !== 'no-image-product.png'){?>
                                                        <div class="file-name">
                                                            <p class="m-b-5 text-muted"><?=pathinfo('../public/assets/images/products/'.$filename)['basename']?></p>
                                                            <small>Size: <?=number_format(filesize("../public/assets/images/products/".$filename)/1024, 2, '.', '')?>KB <span class="date text-muted"><?=date ("F d Y", filemtime("../public/assets/images/products/".$dataViews['product']['proImage']))?></span></small>
                                                        </div>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-12 file_manager">
                                        <div class="card">
                                            <div class="file">
                                                <a href="#">
                                                    <div class="image" style="text-align: center;">
                                                        <?php $filename = $dataViews['product']['proImage3'] ?: 'no-image-product.png'; ?>
                                                        <img src="<?='../public/assets/images/products/'.$filename?>" width="124" alt="img" class="img-fluid">
                                                    </div>
                                                    <?php if ($filename !== 'no-image-product.png'){?>
                                                        <div class="file-name">
                                                            <p class="m-b-5 text-muted"><?=pathinfo('../public/assets/images/products/'.$filename)['basename']?></p>
                                                            <small>Size: <?=number_format(filesize("../public/assets/images/products/".$filename)/1024, 2, '.', '')?>KB <span class="date text-muted"><?=date ("F d Y", filemtime("../public/assets/images/products/".$dataViews['product']['proImage']))?></span></small>
                                                        </div>
                                                    <?php } ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix" >
                                    <div class="col-md-3 m-t-10">
                                        <label for="inputGroupFile01"><b>Ảnh Sản Phẩm</b></label>
                                        <div class="custom-file">
                                            <input type="file" onchange="validateImage('inputGroupFile01')" class="custom-file-input form-control" name="image[]" id="inputGroupFile01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 m-t-10">
                                        <label for="inputGroupFile02"><b>Ảnh Sản Phẩm</b></label>
                                        <div class="custom-file">
                                            <input type="file" onchange="validateImage('inputGroupFile02')" class="custom-file-input form-control" name="image[]" id="inputGroupFile02">
                                            <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 m-t-10">
                                        <label for="inputGroupFile03"><b>Ảnh Sản Phẩm</b></label>
                                        <div class="custom-file">
                                            <input type="file" onchange="validateImage('inputGroupFile03')" class="custom-file-input form-control" name="image[]" id="inputGroupFile03">
                                            <label class="custom-file-label" for="inputGroupFile03">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 m-t-10">
                                        <label for="inputGroupFile04"><b>Ảnh Sản Phẩm</b></label>
                                        <div class="custom-file">
                                            <input type="file" onchange="validateImage('inputGroupFile04')" class="custom-file-input form-control" name="image[]" id="inputGroupFile04">
                                            <label class="custom-file-label" for="inputGroupFile04">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- add product color: select color and add quantity  -->
                                <div class="row clearfix repeater" >
                                    <div class="col-md-12 m-t-10">
                                        <label for="name_pro"><b>Chọn Màu Cho Sản Phẩm <span class="text-danger">*</span></b></label>
                                        <div data-repeater-list="group-a">
                                            <button type="button" class="btn btn-primary btn-round btn-sm " data-repeater-create="">
                                                <span style="font-size: 1.5em;">+</span> Thêm Màu
                                            </button>
                                            <?php foreach ($dataViews['color'] as $co){?>
                                            <div data-repeater-item="">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-12 form-group">
                                                        <label for="quantity_product">Số lượng</label>
                                                        <input type="number" min="0" class="form-control" name="group-a[0][quantity_product]" placeholder="Nhập số lượng" value="<?=$co['procQuantity']?>">
                                                    </div>
                                                    <div class="col-md-2 col-sm-12 form-group" >
                                                        <label for="color_product">Màu</label>
                                                        <select name="group-a[0][color_product]" class="form-control">
                                                            <option class="color-product" value="">--Chọn màu sắc</option>
                                                            <?php foreach ($dataViews['list_color'] as $color){?>
                                                                <option class="color-product" style='background-color: <?=$color['coCode']?>' value="<?=$color['coID']?>" <?php if ($co['coID'] == $color['coID']) echo 'selected';?>><?=$color['coColor']?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 col-sm-12 form-group">
                                                        <div><label>&nbsp;</label></div>
                                                        <button type="button" class="btn btn-danger btn-round btn-sm" data-repeater-delete="">
                                                            <span style="font-size: 1.5em;">-</span> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-md-2 col-sm-12 form-group ">
                                        <label for="cate_product"><b>Danh Mục Sản Phẩm <span class="text-danger">*</span></b></label>
                                        <select name="cate_product" id="cate_product" class="form-control show-tick" data-live-search="true" tabindex="-98">
                                            <option class="cate_product" value="">--Chọn danh mục</option>
                                            <?php foreach ($dataViews['cate'] as $cate){?>
                                                <option value="<?=$cate['cateID']?>" <?php if ($dataViews['product']['cateID'] == $cate['cateID']) echo 'selected';?> ><?=$cate['cateName']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- add description -->
                                <div class="row clearfix" >
                                    <div class="col-lg-12 col-md-12 col-sm-12 m-t-10">
                                        <label for="description_product"><b>Mô Tả Sản Phẩm</b></label>
                                        <textarea id="description_product" class="form-control" placeholder="Here can be your nice text" name="description_product" rows="10"><?=$dataViews['product']['proDescription']?></textarea>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-md-3 m-t-10">
                                        <div class="checkbox">
                                            <input id="checkbox2" type="checkbox" <?php echo $dataViews['product']['proStatus'] == 0 ? 'checked' : '';?> name="show_product">
                                            <label for="checkbox2">
                                                Hiển thị sản phẩm
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-raised btn-primary btn-round waves-effect" data-text-alert="" id="edit-product" type="submit">CHỈNH SỬA SẢN PHẨM</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="body">
                                    <blockquote>
                                        <p class="blockquote blockquote-primary">
                                            "Không tìm thấy sản phẩm theo ID mà bạn cung cấp, vui lòng kiểm tra và thử lại."
                                            <br>
                                            <br>
                                        </p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>