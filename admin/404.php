<!doctype html>
<html class="no-js " lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Quản lý BoShop - Cửa hàng thời trang số 1 Việt Nam..">

    <title>:: Quản lý BoShop - Boshop Management System ::</title>
    <!-- Favicon-->
    <link rel="icon" href="public/assets/images/logo.svg" type="image/x-icon">
    <!-- Custom Css -->
    <link rel="stylesheet" href="public/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/assets/css/main.css">
    <link rel="stylesheet" href="public/assets/css/authentication.css">
    <link rel="stylesheet" href="public/assets/css/color_skins.css">
</head>

<body class="theme-cyan authentication sidebar-collapse">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
    <div class="container">
        <div class="navbar-translate n_logo">
            <a class="navbar-brand" href="./?mod=index" title="" target="_blank">BOSHOP</a>
            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./?mod=index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Search Result</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Follow us on Twitter" href="#" target="_blank">
                        <i class="zmdi zmdi-twitter"></i>
                        <p class="d-lg-none d-xl-none">Twitter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Like us on Facebook" href="#" target="_blank">
                        <i class="zmdi zmdi-facebook"></i>
                        <p class="d-lg-none d-xl-none">Facebook</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Follow us on Instagram" href="#" target="_blank">
                        <i class="zmdi zmdi-instagram"></i>
                        <p class="d-lg-none d-xl-none">Instagram</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-primary btn-round" href="?mod=login">SIGN IN</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<div class="page-header">
    <div class="page-header-image" style="background-image:url('public/assets/images/login.jpg')"></div>
    <div class="container">
        <div class="col-md-12 content-center">
            <div class="card-plain">
                <form class="form" method="" action="">
                    <div class="header">
                        <div class="logo-container" style="width: 150px">
                            <img src="public/assets/images/logo.svg" alt="">
                        </div>
                        <h5>Error 404</h5>
                        <span>Page not found</span>
                    </div>
                    <div class="content">
                        <div class="input-group input-lg">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-addon">
                                <i class="zmdi zmdi-search"></i>
                            </span>
                        </div>
                    </div>
                    <div class="footer text-center">
                        <a href="./?mod=index" class="btn l-cyan btn-round btn-lg btn-block waves-effect waves-light">GO TO HOMEPAGE</a>
                        <h6 class="m-t-20"><a href="#" class="link">Need Help?</a></h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <nav>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </nav>
            <div class="copyright">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>,
                <span>Designed by <a href="#" target="_blank">Team 22</a></span>
            </div>
        </div>
    </footer>
</div>

<!-- Jquery Core Js -->
<script src="public/assets/bundles/libscripts.bundle.js"></script>
<script src="public/assets/js/custom.js"></script>
<script src="public/assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js -->
<script src="public/assets/js/sweetalert2/sweetalert2.all.js"></script>
<script>
    $(".navbar-toggler").on('click',function() {
        $("html").toggleClass("nav-open");
    });
</script>
</body>
</html>