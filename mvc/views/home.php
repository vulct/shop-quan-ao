<!-- Content -->
<div id="content">
    <!-- New Arrival -->
    <section class="padding-top-100 padding-bottom-100">
        <div class="container">

            <!-- Main Heading -->
            <div class="heading text-center">
                <h4>Best New Collection 2020/2021</h4>
                <hr>
            </div>

            <!-- New Arrival -->
            <div class="arrival-block item-col-3 with-spaces">
                <div class="row">
                <?php // get all products
                if (isset($dataViews)) {
                    foreach ($dataViews['pro'] as $key => $pro) {
                        if (is_null($pro['proImage1'])) {
                            $pro['proImage1'] = $pro['proImage'];
                        }
                        if (is_null($pro['proImage2'])) {
                            $pro['proImage2'] = $pro['proImage'];
                        }
                        if (is_null($pro['proImage3'])) {
                            $pro['proImage3'] = $pro['proImage'];
                        }
                        ?>
                        <div class="item">
                            <div class="img-ser">
                                <?php if ($pro['proDiscount']) echo '<div class="on-sale"> Sale </div>'; ?>
                                <!-- Images -->
                                <img class="img-1" src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage'] ?>"
                                     alt="">
                                <img class="img-2" src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage1'] ?>"
                                     alt="">
                                <!-- Overlay  -->
                                <div class="overlay">
                                    <div class="position-center-center"><a class="popup-with-move-anim" href="#qck-view-shop-<?= $pro['proID'] ?>"><i class="icon-eye"></i></a></div>
                                </div>
                            </div>

                            <!-- Item Name -->
                            <div class="item-name"><a href="?mod=product&act=detail&id=<?= $pro['proID'] ?>"
                                                      class="i-tittle"><?= $pro['proTitle'] ?></a>
                                <span class="price"><?php if ($pro['proDiscount']) { ?> <small>$</small><span class="line-through"><?= $pro['proPrice'] ?></span>
                                        <small>$</small><?= $pro['proDiscount'] ?><?php } else { ?>
                                        <small>$</small><?= $pro['proPrice'] ?><?php } ?></span>
                                <a class="deta animated fadeInRight" href="?mod=product&act=detail&id=<?= $pro['proID'] ?>">View Detail</a>
                            </div>
                        </div>
                    <?php }
                } ?>
                </div>
            </div>
        </div>
        <?php
        if (isset($dataViews)) {
        foreach ($dataViews['pro'] as $key => $pro) { ?>
            <div id="qck-view-shop-<?= $pro['proID'] ?>" class="zoom-anim-dialog qck-inside mfp-hide">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Images Slider -->
                        <div class="images-slider">
                            <ul class="slides">
                                <li data-thumb="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage1'] ?>">
                                    <img
                                            src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage1'] ?>"
                                            alt="">
                                </li>
                                <li data-thumb="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage2'] ?>">
                                    <img
                                            src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage2'] ?>"
                                            alt="">
                                </li>
                                <li data-thumb="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage3'] ?>">
                                    <img
                                            src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage3'] ?>"
                                            alt="">
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Content Info -->
                    <div class="col-md-6">
                        <div class="contnt-info">
                            <h3><?= $pro['proTitle'] ?></h3>
                            <p><?= substr($pro['proDescription'], 0, 300) . "..." ?></p>

                            <!-- Btn  -->
                            <div class="add-info">
                                <a href="?mod=product&act=detail&id=<?= $pro['proID'] ?>" class="btn">VIEW
                                    DETAIL</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }}
        ?>
        <!-- View All Items -->
        <div class="text-center margin-top-30"><a href="?mod=shop" class="btn margin-right-20">View ALl Shop Items</a>
        </div>
    </section>
    <!-- Popular Products -->
    <section class="light-gray-bg padding-top-100 padding-bottom-100">
        <div class="container">
            <div class="row">
                <!-- Main Heading -->
                <div class="heading text-center">
                    <h4>Discount Products</h4>
                    <hr>
                </div>

                <!-- Popular Item Slide -->
                <div class="papular-block block-slide-con">

                    <?php
                    if (isset($dataViews)) {
                        foreach ($dataViews['sale'] as $key => $pro) {
                            if (is_null($pro['proImage1'])) {
                                $pro['proImage1'] = $pro['proImage'];
                            }
                            if (is_null($pro['proImage2'])) {
                                $pro['proImage2'] = $pro['proImage'];
                            }
                            if (is_null($pro['proImage3'])) {
                                $pro['proImage3'] = $pro['proImage'];
                            }
                            ?>
                            <!-- Item -->
                            <div class="item">
                                <!-- Sale -->
                                <div class="on-sale"> Sale</div>
                                <!-- Item img -->
                                <div class="item-img"><img class="img-1"
                                                           src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage'] ?>"
                                                           alt=""> <img class="img-2"
                                                                        src="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage1'] ?>"
                                                                        alt="">
                                    <!-- Overlay -->
                                    <div class="overlay">
                                        <div class="position-bottom">
                                            <div class="inn"><a
                                                        href="<?= MAIN_URL ?>assets/images/products/<?= $pro['proImage'] ?>"
                                                        data-lighter><i class="icon-magnifier"></i></a> <a
                                                        href="?mod=product&act=detail&id=<?= $pro['proID'] ?>"
                                                        data-toggle="tooltip" data-placement="top"
                                                        title="Add To Cart"><i class="icon-basket"></i></a></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Item Name -->
                                <div class="item-name"><a
                                            href="?mod=product&act=detail&id=<?= $pro['proID'] ?>"><?= $pro['proTitle'] ?> </a>
                                    <p>Lorem ipsum dolor sit amet</p>
                                </div>
                                <!-- Price -->
                                <span class="price"><?php if ($pro['proDiscount']) { ?> <small>$</small><span
                                            class="line-through"><?= $pro['proPrice'] ?></span>
                                        <small>$</small><?= $pro['proDiscount'] ?><?php } else { ?>
                                        <small>$</small><?= $pro['proPrice'] ?><?php } ?></span>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
    </section>

    <!-- Shipment -->
    <section class="shipment">
        <div class="container">
            <ul>
                <li><i class="flaticon-shipped"></i>
                    <h4>Free Shipment Over 1000$</h4>
                </li>
                <li><i class="flaticon-support-1"></i>
                    <h4>24/7 online Support</h4>
                </li>
                <li><i class="flaticon-credit-card"></i>
                    <h4>100% Secure Payment </h4>
                </li>
                <li><i class="flaticon-box"></i>
                    <h4>World Wide Shipment</h4>
                </li>
            </ul>
        </div>
    </section>

    <!-- Testimonial -->
    <section class="testimonial padding-top-60 padding-bottom-80">
        <!-- Main Heading -->
        <div class="heading text-center margin-bottom-60">
            <h4>Our Customers Feedback</h4>
            <hr>
        </div>
        <div class="container"> <i class="fa fa-quote-left"></i>

            <!-- Slide -->
            <div class="single-slide" id="feedback-auto">

                <!-- Slide -->
                <?php
                require_once('./mvc/models/DefaultFunction.php');
                $func = new DefaultFunction();
                if (isset($dataViews['fb'])) {foreach ($dataViews['fb'] as $fb){
                    ?>
                    <!-- Slide -->
                    <div class="testi-in">
                        <p><?= $fb['fbContent'] ?></p>
                        <h5><?= $fb['fbName'] ?></h5>
                        <span><?= $func->obfuscate_email($fb['fbEmail']) ?></span>
                    </div>
                <?php }} ?>
            </div>
        </div>
    </section>
</div>