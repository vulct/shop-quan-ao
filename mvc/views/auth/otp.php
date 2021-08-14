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
                                <li class="nav-item-forget"> <a class="nav-link active" id="login-tab" href="#" aria-selected="true">OTP Verification</a> </li>
                            </ul>
                            <!-- Login Register Inside -->
                            <div class="tab-content" id="myTabContent">

                                <!-- Login -->
                                <div class="tab-pane fade show active" id="log" role="tabpanel" aria-labelledby="login-tab">
                                    <div class="row">
                                        <!-- Name -->
                                        <li class="col-md-12">
                                            <label> Enter the OTP code below
                                                <input type="text" id="otp" name="otp" value="" placeholder="Enter your verification code" class="form-control" required>
                                            </label>
                                        </li>
                                        <li class="col-md-12" style="text-align: center;min-width: 200px">
                                            <button style="min-width: 200px;" type="submit" id="btnActive" name="btnActive" class="btn">ACTIVE</button>
                                        </li>
                                        <style>
                                            #btnReSend{
                                                cursor: pointer;
                                                border: solid;
                                                color: #2d3a4b;
                                                display: inline-block;
                                                padding: 15px 40px;
                                                text-transform: uppercase;
                                                font-weight: 600;
                                                font-size: 14px;
                                                border-radius: 0px;
                                                font-family: 'Poppins', sans-serif;
                                                background: #fff;
                                                position: relative;
                                                z-index: 1;
                                                text-align: center;
                                                white-space: nowrap;
                                                vertical-align: middle;
                                                line-height: 1.5;
                                                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                                                margin-top: 20px;
                                                min-width: 200px;
                                                margin-bottom: 20px;
                                                -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
                                                -moz-box-sizing: border-box;    /* Firefox, other Gecko */
                                                box-sizing: border-box;         /* Opera/IE 8+ */
                                            }
                                            #btnReSend:hover{
                                                background: #ffe115 !important;
                                                color: #2d3a4b;
                                                text-decoration: none;
                                            }
                                        </style>
                                        <li class="col-md-12" style="text-align: center;">
                                            <button type="submit" id="btnReSend" class="btnReSend">RESEND OTP</button>
                                        </li>
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
                        <h3>We always stay with our clients and respect their business. We deliver 100% and provide instant response to help them succeed in constantly changing and challenging business world. </h3>
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
    $('#btnActive').on('click',function (){
        let otp = $("#otp").val();
        if (!otp.length){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter the OTP code in your mailbox.'
            });
        }else{
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
                    url: "?mod=login&act=submit_otp",
                    dataType: 'text',
                    data: {otp : otp},
                    success: function (response) {
                        response = JSON.parse(response);
                        if (Number(response.status) === 0){
                            swal.fire("Error!", response.message, "error");
                        }else{
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            })
                            setTimeout(function(){ location.href = "?mod=login" },2000);
                        }
                    }
                });
            },1000)
        }
    });

    $("#btnReSend").on('click',function (){
        Swal.fire({
            title: 'Are you sure?',
            text: "Confirm resend OTP code.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Checking account information...',
                    html: 'Please wait a second...',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    timer: 5000,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                setTimeout(function (){
                    $.ajax({
                        type: "GET",
                        url: "?mod=login&act=otp",
                        dataType: 'text',
                        success: function (response) {
                            response = JSON.parse(response);
                            if (Number(response.status) === 0){
                                swal.fire("Error!", response.message, "error");
                            }else{
                                Swal.fire({
                                    title: 'Successful',
                                    text: response.message,
                                    icon: 'success'
                                })
                            }
                        }
                    });
                },1000)
            }
        });
    })
</script>