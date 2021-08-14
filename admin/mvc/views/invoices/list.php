<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Đơn Hàng
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">

                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Đơn Hàng</li>
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
                                <th>Invoice No.</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            function obfuscate_email($email)
                            {
                                $em   = explode("@",$email);
                                $name = implode('@', array_slice($em, 0, count($em)-1));
                                $len  = floor(strlen($name)/2);
                                return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
                            }
                            $i = 1; if (isset($dataViews['invoice'])){ foreach ($dataViews['invoice'] as $invoice) {
                                require_once('./mvc/models/DefaultFunction.php');
                                $getAddress = new DefaultFunction();
                                $address = $getAddress->convertCodeToAddress($invoice['biWards'],$invoice['biDistrict'],$invoice['biProvince']);
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td id="name_bill_<?=$invoice['biID']?>"><a style="color: #212529 !important;" href="?mod=bill&act=detail&id=<?=$invoice['biID']?>">#<?=$invoice['biName']?></a></td>
                                    <td><?=$invoice['biCreateAt']?></td>
                                    <td><?=$invoice['biFirstName']." ".$invoice['biLastName']?></td>
                                    <td><?=obfuscate_email($invoice['biEmail'])?></td>
                                    <td><?php if ($address){?> <?=$invoice['biAddress'].", ".$address['wards'].", ".$address['district'].", ".$address['province']."."?> <?php }?></td>
                                    <td>$<?=$invoice['biTotal']?></td>
                                    <td>
                                        <?php
                                        switch ($invoice['biStatus']){
                                            case 0:
                                                echo '<span class="badge badge-warning">Chờ xác nhận</span>';
                                                break;
                                            case 1:
                                                echo '<span class="badge badge-info">Đã xác nhận</span>';
                                                break;
                                            case 2:
                                                echo '<span class="badge badge-secondary">Đang vận chuyển</span>';
                                                break;
                                            case 3:
                                                echo '<span class="badge badge-success">Đã nhận được hàng</span>';
                                                break;
                                            case 4:
                                                echo '<span class="badge badge-danger">Đã hủy</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <?php if ($invoice['biStatus'] == 4){?>
                                    <td></td>
                                    <?php }else{ ?>
                                    <td>
                                        <button name="update_status" id="update_status" onclick="updateStatusBill(<?=$invoice['biID']?>,<?=$invoice['biStatus']?>)" class="btn btn-default waves-effect waves-float waves-red" data-toggle="modal" data-target="#updateStatusBill"><i class="zmdi zmdi-repeat"></i></button>
                                    </td>
                                    <?php } ?>
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
<div class="modal fade" id="updateStatusBill" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cập Nhật Trạng Thái Đơn Hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="name_bill_update"></div>
                <div>
                    <form action="" id="form_update_status">
                        <input type="hidden" id="id_bill_status" name="id_bill_status" value="">
                        <p>Trạng thái: </p>
                        <select name="status_bill" class="form-control show-tick" id="status_bill">
                            <option value="0">Chờ xác nhận</option>
                            <option value="1">Đã xác nhận</option>
                            <option value="2">Đang vận chuyển</option>
                            <option value="3">Đã nhận được hàng</option>
                            <option value="4">Hủy</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="update_status_bill_action" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>