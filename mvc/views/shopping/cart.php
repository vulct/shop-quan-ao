<!-- SUB BANNER -->
<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>Shopping Cart</h4>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li class="active">Shopping Cart</li>
            </ol>
        </div>
    </div>
</section>

<!-- Content -->
<div id="content">
    <?php if (isset($_SESSION['cart']) && $_SESSION['cart'] != null){ ?>
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
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($_SESSION['cart'] as $proID => $product){
                            foreach ($product as $key => $pro){
                                ?>
                                <tr id="item-<?=$key."-".$proID?>">
                                    <th class="text-left"> <!-- Media Image -->
                                        <a href="?mod=product&act=detail&id=<?=$proID?>" class="item-img"> <img class="media-object" src="<?=MAIN_URL?>assets/images/products/<?=$pro['image']?>" alt=""> </a>
                                        <!-- Item Name -->
                                        <div class="media-body">
                                            <span><?=$pro['name']?></span>
                                            <p>Color: <?=$pro['color']?></p>
                                        </div>
                                    </th>
                                    <td><span id="price-<?=$key."-".$proID?>" class="price"><small>$</small><?=$pro['price']?></span></td>
                                    <td>
                                        <div class="quantity">
                                            <input type="number" name="qty-product-<?=$key."-".$proID?>" id="qty-product-<?=$key."-".$proID?>" min="1" onchange="changeProduct(<?=$proID?>,<?=$key?>,<?=$pro['numProduct']?>);" max="100" step="1" value="<?=$pro['numProduct']?>" class="form-control qty">
                                        </div>
                                    </td>
                                    <td><span id="total-price-<?=$key."-".$proID?>" class="price"><small>$</small><?=$pro['price']*$pro['numProduct'].".00"?></span></td>
                                    <td><a href="#." onclick="deleteCart(<?=$proID?>,<?=$key?>)"><i class="icon-close"></i></a></td>
                                </tr>
                            <?php }} ?>
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

                    <!-- DISCOUNT CODE -->
                    <div class="col-sm-7">
                        <div class="coupn-btn">
                            <a href="?mod=shop" class="btn">continue shopping</a>
                            <a onclick="removeCart();" href="#" class="btn">delete cart</a>
                        </div>
                    </div>

                    <!-- SUB TOTAL -->
                    <div class="col-sm-5">
                        <h6>Grand Total</h6>
                        <div class="grand-total">
                            <div class="order-detail" id="order-detail">
                                <?php
                                $total = 0;
                                foreach ($_SESSION['cart'] as $proID => $product){
                                foreach ($product as $key => $pro){ ?>
                                <p>
                                    <?=substr($pro['name'], 0, 30)."..."." - ".$pro['color'];?>
                                    <span id="total-<?=$key."-".$proID?>">$<?=$pro['price']*$pro['numProduct'];?> </span>
                                </p>
                                <?php
                                    $total = $total + $pro['price']*$pro['numProduct'];
                                }} ?>

                                <!-- SUB TOTAL -->
                                <p class="all-total">TOTAL COST <span id="total-cost"> $<?=$total?></span></p>
                            </div>
                            <a href="?mod=cart&act=checkout" class="btn margin-top-20">Proceed to checkout</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php }else { ?>
    <section class="padding-top-100 padding-bottom-100 pages-in chart-page">
        <div class="container">
            <!-- Payments Steps -->
            <div class="shopping-cart text-center">
                <div class="p-3 mb-2 bg-warning text-dark">There are no products in the cart. Go to <a href="?mod=shop" class="text-primary">the shop</a> and choose them.</div>
            </div>
        </div>
    </section>
    <?php  } ?>
</div>