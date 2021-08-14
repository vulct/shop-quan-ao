<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Phương Thức Thanh Toán
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=payment&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Phương Thức Thanh Toán</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card product_item_list">
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['payment'])){ foreach ($dataViews['payment'] as $payment) {?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$payment['payName']?></td>
                                    <td>
                                        <?php
                                        switch ($payment['payStatus']){
                                            case 1:
                                                echo '<span class="badge badge-warning">Ẩn</span>';
                                                break;
                                            case 0:
                                                echo '<span class="badge badge-success">Hiển thị</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default waves-effect waves-float waves-green" id="getDataPayment" onclick="getValuePayment(<?=$payment['payID']?>,'<?=$payment['payName']?>',<?=$payment['payStatus']?>)" data-toggle="modal" data-target="#editPayment"><i class="zmdi zmdi-edit"></i></button>
                                        <button name="delete-payment" onclick="deletePayment(<?=$payment['payID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
                                    </td>
                                </tr>
                                <?php $i++; }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh Sửa Phương Thức Thanh Toán</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="form_update_payment">
                    <input type="hidden" id="id_payment" name="id_payment" value="">
                    <div class="form-group">
                        <label for="name_payment" class="col-form-label">Tên phương thức </label>
                        <input type="text" class="form-control" id="name_payment" name="name_payment" value="">
                    </div>
                    <p>Trạng thái: </p>
                    <select name="status_payment" class="form-control show-tick" id="status_payment">
                        <option value="0">Hiển thị</option>
                        <option value="1">Ẩn</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="update_payment" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>