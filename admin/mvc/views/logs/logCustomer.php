<!-- Main Content -->
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Hoạt Động Khách Hàng
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Hoạt Động Khách Hàng</a></li>
                    <li class="breadcrumb-item active">Hoạt Động Khách Hàng</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Danh Sách <strong>Hoạt Động Khách Hàng</strong></h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th data-breakpoints="xs">Email</th>
                                <th data-breakpoints="xs">Job Title</th>
                                <th data-breakpoints="xs">Date</th>
                                <th>Status Customer</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            require_once('./mvc/models/DefaultFunction.php');
                            $hideEmail = new DefaultFunction();
                            $i = 1;  if (isset($dataViews['logCustomer'])) { foreach ($dataViews['logCustomer'] as $log){?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$log['uFirstName']?></td>
                                    <td><?=$log['uLastName']?></td>
                                    <td><?=$hideEmail->obfuscate_email($log['uEmail'])?></td>
                                    <td style="text-transform: capitalize"><?=$log['logContent']?></td>
                                    <td><span class="tag tag-danger"> <?=$log['logTime']?></span></td>
                                    <td><?php if ($log['uStatus'] == 0) { echo '<span class="badge badge-success">Hoạt Động</span>';} elseif ($log['uStatus'] == 2){echo '<span class="badge badge-info">Chưa Kích Hoạt</span>';} else echo '<span class="badge badge-danger">Bị Cấm</span>'; ?></td>
                                </tr>
                                <?php $i++; } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>