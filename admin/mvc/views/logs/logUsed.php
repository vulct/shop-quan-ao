<!-- Main Content -->
<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>Lịch Sử Dùng Coupon
                    <small class="text-muted">Welcome to BoShop</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="?mod=index"><i class="zmdi zmdi-home"></i> BoShop</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Hoạt Động Hệ Thống</a></li>
                    <li class="breadcrumb-item active">Lịch Sử Dùng Coupon</li>
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
                        <h2>Danh Sách <strong>Lịch Sử Dùng Coupon</strong></h2>
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
                                <th data-breakpoints="xs">Last Name</th>
                                <th data-breakpoints="xs">Email</th>
                                <th data-breakpoints="xs">Job Title</th>
                                <th data-breakpoints="xs">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1; if (isset($dataViews['logUsed'])){ foreach ($dataViews['logUsed'] as $log){?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$log['uFirstName']?></td>
                                    <td><?=$log['uLastName']?></td>
                                    <td><?=$log['uEmail']?></td>
                                    <td style="text-transform: capitalize"><?='Sử dụng thành công mã coupon '.'<b>'.strtoupper($log['disCode']).'</b>'?></td>
                                    <td><span class="tag tag-danger"> <?=$log['logdisTime']?></span>
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