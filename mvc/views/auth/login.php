<div id="content">

    <!-- PAGES INNER -->
    <section class="chart-page login gray-bg padding-top-100 padding-bottom-100">
        <div class="container">

            <!-- Payments Steps -->
            <div class="shopping-cart">

                <!-- SHOPPING INFORMATION -->
                <div class="cart-ship-info">
                    <div class="row">

                        <!-- Login Register -->
                        <div class="col-sm-7 center-block">

                            <!-- Nav Tabs -->
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="login-tab" data-toggle="tab"
                                                        href="#log" role="tab" aria-selected="true">Login</a></li>
                                <li class="nav-item"><a class="nav-link" id="reg-tab" data-toggle="tab" href="#reg"
                                                        role="tab" aria-selected="false">Register</a></li>
                            </ul>
                            <!-- Login Register Inside -->
                            <div class="tab-content" id="myTabContent">

                                <!-- Login -->
                                <div class="tab-pane fade show active" id="log" role="tabpanel"
                                     aria-labelledby="login-tab">
                                    <form method="post" id="form-login" onsubmit="return false">
                                        <ul class="row">
                                            <!-- Name -->
                                            <li class="col-md-12">
                                                <label> Email Address *
                                                    <input type="text" name="email" id="email" value="" placeholder=""
                                                           class="form-control" required>
                                                </label>
                                            </li>
                                            <!-- LAST NAME -->
                                            <li class="col-md-12">
                                                <label> Password *
                                                    <input type="password" name="password" id="password" value=""
                                                           placeholder="" class="form-control" required>
                                                </label>
                                            </li>
                                            <!-- LOGIN -->
                                            <?php if (isset($_COOKIE['login_check'])) { ?>
                                                <li class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <strong>Error!</strong> <?= $_COOKIE['login_check']; ?>
                                                    </div>
                                                </li>
                                            <?php }
                                            if (isset($_COOKIE['error_register'])) {
                                                ?>
                                                <script>swal.fire("Error!", "<?= $_COOKIE['error_register']; ?>", "error");</script>
                                            <?php } ?>
                                            <?php if (isset($_COOKIE['done_register'])) { ?>
                                                <div class="alert alert-success" role="alert">
                                                    <?= $_COOKIE['done_register']; ?>
                                                </div>
                                            <?php } ?>
                                            <li class="col-md-6">
                                                <button type="submit" id="btnLogin" name="btnLogin" class="btn">LOGIN
                                                </button>
                                            </li>

                                            <!-- FORGET PASS -->
                                            <li class="col-md-6">
                                                <div class="margin-top-15 text-right"><a href="?mod=forget">Forget
                                                        Password</a></div>
                                            </li>
                                        </ul>
                                    </form>

                                    <!-- Main Heading -->
                                    <div class="heading text-center margin-bottom-50 margin-top-50">
                                        <h4>LOGIN WITH SOCIAL MEDIA</h4>
                                        <hr>
                                    </div>
                                    <ul class="login-with">
                                        <li><a href="#."><i class="fa fa-facebook"></i>FACEBOOK</a></li>
                                        <li><a href="#."><i class="fa fa-google"></i>GOOGLE</a></li>
                                        <li><a href="#."><i class="fa fa-twitter"></i>TWITTER</a></li>
                                    </ul>
                                </div>

                                <!-- Register -->
                                <div class="tab-pane fade" id="reg" role="tabpanel" aria-labelledby="reg-tab">
                                    <form id="form-register" method="post" onsubmit="return false;">
                                        <ul class="row">

                                            <li class="col-md-6">
                                                <label> First Name *
                                                    <input type="text" name="firstname" id="firstname"
                                                           placeholder="First Name" class="form-control">
                                                </label>
                                            </li>
                                            <li class="col-md-6">
                                                <label> Last Name *
                                                    <input type="text" name="lastname" id="lastname"
                                                           placeholder="Last Name" class="form-control">
                                                </label>
                                            </li>
                                            <!-- Name -->
                                            <li class="col-md-12">
                                                <label> Email Address *
                                                    <input type="text" name="email" id="reg_email"
                                                           placeholder="Email Address" class="form-control">
                                                </label>
                                            </li>
                                            <li class="col-md-12">
                                                <label> Mobile *
                                                    <input type="text" name="phone" id="phone" placeholder="Mobile"
                                                           class="form-control">
                                                </label>
                                            </li>
                                            <!-- LAST NAME -->
                                            <li class="col-md-12">
                                                <label> Password *
                                                    <input type="password" name="password" id="reg_password"
                                                           placeholder="Password" class="form-control">
                                                </label>
                                            </li>

                                            <!-- LOGIN -->
                                            <li class="col-md-6">
                                                <button type="submit" id="btnRegister" class="btn">Register</button>
                                            </li>

                                            <!-- FORGET PASS -->
                                            <li class="col-md-6">
                                                <div class="margin-top-15 text-right"><a href="?mod=forget">Forget
                                                        Password</a></div>
                                            </li>
                                        </ul>
                                    </form>

                                    <!-- Main Heading -->
                                    <div class="heading text-center margin-bottom-50 margin-top-50">
                                        <h4>LOGIN WITH SOCIAL MEDIA</h4>
                                        <hr>
                                    </div>
                                    <ul class="login-with">
                                        <li><a href="#."><i class="fa fa-facebook"></i>FACEBOOK</a></li>
                                        <li><a href="#."><i class="fa fa-google"></i>GOOGLE</a></li>
                                        <li><a href="#."><i class="fa fa-twitter"></i>TWITTER</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="small-about">
        <div class="container-full">
            <div class="news-letter padding-top-150 padding-bottom-150">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>We always stay with our clients and respect their business. We deliver 100% and provide
                            instant response to help them succeed in constantly changing and challenging business
                            world. </h3>
                        <ul class="social_icons">
                            <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                            <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                            <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                            <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                            <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <h3>Subscribe Our Newsletter</h3>
                        <span>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac.</span>
                        <form>
                            <input type="email" placeholder="Enter your email address" required>
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<script>
    // script login
    $("#btnLogin").click(function () {
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        if (checkmail(email) === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in a valid email address.'
            })
        } else if (checkmail(email) === true && password.length) {
            $.ajax({
                type: "POST",
                url: "?mod=login&act=act_login",
                dataType: 'text',
                data: $("#form-login").serialize(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0) {
                        swal.fire("Error!", response.message, "error");
                    } else if (Number(response.status) === 2) {
                        Swal.fire({
                            title: 'Checking account information...',
                            html: 'Please wait a second...',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                        setTimeout(function () {
                            swal.fire({
                                icon: 'error',
                                showDenyButton: true,
                                showCancelButton: true,
                                allowOutsideClick: false,
                                confirmButtonText: `Active`,
                                denyButtonText: `Not now!`,
                                title: "Error!",
                                text: response.message
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    location.href = "?mod=login&act=show_submit_otp"
                                } else if (result.isDenied) {
                                    Swal.fire('Please confirm your account to be able to log in.', '', 'info')
                                }
                            });
                        }, 1000);
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        })
                        setTimeout(function () {
                            location.href = "?mod=index"
                        }, 2000);
                    }
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please check your account information.'
            })
        }
    });

    // script register
    $("#btnRegister").click(function () {
        const firstname = document.getElementById("firstname").value;
        const lastname = document.getElementById("lastname").value;
        const email = document.getElementById("reg_email").value;
        const phone = document.getElementById("phone").value;
        const password = document.getElementById("reg_password").value;
        if (firstname === "" || lastname === "" || email === "" || phone === "" || password === "") {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all required fields (marked with * ).'
            })
        } else if (checkmail(email) === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in a valid email address.'
            })
        } else if (checkPassword(password) === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Password must be at least eight characters, at least one letter and one number.'
            })
        } else if (checkPhone(phone) === false) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please check your number phone.'
            })
        } else {
            Swal.fire({
                title: 'Checking account information...',
                html: 'Please wait a second...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false,
                timer: 2000,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            setTimeout(function (){
                $.ajax({
                    type: "POST",
                    url: "?mod=login&act=register",
                    dataType: 'text',
                    data: $("#form-register").serialize(),
                    success: function (response) {
                        response = JSON.parse(response);
                        if (Number(response.status) === 0) {
                            swal.fire("Error!", response.message, "error");
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            setTimeout(function () {
                                location.href = "?mod=login&act=show_submit_otp"
                            }, 2000);
                        }
                    }
                });
            },1000)

        }
    });


</script>