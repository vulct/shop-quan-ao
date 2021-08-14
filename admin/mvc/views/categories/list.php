<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Danh Mục
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=category&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Danh Mục</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card product_item_list">
                    <div class="body">
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name Category</th>
                                <th>Status Category</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['cate'])){ foreach ($dataViews['cate'] as $cate) {?>
                                <tr>
                                    <td><?=$i?></td>
                                    <div id="id-category-<?=$i?>" style="display: none"><?=$cate['cateID']?></div>
                                    <td id="name-category-<?=$i?>"><h5><?=$cate['cateName']?></h5></td>
                                    <div id="status-category-<?=$i?>" style="display: none"><?=$cate['cateStatus']?></div>
                                    <td><span class="text-muted"><?php if ($cate['cateStatus'] == 0){ echo '<span class="badge badge-success">Hiển thị</span>';} else {echo '<span class="badge badge-warning">Ẩn</span>';}?></span></td>
                                    <td>
                                        <button class="btn btn-default waves-effect waves-float waves-green" id="getDataCategory" onclick="getValueCategory(<?=$i?>)" data-toggle="modal" data-target="#edit-category"><i class="zmdi zmdi-edit"></i></button>
                                        <button name="delete-category" onclick="deleteCategory(<?=$cate['cateID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
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
    </div>
</section>

<!--#MODAL EDIT CATEGORY-->
<div class="modal fade" id="edit-category" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh Sửa Danh Mục</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="id-category" name="id_category" value="">
                    <div class="form-group">
                        <label for="name-category" class="col-form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="name-category" name="name_category" value="">
                    </div>
                    <div class="form-group">
                        <div class="checkbox" id="show_category">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="edit-category-action">Chỉnh Sửa</button>
            </div>
        </div>
    </div>
</div>