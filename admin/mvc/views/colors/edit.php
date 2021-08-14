<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Chỉnh Sửa Màu Sản Phẩm
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Chỉnh Sửa Màu Sản Phẩm</li>
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
                        <h2><strong>Chỉnh Sửa </strong>Màu Sản Phẩm</h2> <p>(Vui lòng điền đầy đủ vào phần có dấu <span class="text-danger">*</span>)</p>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form_edit_color" method="POST" onsubmit="return false">
                            <div class="row clearfix" >
                                <input type="hidden" name="color_id" value="<?=$dataViews['color']['coID']?>">
                                <div class="col-sm-12">
                                    <label for="name_color"><b>Tên Màu Sắc <span class="text-danger">*</span></b></label>
                                    <div class="form-group">
                                        <input type="text" id="name_color" name="name_color" class="form-control" placeholder="Tên màu sắc" value="<?=$dataViews['color']['coColor']?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <label for="value_coupon"><b>Mã Màu Sắc<span class="text-danger">*</span></b></label>
                                    <div class="input-group colorpicker">
                                        <input type="text" class="form-control" id="code_color" name="code_color" value="<?=$dataViews['color']['coCode']?>">
                                        <span class="input-group-addon"> <i style="border: solid 1px #ff9900;"></i> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-3 m-t-10">
                                    <div class="checkbox">
                                        <input id="checkbox2" type="checkbox" <?php if ($dataViews['color']['coCode'] == 0) echo 'checked'; ?> name="show_color">
                                        <label for="checkbox2">
                                            Hiển thị (Được phép sử dụng)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-raised btn-primary btn-round waves-effect" id="edit-color" type="submit">CHỈNH SỬA</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Basic Validation -->
    </div>
</section>
<script src="public/assets/plugins/jquery/jquery-v3.2.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#edit-color').on('click',function (){
            let name_color = $('#name_color').val();
            let code_color = $('#code_color').val();
            if (!name_color.length || !code_color.length){
                let colorName = 'alert-danger';
                let text = 'Vui lòng nhập tất cả các trường bắt buộc (có dấu *).';
                showNotification(colorName, text);
            }else{
                Swal.fire({
                    title: 'Bạn có chắc không?',
                    text: "Hãy kiểm tra lại và xác nhận",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý, cập nhật ngay!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "?mod=color&act=edit_action",
                            data: $("#form_edit_color").serialize(),
                            success: function (response) {
                                response = JSON.parse(response);
                                if (Number(response.status) === 0){
                                    swal.fire("Error!", response.message, "error");
                                }else{
                                    Swal.fire({
                                        title: 'Thành công!',
                                        text: response.message,
                                        icon: 'success',
                                        allowOutsideClick: false
                                    }).then((confirm) => {
                                        if (confirm){
                                            setTimeout(function(){ location.href = "" },100);
                                        }
                                    })
                                }
                            }
                        });
                    }
                });
            }
        });
    });
</script>