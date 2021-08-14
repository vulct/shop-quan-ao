
    <!--======= SUB BANNER =========-->
    <section class="sub-bnr" data-stellar-background-ratio="0.5">
        <div class="position-center-center">
            <div class="container">
                <h4><?= $dataViews['pro']['proTitle']?></h4>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li class="active"><?=$dataViews['pro']['proTitle']?></li>
                </ol>
            </div>
        </div>
    </section>

    <!-- Content -->
    <div id="content">

        <!-- Popular Products -->
        <section class="padding-top-100 padding-bottom-100">
            <div class="container">

                <!-- SHOP DETAIL -->
                <div class="shop-detail">
                    <div class="row">

                        <!-- Popular Images Slider -->
                        <div class="col-md-7">

                            <!-- Place somewhere in the <body> of your page -->
                            <div id="slider-shop" class="flexslider">
                                <ul class="slides">
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage']?>" alt=""> </li>
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage1']?>" alt=""> </li>
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage2']?>" alt=""> </li>
                                </ul>
                            </div>
                            <div id="shop-thumb" class="flexslider">
                                <ul class="slides">
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage']?>" alt=""> </li>
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage1']?>" alt=""> </li>
                                    <li> <img class="img-responsive" src="<?= MAIN_URL ?>assets/images/products/<?=$dataViews['pro']['proImage2']?>" alt=""> </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-md-5">
                            <h4><?=$dataViews['pro']['proTitle']?></h4>
                            <div class="rating-strs">
                            <?php
                            $star = !(is_null($dataViews['rating'])) ? $dataViews['rating']['avgRating'] : 0;
                            $dem = 0;
                            $halfStart = $star > 0 ? $star / 2 : 0;
                            if ($star == 0 && $halfStart == 0){
                                for ($i = 1; $i <= 5; $i++) {
                                    echo "<i class=\"fa fa-star-o\"></i>";
                                }
                            }else{
                                for ($i = 1; $i <= $star; $i++) {
                                    echo "<i class=\"fa fa-star\"></i>";
                                }
                                if ($halfStart != 0 && $halfStart - (int)$halfStart <= 0.5) {
                                    echo "<i class=\"fa fa-star-half-o\"></i>";
                                    $dem = 1;
                                }else{
                                    echo "<i class=\"fa fa-star\"></i>";
                                    $dem = 1;
                                }
                                for ($i = 5 - $star - $dem; $i > 0; $i--) {
                                    echo "<i class=\"fa fa-star-o\"></i>";
                                }
                            }
                            ?>
                            </div>
                            <!-- Price -->
                            <span class="price">
                            <?php if ($dataViews['pro']['proDiscount']){ ?>
                                <small>$</small><span class="line-through" style="text-decoration: line-through;margin-right: 10px;color: #999;"><?=$dataViews['pro']['proPrice']?></span>
                                <small>$</small><?=$dataViews['pro']['proDiscount']?>
                            <?php }else{
                                echo "<small>$</small>".$dataViews['pro']['proPrice'];
                            } ?>
                        </span>
                            <ul class="item-owner">
                                <li>Category:<span> <a href="#"><?= $dataViews['cate']['cateName']?></a></span></li>
                            </ul>
                            <!-- Item Detail -->
                            <p><?=$dataViews['pro']['proDescription']?></p>

                            <!-- Short By -->
                            <form action="#" method="post" name="order_product" id="order_product" onsubmit="return false">
                                <input type="hidden" name="proID" value="<?= $dataViews['pro']['proID']?>">
                                <div class="some-info">
                                    <ul class="row margin-top-30">
                                        <li class="col-md-12">
                                            <?php  foreach ($dataViews['color'] as $key => $color){ ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" oninput="getValue()" type="radio" name="valueColor" id="colorID<?=$color['coID']?>" value="<?=$color['procQuantity']."-".$color['coID']?>" <?php if ($color['procQuantity'] <= 0){ echo "disabled";}?> >
                                                <label class="form-check-label" for="colorID<?=$color['coID']?>"><?=$color['coColor']?></label>
                                            </div>
                                            <?php } ?>
                                        </li>
                                        <li class="col-md-12 quantity-color">Quantity: <span id="text-quantity"></span></li>
                                        <li class="col-sm-3">
                                            <!-- Quantity -->
                                            <div class="quinty">
                                                <div class="quantity">
                                                    <input type="number" min="1" max="100" step="1" value="1" class="form-control qty" name="numProduct" id="number_product" required title="">
                                                </div>
                                            </div>
                                        </li>

                                        <!-- ADD TO CART -->
<!--                                        onclick="return checkValue();"-->
                                        <li class="col-sm-8"> <button class="btn" type="submit" id="show-order" data-toggle="modal" data-backdrop="false" data-target="" onclick="addCart(<?= $dataViews['pro']['proID']?>);">ADD TO CART</button> </li>
                                    </ul>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle">Add to cart</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="content-modal"></div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keep shopping</button>
                                            <button type="button" id="go-to-cart" class="btn btn-primary">Go to cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                                    <!-- INFOMATION -->
                                    <div class="inner-info">
                                        <h5>Share this item with your friends</h5>
                                        <!-- Social Icons -->
                                        <ul class="social_icons">
                                            <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                                            <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                                            <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                                            <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                                            <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                                        </ul>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <!--======= PRODUCT DESCRIPTION =========-->
                <div class="item-decribe">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        <?php
                        $sumComment =  count($dataViews['comment']);
                        if ($sumComment < 10){
                            $sumComment = sprintf("%02d", $sumComment);
                        }
                        ?>
                        <li class="nav-item"><a class="active nav-link" href="#review" role="tab" data-toggle="pill">REVIEW (<?php if ($sumComment > 0){ echo $sumComment;}else echo 0; ?>)</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- REVIEW -->
                        <div role="tabpanel" class="tab-pane active" id="review">
                            <?php if ($sumComment > 0){ ?>
                            <h6><?=$sumComment?> REVIEWS FOR SHIP YOUR IDEA</h6>

                            <!-- REVIEW PEOPLE 1 -->
                            <?php foreach ($dataViews['comment'] as $key => $com){ ?>
                            <div class="media">
                                <div class="media-left">
                                    <!--  Image -->
                                    <div class="avatar mr-10">
                                        <span class="avatar-text avatar-text-danger">
                                            <span class="initial-wrap"><span><?=substr($com['uLastName'],0,2)?></span></span>
                                        </span>
                                    </div>
                                </div>
                                <!--  Details -->
                                <div class="media-body">
                                    <p>“<?=$com['comContent']?>”</p>
                                    <h6><?=$com['uLastName']." ".$com['uFirstName']?><span class="pull-right"><?= date('F d, Y',strtotime($com['comPublishedAt'])) ?></span> </h6>
                                </div>
                            </div>
                            <?php }} else{ echo "<h6>THERE ARE NO REVIEWS FOR THIS PRODUCT YET. PLEASE RATE OUR PRODUCTS. THANK YOU!</h6>"; } ?>
                            <!-- ADD REVIEW -->
                            <h6 class="margin-t-40">ADD YOUR REVIEW</h6>
                            <?php
                                if (isset($_COOKIE['notification_comment'])){
                                    echo $_COOKIE['notification_comment'];
                                }
                            ?>

                            <form action="?mod=product&act=comment" method="post">
                                <input type="hidden" name="proID" value="<?=$dataViews['pro']['proID'];?>">
                                <ul class="row">
                                    <li class="col-sm-12">
                                        <label> *YOUR REVIEW
                                            <textarea name="comContent"></textarea>
                                        </label>
                                    </li>
                                    <li class="col-sm-6">
                                        <!-- Rating Stars -->
                                        <div class="stars"> <span>YOUR RATING</span>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="comRating" id="inlineRadio1" value="1">
                                                    <span>1 </span> <i class="fa fa-star"></i>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="comRating" id="inlineRadio2" value="2">
                                                    <span>2 </span> <i class="fa fa-star"></i>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="comRating" id="inlineRadio3" value="3">
                                                    <span>3 </span><i class="fa fa-star"></i>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="comRating" id="inlineRadio4" value="4">
                                                    <span>4 </span><i class="fa fa-star"></i>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="comRating" id="inlineRadio5" value="5">
                                                    <span>5 </span><i class="fa fa-star"></i>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                    <?php
                                    if (isset($_SESSION['user']) && isset($dataViews['productInBill']) && ($dataViews['productInBill'] > 0) && $dataViews['commentOfCustomer'] == null){
                                    ?>
                                    <li class="col-sm-6">
                                        <button type="submit" class="btn btn-dark btn-small pull-right no-margin">POST REVIEW</button>
                                    </li>
                                    <?php }else if (isset($dataViews['commentOfCustomer']) && $dataViews['commentOfCustomer'] != null ){
                                        echo "<li class=\"col-sm-6\"><button class=\"btn btn-dark btn-small pull-right no-margin\" disabled>YOU HAVE ALREADY RATED THIS PRODUCT.</button></li>";
                                    } else {
                                        echo "<li class=\"col-sm-6\"><button class=\"btn btn-dark btn-small pull-right no-margin\" disabled>PLEASE PURCHASE THE PRODUCT BEFORE REVIEW.</button></li>";
                                    } ?>
                                </ul>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Products -->
        <section class="dark-bg padding-top-100 padding-bottom-100">
            <div class="container">
                <!-- Main Heading -->
                <div class="heading text-center">
                    <h4>Related Products</h4>
                    <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula.
          Sed feugiat, tellus vel tristique posuere, diam</span> </div>

                <!-- Popular Item Slide -->
                <div class="papular-block block-slide">
                    <?php foreach ($dataViews['relate'] as $rela){ ?>
                    <!-- Item -->
                    <div class="item">
                        <!-- Sale -->
                        <?php if ($rela['proDiscount']){
                            echo "<div class=\"on-sale\"> Sale </div>";
                        } ?>
                        <!-- Item img -->
                        <div class="item-img"> <img class="img-1" src="<?= MAIN_URL ?>assets/images/products/<?=$rela['proImage']?>" alt="" > <img class="img-2" src="<?= MAIN_URL ?>assets/images/products/<?=$rela['proImage']?>" alt="" >
                            <!-- Overlay -->
                            <div class="overlay">
                                <div class="position-bottom">
                                    <div class="inn"><a href="<?= MAIN_URL ?>assets/images/products/<?=$rela['proImage']?>" data-lighter><i class="icon-magnifier"></i></a>
                                        <a href="?mod=product&act=detail&id=<?=$rela['proID']?>" data-toggle="tooltip" data-placement="top" title="Add To Cart"><i class="icon-basket"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Item Name -->
                        <div class="item-name"> <a href="?mod=product&act=detail&id=<?=$rela['proID']?>"><?=$rela['proTitle']?> </a>
                            <p>Lorem ipsum dolor sit amet</p>
                        </div>
                        <!-- Price -->
                        <span class="price">
                            <?php if ($rela['proDiscount']){ ?>
                            <small>$</small><span class="line-through"><?=$rela['proPrice']?></span>
                            <small>$</small><?=$rela['proDiscount']?>
                            <?php }else{
                               echo "<small>$</small>".$rela["proPrice"];
                            } ?>
                        </span>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>

        <!-- WORK WITH US -->
        <section class="our-team padding-top-100 padding-bottom-100">
            <div class="container">
                <div class="heading text-center">
                    <h4>We work with the best brands</h4>
                    <hr>
                </div>
            </div>
            <div class="container-full">
                <div class="clients-slide">
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-1.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-2.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-3.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-1.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-2.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-3.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-1.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-2.png" alt="" > </div>
                    <div> <img src="<?= MAIN_URL ?>assets/images/brands/c-mg-3.png" alt="" > </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FOOTER -->