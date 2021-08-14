<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Chi Tiết Hóa Đơn
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=product&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Chi Tiết Hóa Đơn</li>
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
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Color</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['bill'])){ foreach ($dataViews['bill'] as $bill) {?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><a href="?mod=product&act=detail&id=<?=$bill['proID']?>"><img src="../public/assets/images/products/<?=$bill['proImage']?>" width="48" alt="Product img"></a></td>
                                    <td>
                                        <h5><a href="?mod=product&act=detail&id=<?=$bill['proID']?>" style="color: #212529 !important;"><?=$bill['proTitle']?></a></h5>

                                    </td>
                                    <td>$<?=$bill['bidPrice']?></td>
                                    <td><?=$bill['bidQuantity']?></td>
                                    <td><?=$bill['coColor']?></td>
                                    <td>$<?=$bill['bidQuantity']*$bill['bidPrice']?></td>
                                </tr>
                                <?php $i++; }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-6">
                <div class="card">
                    <div class="header">
                        <h2><strong>Thông Tin Người Nhận</strong></h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="item">
                            <span style="font-weight: bold">Họ tên người nhận: </span>
                            <span><?=$dataViews['bill'][0]['biFirstName']. " ".$dataViews['bill'][0]['biLastName']?></span>
                        </div>
                        <?php include_once('./mvc/models/DefaultFunction.php');
                        $add = new DefaultFunction();
                        $arr = $add->convertCodeToAddress($dataViews['bill'][0]['biWards'],$dataViews['bill'][0]['biDistrict'],$dataViews['bill'][0]['biProvince']);
                        ?>
                        <div class="item">
                            <span style="font-weight: bold">Địa chỉ: </span>
                            <span><?=$dataViews['bill'][0]['biAddress'] .", ".$arr['wards'].", ".$arr['district'].", ".$arr['province']?></span>
                        </div>
                        <div class="item">
                            <span style="font-weight: bold">Số điện thoại: </span>
                            <span><?=$dataViews['bill'][0]['biMobile']?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="header">
                        <h2><strong>Thông Tin Đơn Hàng</strong></h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <style>
                            #total{
                                float: right;
                            }
                            .list-product{
                                font-weight: normal;
                                color: #2d3a4b;
                                border-bottom: 1px solid #ebebeb;
                                padding: 10px 0;
                                margin: 0px;
                            }
                            .all-total{
                                color: #2d3a4b;
                                border-bottom: 1px solid #ebebeb;
                                padding: 10px 0;
                                margin: 0px;
                                font-size: 16px !important;
                                font-weight: 900 !important;
                                line-height: 26px;
                                text-rendering: optimizeLegibility;
                                border-bottom: none !important;
                            }
                            #total-cost{
                                float: right;
                            }
                        </style>
                        <?php
                        $total = 0;
                        foreach ($dataViews['bill'] as $key => $item){
                            $total = $total + $item['bidPrice']*$item['bidQuantity'];
                            ?>
                            <p class="list-product">
                                <?=substr($item['proTitle'], 0, 30)."..."." - ".$item['coColor'];?>
                                <span id="total">$<?=$item['bidPrice']*$item['bidQuantity'];?> </span>
                            </p>
                        <?php } ?>
                        <!-- DISCOUNT -->
                        <?php if($dataViews['bill'][0]['biDiscount'] != null){ ?>
                            <p class="all-total">DISCOUNT <span id="total-cost"> $<?=$dataViews['bill'][0]['biDiscount']?></span></p>
                        <?php } ?>
                        <p class="all-total">VAT <span id="total-cost">$<?=$total*0.1?></span></p>
                        <p class="all-total">SHIPPING FEE <span id="total-cost">$<?php if ($total > 1000 ) echo '0'; else echo '30';?></span></p>
                        <!-- TOTAL COST -->
                        <p class="all-total">TOTAL COST <span id="total-cost"> $<?php $discount = $dataViews['bill'][0]['biDiscount']=!null?$dataViews['bill'][0]['biDiscount']:0; echo $dataViews['bill'][0]['biTotal'] - $discount;?></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>