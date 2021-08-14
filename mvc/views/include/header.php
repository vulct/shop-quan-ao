<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="M_Adnan">
    <title>BoShop</title>

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="public/assets/rs-plugin/css/settings.css" media="screen" />
    <link rel="icon" href="public/assets/images/logo.svg" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="public/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="public/assets/css/ionicons.min.css" rel="stylesheet">
    <link href="public/assets/css/main.css" rel="stylesheet">
    <link href="public/assets/css/style.css" rel="stylesheet">
    <link href="public/assets/css/responsive.css" rel="stylesheet">
    <link href="public/assets/font/flaticon.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-avatar@latest/dist/avatar.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

    <!-- JavaScripts -->
    <script src="public/assets/js/modernizr.js"></script>
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

    <!-- Online Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,400,700,900|Poppins:300,400,500,600,700|Montserrat:300,400,500,600,700,800" rel="stylesheet">

    <!--  Sweetalert2  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.css">

    <!-- Script Install -->
    <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<!-- LOADER -->
<div id="loader">
    <div class="position-center-center">
        <div class="ldr"></div>
    </div>
</div>

<!-- Wrap -->
<div id="wrap">

    <!-- TOP Bar -->
    <div class="top-bar">
        <div class="container-full">
            <p><i class="icon-envelope"></i> Info@boshop.com </p>
            <p class="call"> <i class="icon-call-in"></i> 001 234 7895 </p>

            <!-- Login Info -->
            <div class="login-info">
                <ul>
                    <?php
                    if (isset($_SESSION['user'])){ ?>
                        <li><a href="?mod=profile">Hi, <?=$_SESSION['user']['uFirstName']." ".$_SESSION['user']['uLastName']?></a></li>
                        <li><a href="?mod=cart">MY CART</a></li>
                        <li><a href="?mod=profile"> MY ACCOUNT </a></li>
                        <li><a href="?mod=logout">LOGOUT</a></li>
                    <?php } else { ?>
                        <li><a href="?mod=login">LOGIN / REGISTER</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- header -->
    <header>
        <div class="sticky">
            <div class="container-full">

                <!-- Logo -->
                <div class="logo"> <a href="?mod=index"><img class="img-responsive" src="<?=MAIN_URL?>assets/images/logo.svg" alt="" ></a> </div>
                <nav class="navbar ownmenu navbar-expand-lg ">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span></span> </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav">
                            <li <?php if(isset($_GET['mod']) && $_GET['mod']== "index"){echo "class=\"dropdown active\"";}elseif(!isset($_GET['mod'])){echo "class=\"dropdown active\"";} ?>>
                                <a href="?mod=index">Home</a></li>
                            <li <?php if(isset($_GET['mod']) && ($_GET['mod']== "shop" || $_GET['mod']=="product")){echo "class=\"dropdown active\"";} ?>> <a href="?mod=shop">Shop</a> </li>
                            <li <?php if(isset($_GET['mod']) && ($_GET['mod']== "search")){echo "class=\"dropdown active\"";} ?>> <a href="?mod=search">Search</a> </li>
                            <li <?php if(isset($_GET['mod']) && $_GET['mod']== "about"){echo "class=\"dropdown active\"";} ?>> <a href="?mod=about">About</a> </li>
                            <li <?php if(isset($_GET['mod']) && $_GET['mod']== "contact"){echo "class=\"dropdown active\"";} ?>> <a href="?mod=contact">Contact</a> </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <div class="clearfix"></div>
    </header>