<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Mã Giảm Giá
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=coupon&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Mã Giảm Giá</li>
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
                                <th>Discount</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Amount</th>
                                <th>Amount Used</th>
                                <th>Add By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['coupon'])){ foreach ($dataViews['coupon'] as $coupon) {?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td style="text-transform: uppercase"><b><?=$coupon['disCode']?></b></td>
                                    <td><?=$coupon['disValue']?>%</td>
                                    <td><?=$coupon['disStart']?></td>
                                    <td><?=$coupon['disEnd']?></td>
                                    <td><?=$coupon['disAmount']?></td>
                                    <td><?=$coupon['disUsed']?></td>
                                    <td><?=$coupon['adUsername']?></td>
                                    <td>
                                        <?php
                                        switch ($coupon['disStatus']){
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
                                        <a href="?mod=coupon&act=edit&id=<?=$coupon['disID']?>" class="btn btn-default waves-effect waves-float waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <button name="delete-coupon" onclick="deleteCoupon(<?=$coupon['disID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
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