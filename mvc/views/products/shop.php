<!--======= SUB BANNER =========-->
<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>The Best Shop Collection</h4>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Pages</a></li>
                <li class="active">Shop</li>
            </ol>
        </div>
    </div>
</section>

<!-- Content -->
<div id="content">

    <!-- Products -->
    <section class="shop-page padding-top-100 padding-bottom-100">
        <div class="container-full">
            <div class="row">

                <!-- Shop SideBar -->
                <div class="col-md-2">
                    <div class="shop-sidebar">

                        <!-- Category -->
                        <h5 class="shop-tittle margin-bottom-30">Category</h5>
                        <ul class="shop-cate">
                            <?php
                            foreach ($dataViews['cate'] as $key => $cate) {
                                $name = $cate["cateName"];
                                $total = $cate["totalCate"];
                                $cate = $cate["cateID"];
                                echo "<li><a href=\"?mod=shop&cate=$cate\"> $name <span>$total</span></a></li>";
                            } ?>

                        </ul>
                    </div>
                </div>
                <!-- Item Content -->
                <div class="col-md-10">
                    <div class="sidebar-layout">

                        <!-- Item Filter -->
                        <div class="item-fltr">
                            <!-- short-by -->
                            <div class="short-by"> Showing 1–<?=count($dataViews['product']['data'])?> of <?=$dataViews['product']['total']['total']?> results </div>
                            <!-- List and Grid Style -->
                            <div class="lst-grd">
                                <a href="#" id="grid"><i class="icon-grid"></i></a>
                            </div>
                        </div>

                        <!-- Item -->
                        <div id="products" class="arrival-block col-item-4 list-group">
                            <div class="row">
                                <?php foreach ($dataViews['product']['data'] as $key => $pro) { ?>
                                <!-- Item -->
                                <div class="item">
                                    <div class="img-ser">
                                        <?php if ($pro['proDiscount']) echo '<div class="on-sale"> Sale </div>';?>
                                        <!-- Images -->
                                        <div class="thumb"> <img class="img-1" src="<?= MAIN_URL ?>assets/images/products/<?=$pro['proImage']?>" alt=""><img class="img-2" src="<?= MAIN_URL ?>assets/images/products/<?=$pro['proImage']?>" alt="">
                                            <!-- Overlay  -->
                                            <div class="overlay">
                                                <div class="add-crt"><a href="?mod=product&act=detail&id=<?=$pro['proID']?>"><i class="icon-basket margin-right-10"></i> Add To Cart</a></div>
                                            </div>
                                        </div>

                                        <!-- Item Name -->
                                        <div class="item-name fr-grd"> <a href="?mod=product&act=detail&id=<?=$pro['proID']?>" class="i-tittle"><?=$pro['proTitle']?></a>
                                            <span class="price"><?php if ($pro['proDiscount']){ ?> <small>$</small><span class="line-through"><?=$pro['proPrice']?></span> <small>$</small><?=$pro['proDiscount']?> <?php }else { ?> <small>$</small><?=$pro['proPrice']?><?php } ?></span>
                                            <a class="deta animated fadeInRight" href="?mod=product&act=detail&id=<?=$pro['proID']?>">View Detail</a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>


                        <!-- Pagination -->
                        <ul class="pagination">
                            <?php
                            $total = $dataViews['product']['total']['total'];
                            $current_page = $dataViews['product']['current_page'];
                            $total_page = $dataViews['product']['total_page'];
                            if ($current_page > 1 && $total_page > 1){
                                $page = $current_page-1;
                                echo "<li><a href=\"?mod=shop&page=$page\"><</a></li>";
                            }
                            for ($i = 1; $i <= $total_page; $i++){
                                if ($i == $current_page){
                                    echo "<li class=\"active\"><a>$i</a></li>";
                                }
                                else{
                                    echo "<li><a href=\"?mod=shop&page=$i\">$i</a></li>";
                                }
                            }
//                            <li><a href="#">></a></li>
                            if ($current_page < $total_page && $total_page > 1){
                                $page = $current_page+1;
                                echo "<li><a href=\"?mod=shop&page=$page\">></a></li>";
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>