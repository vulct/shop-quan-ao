<section class="content ecommerce-page">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Danh Sách Khách Hàng
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <a href="?mod=customer&act=add">
                    <button class="btn btn-primary btn-icon btn-round hidden-sm-down float-right m-l-10">
                        <i class="zmdi zmdi-file-add"></i>
                    </button>
                </a>
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item active">Danh Sách Khách Hàng</li>
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Registered At</th>
                                <th>Last Login</th>
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
                            $i = 1; if (isset($dataViews['customer'])){ foreach ($dataViews['customer'] as $cus) {?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$cus['uFirstName']." ".$cus['uLastName']?></td>
                                    <td><?=obfuscate_email($cus['uEmail'])?></td>
                                    <td><?=$cus['uRegisteredAt']?></td>
                                    <td><?=$cus['uLastLogin']?></td>
                                    <td><span class="text-muted"><?php if ($cus['uStatus'] == 0){ echo '<span class="badge badge-success">Hoạt Động</span>';} else {echo '<span class="badge badge-warning">Bị Cấm</span>';}?></span></td>
                                    <td>
                                        <a href="?mod=customer&act=edit&id=<?=$cus['uID']?>" class="btn btn-default waves-effect waves-float waves-green"><i class="zmdi zmdi-edit"></i></a>
                                        <button name="delete-customer" onclick="deleteCustomer(<?=$cus['uID']?>)" class="btn btn-default waves-effect waves-float waves-red"><i class="zmdi zmdi-delete"></i></button>
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