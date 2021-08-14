<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Chi Tiết Sản Phẩm
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="?mod=product">Quản Lý Sản Phẩm</a></li>
                    <li class="breadcrumb-item active">Chi Tiết Sản Phẩm</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <?php if ($dataViews['product']){?>
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="preview col-lg-4 col-md-12">
                                <div class="preview-pic tab-content">
                                    <div class="tab-pane active" id="product_1"><img src="../public/assets/images/products/<?=$dataViews['product']['proImage']?>" class="img-fluid" /></div>
                                </div>
                            </div>
                            <div class="details col-lg-8 col-md-12">
                                <h3 class="product-title m-b-0"><?=$dataViews['product']['proTitle']?></h3>
                                <h4 class="price m-t-0">Current Price: <span class="col-amber"><?php if ($dataViews['product']['proDiscount'] && $dataViews['product']['proDiscount'] < $dataViews['product']['proPrice']) echo ' <strike style="color: #0b0b0b">$'.$dataViews['product']['proPrice'].'</strike>'.'  $'.$dataViews['product']['proDiscount']; else echo '$'.$dataViews['product']['proPrice']?></span></h4>
                                <div class="rating">
                                    <div class="stars">
                                        <?php
                                        $star = isset($dataViews['rate']['avgRating']) ? $dataViews['rate']['avgRating'] : 0;
                                        $dem = 0;
                                        $halfStart = $star / 2;
                                        for ($i = 1; $i <= $star; $i++) {
                                            echo '<span class="zmdi zmdi-star col-amber"></span>';
                                        }
                                        if ($halfStart != 0 && $halfStart - (int)$halfStart <= 0.5) {
                                            echo '<span class="zmdi zmdi-star-half col-amber"></span>';
                                            $dem = 1;
                                        }else if ($halfStart != 0 && $halfStart - (int)$halfStart > 0.5){
                                            echo '<span class="zmdi zmdi-star col-amber"></span>';
                                            $dem = 1;
                                        }
                                        for ($i = 5 - $star - $dem; $i > 0; $i--) {
                                            echo '<span class="zmdi zmdi-star-outline"></span>';
                                        }
                                        ?>
                                        <span class="m-l-10"><?=count($dataViews['comment'])?> reviews</span>
                                    </div>
                                </div>
                                <hr>
                                <p class="product-description">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                <h5 class="colors">colors:
                                    <?php foreach ($dataViews['color'] as $color){ if ($color['procQuantity'] > 0) echo '<span class="color" style="background-color: '.$color['coCode'].';border: 0.05rem #868585 solid;"></span>';
                                        else echo '<span class="color not-available" style="background-color: '.$color['coCode'].'; border: 0.05rem #868585 solid;" title="Not In store"></span>'; } ?>
                                </h5>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description">Description</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#review">Review</a></li>
                    </ul>
                </div>
                <div class="card">
                    <div class="body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="description">
                                <?=$dataViews['product']['proDescription']?>
                            </div>
                            <div class="tab-pane" id="review">
                                <ul class="row list-unstyled c_review">
                                    <?php foreach ($dataViews['comment'] as $com){?>
                                    <li class="col-12">
                                        <div class="avatar">
                                            <a href="#"><img class="rounded" src="public/assets/images/xs/avatar2.jpg" alt="user" width="60"></a>
                                        </div>
                                        <div class="comment-action">
                                            <h5 class="c_name"><?=$com['uFirstName'].' '.$com['uLastName']?></h5>
                                            <p class="c_msg m-b-0"><?=$com['comContent']?></p>
                                            <span class="m-l-10">
                                                <?php
                                                for ($i = 1; $i <= $com['comRating']; $i++){
                                                    echo '<i class="zmdi zmdi-star col-amber"></i>';
                                                }
                                                for ($i = 5 - $com['comRating']; $i > 0; $i--){
                                                    echo '<i class="zmdi zmdi-star-outline text-muted"></i>';
                                                }
                                                ?>
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
            </div>
            <?php } else { ?>
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="body">
                                    <blockquote>
                                        <p class="blockquote blockquote-primary">
                                            "Không tìm thấy sản phẩm theo ID mà bạn cung cấp, vui lòng kiểm tra và thử lại."
                                            <br>
                                            <br>
                                        </p>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>