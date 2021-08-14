<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Sản Phẩm
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
                    <li class="breadcrumb-item active">Danh Sách Sản Phẩm</li>
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
                                <th>Discount</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['product'])){ foreach ($dataViews['product'] as $product) {?>
                            <tr>
                                <td><?=$i?></td>
                                <td><a href="?mod=product&act=detail&id=<?=$product['proID']?>"><img src="../public/assets/images/products/<?=$product['proImage']?>" width="48" alt="Product img"></a></td>
                                <td><h5><a href="?mod=product&act=detail&id=<?=$product['proID']?>" style="color: #212529 !important;"><?=$product['proTitle']?></a></h5></td>
                                <td><?php if ($product['proDiscount']) echo '<strike>$'.$product['proPrice'].'</strike>'; else echo '$'.$product['proPrice'];?></td>
                                <td><?php if ($product['proDiscount']) echo '$'.$product['proDiscount']; else echo '';?></td>
                                <td><span class="text-muted"><?=$product['cateName']?></span></td>
                                <td>
                                    <a href="?mod=product&act=edit&id=<?=$product['proID']?>" class=  "btn btn-default waves-effect waves-float waves-green" ><i class="zmdi zmdi-edit"></i></a>
                                    <button name="delete-product" onclick="deleteProduct(<?=$product['proID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
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
