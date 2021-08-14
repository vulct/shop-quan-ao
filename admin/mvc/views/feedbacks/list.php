<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Phản Hồi
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Phản Hồi</li>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Content</th>
                                <th>Create At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            function obfuscate_email($email)
                            {
                                $em   = explode("@",$email);
                                $name = implode('@', array_slice($em, 0, count($em)-1));
                                $len  = floor(strlen($name)/2);
                                return substr($name,0, $len) . str_repeat('*', $len) . "@" . end($em);
                            }
                            $i = 1; if (isset($dataViews['feedback'])){ foreach ($dataViews['feedback'] as $feedback) {
                                ?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$feedback['fbName']?></td>
                                    <td><?=obfuscate_email($feedback['fbEmail'])?></td>
                                    <td><?=$feedback['fbContent']?></td>
                                    <td><?=$feedback['fbCreateAt']?></td>
                                    <td>
                                        <?php
                                        switch ($feedback['fbStatus']){
                                            case 1:
                                                echo '<span class="badge badge-warning">Ẩn</span>';
                                                break;
                                            case 0:
                                                echo '<span class="badge badge-success">Hiển thị</span>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-default waves-effect waves-float waves-red" onclick="getStatusFeedback(<?=$feedback['fbID']?>,<?=$feedback['fbStatus']?>)" data-toggle="modal" data-target="#updateStatusFeedback"><i class="zmdi zmdi-repeat"></i></button>
                                        <button onclick="deleteFB(<?=$feedback['fbID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
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

<!-- Modal -->
<div class="modal fade" id="updateStatusFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cập Nhật Trạng Thái Phản Hồi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="" id="form_update_status_fb">
                        <input type="hidden" id="id_fb_status" name="id_fb_status" value="">
                        <p>Trạng thái: </p>
                        <select name="status_fb" class="form-control show-tick" id="status_fb">
                            <option value="0">Hiển thị</option>
                            <option value="1">Ẩn</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" id="update_status_fb_action" class="btn btn-primary">Lưu thay đổi</button>
            </div>
        </div>
    </div>
</div>