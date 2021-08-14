<!-- Main Content -->
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Lịch Sử Quản Lý Hệ Thống
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Hoạt Động Hệ Thống</a></li>
                    <li class="breadcrumb-item active">Lịch Sử Quản Lý Hệ Thống</li>
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
                        <h2>Danh Sách <strong>Lịch Sử Quản Lý Hệ Thống</strong></h2>
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
                                <th data-breakpoints="xs">Name</th>
                                <th data-breakpoints="xs">Job Title</th>
                                <th data-breakpoints="xs">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;  if (isset($dataViews['logGeneral'])) { foreach ($dataViews['logGeneral'] as $log){?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$log['adUsername']?></td>
                                    <td style="text-transform: capitalize"><?=$log['logContent']?></td>
                                    <td><span class="tag tag-danger"> <?=$log['logTime']?></span></td>
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