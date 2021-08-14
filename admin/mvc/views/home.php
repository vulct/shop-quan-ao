<!-- Main Content -->
<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Dashboard
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Tổng <strong>Thu Nhập</strong> </h2>
                    </div>
                    <div class="body">
                        <i class="material-icons">account_balance_wallet</i>
                        <h3 class="m-b-0">$ <?=$dataViews['sumBill']['sumBill'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Tổng <strong>Đơn Hàng</strong></h2>
                    </div>
                    <div class="body">
                        <i class="material-icons">shopping_basket</i>
                        <h3 class="m-b-0"><?=$dataViews['countBill']['totalBill'] ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Tổng <strong>Khách Hàng</strong></h2>
                    </div>
                    <div class="body">
                        <i class="material-icons">group</i>
                        <h3 class="m-b-0"><?=$dataViews['countUser']['totalUser'] ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Đánh Giá</strong> Mới Của Khách Hàng </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <ul class="row list-unstyled c_review">
                            <?php foreach ($dataViews['comment'] as $com) { ?>
                                <li class="col-12">
                                    <div class="avatar">
                                        <a href="#"><img class="rounded" src="public/assets/images/sm/avatar1.jpg" alt="user" width="60"></a>
                                    </div>
                                    <div class="comment-action">
                                        <h6 class="c_name"><?=$com['uFirstName']." ".$com['uLastName']?></h6>
                                        <p class="c_msg m-b-0"><?= $com['comContent'] ?></p>
                                        <div class="badge badge-info"><?= $com['proTitle'] ?></div>
                                        <span class="m-l-10">
                                            <?php for ($i=1; $i <= $com['comRating']; $i++){ ?>
                                                <a href="#"><i class="zmdi zmdi-star col-amber"></i></a>
                                            <?php } ?>
                                            <?php for ($i= 5 - $com['comRating']; $i > 0; $i--){ ?>
                                                <i class="zmdi zmdi-star-outline text-muted"></i>
                                            <?php } ?>
                                    </span>
                                        <small class="comment-date float-sm-right"><?=date("F j, Y",strtotime($com['comPublishedAt']))?></small>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Đơn Hàng</strong> Gần Đây</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Name</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; foreach ($dataViews['bill'] as $bill){ ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td>#<?=$bill['biName']?></td>
                                    <td><?=$bill['biFirstName']." ".$bill['biLastName']?></td>
                                    <?php
                                    require_once('./mvc/models/DefaultFunction.php');
                                    $getAddress = new DefaultFunction();
                                    $address = $getAddress->convertCodeToAddress($bill['biWards'],$bill['biDistrict'],$bill['biProvince']);
                                    ?>
                                    <td><?=$bill['biAddress'].", ".$address['wards'].", ".$address['district'].", ".$address['province']."."?></td>
                                    <td>$ <?=$bill['biTotal']?></td>
                                    <?php if ($bill['biStatus'] == 0){echo '<td><span class="badge badge-default">Chờ xác nhận</span></td>';}elseif ($bill['biStatus'] == 1){echo '<td><span class="badge badge-info">Đã xác nhận</span></td>';}
                                    elseif ($bill['biStatus'] == 2) echo '<td><span class="badge badge-warning">Đang vận chuyển</span></td>';elseif ($bill['biStatus'] == 3) echo '<td><span class="badge badge-success">Đã nhận được hàng</span></td>';
                                    elseif ($bill['biStatus'] == 4) echo '<td><span class="badge badge-danger">Đã hủy</span></td>';
                                    ?>
                                </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
