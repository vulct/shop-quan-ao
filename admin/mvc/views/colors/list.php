<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Màu Sản Phẩm
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=color&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Màu Sản Phẩm</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card product_item_list">
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable"
                                   style="text-align: center;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name Color</th>
                                    <th>Code Color</th>
                                    <th>Show Color</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 1;
                                if (isset($dataViews['color'])) {
                                    foreach ($dataViews['color'] as $color) { ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td style="display: none"><?= $color['coID'] ?></td>
                                            <td style="display: none"><?= $color['coCode'] ?></td>
                                            <td><h5><?= $color['coColor'] ?></h5></td>
                                            <td><?= $color['coCode'] ?></td>
                                            <td style="text-align: center">
                                                <button class="btn btn-default"
                                                        style="min-width: 70px;min-height: 40px;background-color: <?= $color['coCode'] ?>"></button>
                                            </td>
                                            <td style="display: none"><?= $color['coStatus'] ?></td>
                                            <td><span class="text-muted"><?php if ($color['coStatus'] == 0) {
                                                        echo '<span class="badge badge-success">Hiển thị</span>';
                                                    } else {
                                                        echo '<span class="badge badge-warning">Ẩn</span>';
                                                    } ?></span></td>
                                            <td>
                                                <a href="?mod=color&act=edit&id=<?=$color['coID']?>"><button class="btn btn-default waves-effect waves-float waves-green"><i class="zmdi zmdi-edit"></i></button></a>
                                                <button name="delete-color" onclick="deleteColor(<?= $color['coID'] ?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
                                            </td>
                                        </tr>
                                        <?php $i++;
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function deleteColor(id) {
        Swal.fire({
            title: 'Bạn có chắc không?',
            text: "Hãy kiểm tra lại và xác nhận",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý, xóa ngay!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "?mod=color&act=delete",
                    dataType: 'text',
                    data: {'colorID': id},
                    success: function (response) {
                        response = JSON.parse(response);
                        if (Number(response.status) === 0) {
                            swal.fire("Error!", response.message, "error");
                        } else {
                            Swal.fire({
                                title: 'Xóa thành công!',
                                text: response.message,
                                icon: 'success',
                                allowOutsideClick: false
                            }).then((confirm) => {
                                if (confirm) {
                                    setTimeout(function () {
                                        location.href = ""
                                    }, 100);
                                }
                            })
                        }
                    }
                });
            }
        });
    }

</script>