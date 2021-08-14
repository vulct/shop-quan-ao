<!-- SUB BANNER -->
<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>Order Detail #<?=$dataViews['bill'][0]['biName']?></h4>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li class="active">Order Detail</li>
            </ol>
        </div>
    </div>
</section>

<!-- Content -->
<div id="content">
        <!-- PAGES INNER -->
        <section class="padding-top-100 padding-bottom-100 pages-in chart-page">
            <div class="container">
                <!-- Payments Steps -->
                <div class="shopping-cart text-center">
                    <form action="" id="listCart" method="post" onsubmit="return false">
                        <table class="table" id="cart">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-left">Items</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($dataViews['bill'] as $key => $item){
                            ?>
                                    <tr id="item">
                                        <th class="text-left"> <!-- Media Image -->
                                            <a href="?mod=product&act=detail&id=<?=$item['proID']?>" class="item-img"> <img class="media-object" src="<?=MAIN_URL?>assets/images/products/<?=$item['proImage']?>" alt=""> </a>
                                            <!-- Item Name -->
                                            <div class="media-body">
                                                <span><?=$item['proTitle']?></span>
                                                <p>Color: <?=$item['coColor']?></p>
                                            </div>
                                        </th>
                                        <td><span id="price" class="price"><small>$</small><?=$item['bidPrice']?></span></td>
                                        <td><span id="price" class="price"><?=$item['bidQuantity']?></span></td>
                                        <td><span id="total-price" class="price"><small>$</small><?=$item['bidPrice']*$item['bidQuantity'].".00"?></span></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </section>

        <!-- PAGES INNER -->
        <section class="padding-top-100 padding-bottom-100 light-gray-bg shopping-cart small-cart">
            <div class="container">

                <!-- SHOPPING INFORMATION -->
                <div class="cart-ship-info margin-top-0">
                    <div class="row">
                        <style>
                            .text-info-receiver{
                                font-weight: normal;
                                color: #2d3a4b;
                                border-bottom: 1px solid #ebebeb;
                                padding: 10px 0;
                                margin: 0px;
                            }
                        </style>
                        <!-- DISCOUNT CODE -->
                        <div class="col-sm-6">
                            <h6>Receiver's Information</h6>
                            <?php include_once('./mvc/models/DefaultFunction.php');
                            $add = new DefaultFunction();
                            $arr = $add->convertCodeToAddress($dataViews['bill'][0]['biWards'],$dataViews['bill'][0]['biDistrict'],$dataViews['bill'][0]['biProvince']);
                            ?>
                            <div class="grand-total" style="min-height: 250px;">
                                <div class="text-info-receiver"><span style="font-weight: bold">Receiver: </span><?=$dataViews['bill'][0]['biFirstName'] . " ". $dataViews['bill'][0]['biLastName']?></div>
                                <div class="text-info-receiver"><span style="font-weight: bold">Address: </span><?=$dataViews['bill'][0]['biAddress'] .", ".$arr['wards'].", ".$arr['district'].", ".$arr['province']?></div>
                                <div class="text-info-receiver"><span style="font-weight: bold">Phone: </span><?=$dataViews['bill'][0]['biMobile']?></div>
                            </div>
                            <div class="coupn-btn" >
                                <a href="?mod=shop" class="btn">continue shopping</a>
                                <?php if ($dataViews['bill'][0]['biStatus'] == 0){ ?>
                                    <button onclick="cancelOrder(<?=$dataViews['bill'][0]['biID']?>)" class="btn">cancel order</button>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- SUB TOTAL -->
                        <div class="col-sm-6">
                            <h6>Order Information</h6>
                            <div class="grand-total" style="min-height: 250px;">
                                <div class="order-detail" id="order-detail">
                                    <!-- SUB TOTAL -->
                                    <?php
                                    $total = 0;
                                    foreach ($dataViews['bill'] as $key => $item){
                                        $total = $total + $item['bidPrice']*$item['bidQuantity'];
                                        ?>
                                        <p>
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
</div>
<script>
    function cancelOrder(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "Please ensure and then confirm!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "?mod=profile&act=cancel&id=" + id,
                    success: function (response) {
                        response = JSON.parse(response);
                        if (Number(response.status) == 0){
                            swal.fire("Error!", response.message, "error");
                        }else{
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                            setTimeout(function (){
                                window.location.reload("");
                            },1000)
                        }
                    }
                });
            }
        });
    }
</script>