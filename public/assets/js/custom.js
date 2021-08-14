function getValue() {
    var valColor = document.forms["order_product"]["valueColor"].value;
    var el = document.getElementById("number_product");
    var text_quantitiy = document.getElementById("text-quantity");
    var textValue = document.getElementById("text-quantity").textContent;
    var lenght = valColor.indexOf("-");
    var quantityColor = (valColor.slice(0,lenght));
    if (quantityColor != "") {
        el.max = quantityColor;
        if (textValue != ""){
            $(text_quantitiy).html("");
            var text = document.createTextNode(quantityColor);
            text_quantitiy.appendChild(text);

        }else {
            var text = document.createTextNode(quantityColor);
            text_quantitiy.appendChild(text);
        }
    }
}

function checkValue(){
    var valProduct = document.forms["order_product"]["number_product"].value;
    var valColor = document.forms["order_product"]["valueColor"].value;
    var lenght = valColor.indexOf("-");
    var quantityColor = (valColor.slice(0,lenght));
    //valueProduct <= 0 || valueProduct == "" || valueColor == "" || valueColor == null ||
    if ( valProduct <= 0 || valProduct == "" || quantityColor == "" || quantityColor == null || Number(valProduct) > Number(quantityColor) ){
        Swal.fire({
            icon: 'error',
            title: 'Error order...',
            text: 'Please check the product information again!'
        })
        //swal("Error order!", "Please check the product information again!", "error");
        $("#order_product").attr("disabled", true);
        $("#exampleModalCenter").modal('hide');
        $("#show-order").attr("data-target","");
        return false;
    }
    return true;
}


// update info user
function updateInfo(){
    let first_name = $('#first_name').val();
    let last_name = $('#last_name').val();
    let mobile = $('#mobile').val();
    let province = $('#province').val();
    let district = $('#district').val();
    let wards = $('#wards').val();
    let address = $('#address').val();
    if (!first_name.length || !last_name.length || !mobile.length || !province.length || !district.length || !wards.length || !address.length) {
        Swal.fire({
            icon: 'error',
            title: 'Update error!',
            text: 'Please fill all in your personal information.'
        })
    }else{
        $.ajax({
            type: "POST",
            url: "?mod=profile&act=update",
            data: $("#update-info").serialize(),
            success: function (res){
                let response = JSON.parse(res);
                if (response.status === 1){
                Swal.fire({
                    icon: 'success',
                    title: 'Update success!',
                    text: 'The information has been successfully updated.'
                })
                //swal("Update success!", "The information has been successfully updated.","success");
                setTimeout(function(){ location.href = "" },2000);
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update error!',
                        text: 'Please check information.'
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown){
                Swal.fire({
                    icon: 'error',
                    title: 'Update error!',
                    text: 'Please check information.'
                })
                setTimeout(function(){ location.href = "" },2000);
            }
        });
    }

}

// check regex password
//^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).{8}$

function checkPassword(input){
    var pattern1=/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
    if(pattern1.test(input)){ return true; }else{ return false; }
}

function checkmail(input){
    var pattern1=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if(pattern1.test(input)){ return true; }else{ return false; }
}

function checkPhone(input){
    ///((09|03|07|08|05)+([0-9]{8})\b)/g
    var pattern1=/((09|03|07|08|05)+([0-9]{8})\b)/g;
    if(pattern1.test(input)){ return true; }else{ return false; }
}

// change password
function changePassword(){
    var currentPassword = document.getElementById("currentPassword").value;
    var newPassword = document.getElementById("newPassword").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    if (currentPassword == "" || newPassword == "" || confirmPassword == ""){
        Swal.fire({
            icon: 'error',
            title: 'Change error!',
            text: 'Please enter your password!'
        })
        //swal("Change error!", "Please enter your password.","error");
    }else if (confirmPassword != newPassword){
        Swal.fire({
            icon: 'error',
            title: 'Change error!',
            text: 'Check new password and confirm password.'
        })
       // swal("Change error!", "Check new password and confirm password.","error");
    }
    else {
        if (checkPassword(newPassword) == false) {
            if ($("#error-mess").length){
                $("#error-mess").remove();
                $("<div id=\"error-mess\" class=\"alert alert-danger\" role=\"alert\">\n" +
                    "  Password must be at least 8 characters, at least one letter and one number and one special character.\n" +
                    "</div>").insertBefore("#btn-change-password");
            }else{
                $("<div id=\"error-mess\" class=\"alert alert-danger\" role=\"alert\">\n" +
                    "  Password must be at least 8 characters, at least one letter and one number and one special character.\n" +
                    "</div>").insertBefore("#btn-change-password");
            }
            } else {
            $.ajax({
                type: "POST",
                url: "?mod=profile&act=change",
                data: $("#change-password").serialize(),
                success: function () {
                    //swal("Update success!", "The information has been successfully updated.", "success");
                    Swal.fire({
                        icon: 'success',
                        title: 'Update success!',
                        text: 'The information has been successfully updated.'
                    })
                    setTimeout(function(){ location.href = "" },2000);
                    if ($("#error-mess").length){
                        $("#error-mess").remove();
                    }
                    return true;
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if ($("#error-mess").length){
                        $("#error-mess").remove();
                    }
                    // swal("Update error!", "Please check information.", "error");

                    setTimeout(function () {
                        location.href = ""
                    }, 2000);
                }
            });
        }
    }
}


// add cart
function addCart(id){
    var valColor = document.forms["order_product"]["valueColor"];
    var lenght = valColor.value.indexOf("-");
    var quantityColor = valColor.value.slice(lenght+1,valColor.value.length);
    if (checkValue()){
    $.ajax({
        type: "POST",
        url: "?mod=product&act=add_cart",
        dataType: 'text',
        data: $("#order_product").serialize(),
        success: function (response) {
            response = JSON.parse(response);
            var mess = response.message;
            if (response.status == 0){
                $("#show-order").attr("data-target","#exampleModalCenter");
                var i = document.getElementById("content-modal").innerHTML.length;
                if (i > 0) {
                    $("#content-modal").empty();
                    $("#content-modal").append('<div class="alert alert-warning" role="alert">' + mess + '</div>');
                    $("#exampleModalCenter").modal('show');
                }else{
                    $("#content-modal").append('<div class="alert alert-warning" role="alert">' + mess + '</div>');
                    $("#exampleModalCenter").modal('show');
                }
            }else if(response.status == 2){
                //$("#show-order").attr("data-target","#exampleModalCenter");
                $('#exampleModalCenter').modal('hide');
                Swal.fire({
                    title: "Error!",
                    text: mess,
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                }).then((checkLogin) => {
                        if (checkLogin) {
                            setTimeout(function (){
                                location.href = "?mod=login"
                            }, 1000);

                        }
                    });
                $("#order_product").attr("disabled", true);

            }else{
                $("#show-order").attr("data-target","#exampleModalCenter");
                var num = Number(response.number);
                var name = response.data.name;
                var numProduct = Number(response.data.numProduct);
                var price = Number(response.data.price);
                var image = response.data.image;
                var color = response.data.color;
                var total = parseFloat(price * num);
                var i = document.getElementById("content-modal").innerHTML.length;
                var content = '<p class="text-success"><i class="bi bi-check-circle-fill"></i> '+ mess +'</p>' +
                    '<div class="padding-top-10 padding-bottom-10">          <!-- USER BASKET -->\n' +
                    '<div class="top-bar">\n' +
                    '<li class="user-basket">\n' +
                    '<ul style="background: #fff;">\n' +
                    '<li>\n' +
                    '<div class="media-left">\n' +
                    '<div class="cart-img"> <a href="#"> <img class="media-object img-responsive" src="public/assets/images/products/' + image + '" alt="..."> </a> </div>\n' +
                    '</div>\n' +
                    '<div class="media-body">\n' +
                    '<h6 class="media-heading">'+ name+'</h6>\n' +
                    '<span>COLOR: '+ color +'</span>' +
                    '<span>PRICE: $'+ price.toFixed(2) +'</span> ' +
                    '<span>QUANTITY: ' + num +'</span> </div>\n' +
                    '</li>\n' +
                    '<li>\n' +
                    '<h5 class="text-left">SUBTOTAL: <small> '+ total.toFixed(2) +' USD </small></h5>\n' +
                    '</li>\n' +
                    '</div>     \n' +
                    '</div>'
                if (i > 0) {
                    $("#content-modal").empty()
                    $("#content-modal").append(content);
                    $("#exampleModalCenter").modal('show');
                }else {
                    $("#content-modal").append(content);
                    $("#exampleModalCenter").modal('show');
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            window.location.reload("");
        }
    });
}else {
        swal.fire("Error!", "Please check information.", "error");
    }
}

$( "#go-to-cart" ).click(function() {
    setTimeout(function () {
        location.href = "?mod=cart"
    }, 0);
});

function changeProduct(proID,colorID,val){
    num = $("#qty-product-"+colorID+'-'+proID).val();
    txt_price = $("#price-"+colorID+'-'+proID).text();
    price = txt_price.slice(1,-3);
    total = num*price;

    if ( Number(num) == 0 || Number(num) < 0){
        $("#qty-product-"+colorID+'-'+proID).val(val);
        swal.fire("Error!", "Please check your product quantity.", "error");
    }else{
        //alert('proID: '+proID+'-colorID: '+colorID+'numProd: '+num);
        updateCart(proID,colorID,num,val);

        //$('shopping-cart').load('?mod=cart #listCart');
    }
}

function updateCart(proID,colorID,numPro,val){
    $.ajax({
        type: "POST",
        url: "?mod=cart&act=update",
        dataType: 'text',
        data: {'proID' : proID,'colorID' : colorID,'numPro' : numPro},
        success: function (response) {
            response = JSON.parse(response);
            if (Number(response.status) == 0){
                if (response.status != null){
                    num =response.num;
                }else{
                    num = 1;
                }
                $("#qty-product-"+colorID+'-'+proID).val(num);
                swal.fire("Error!", response.message, "error");
            }else{
                $("#total-price-"+colorID+'-'+proID).empty();
                $("#total-price-"+colorID+'-'+proID).append('<small>$</small>');
                $("#total-price-"+colorID+'-'+proID).append(total+'.00');
                $("#total-"+colorID+'-'+proID).text('$'+total);
                var element = document.querySelectorAll('#order-detail > p > span');
                //lấy ra nội dung của thẻ.
                total_item = 0;
                lengthTotal = element.length;
                for (var i = 0;i <= (lengthTotal-2); i++){
                    var content = element[i].innerText;
                    currTotal = content.slice(1,content.length);
                    total_item = Number(total_item ) + Number(currTotal);
                }
                $("#total-cost").empty();
                $("#total-cost").text('$' + total_item);
            }
        }
    });
}

function deleteCart(proID,colorID){
    Swal.fire({
        title: 'Are you sure?',
        text: "Please ensure and then confirm!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=cart&act=delete",
                dataType: 'text',
                data: {'proID': proID, 'colorID': colorID},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) == 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        $('#item-'+colorID+'-'+proID).remove();
                    }
                }
            });
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    });
}

function removeCart(){
    Swal.fire({
        title: 'Are you sure?',
        text: "Please ensure and then confirm!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=cart&act=remove",
                dataType: 'text',
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) == 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        window.location.reload("");
                    }
                }
            });
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    });
}

function addDiscount(){
    code = $("#code-discount").val();
    $.ajax({
        type: "POST",
        url: "?mod=cart&act=discount",
        dataType: 'text',
        data: {"code":code},
        success: function (response) {
            response = JSON.parse(response);
            if (response.status == 0){

                currCost = $("#total-cost-checkout").text();
                if ($("#discount").length > 0){
                    $("#discount").empty();
                    $("#discount").text(response.discountValue);
                }else{
                    showDiscount = "<p>DISCOUNT  <span id=\"discount\">" + response.discountValue + "</span><span>- $</span></p>";
                    $(".all-total").before(showDiscount);

                }
                $("#total-cost-checkout").empty();
                $("#total-cost-checkout").text(response.priceAfterDiscount);
                swal.fire("Success!", response.message, "success");

            }else{
                $("#code-discount").val('');
                swal.fire("Error!", response.message, "error");
            }
            //alert(response.message);
        }
    });
}

$("#submit-info-bill").click(function (){
    updateInfo();
});

// total cost

feeship = $("#fee-shipping").text();
vat = $("#vat").text();
totalProduct = $("#total-product").val();
$("#total-cost-checkout").empty();
$("#total-cost-checkout").text( Number(feeship)  + Number(vat) + Number(totalProduct));

// confirm-order
//1. Check checked TERMS & CONDITIONS
function checkTermsCondition(){
    return $("#checkbox-accept").is(":checked");
}
//2. Billing Information
function checkBillInfo(){
    const uFirstName = $("#uFirstName").val();
    const uLastName = $("#uLastName").val();
    const province = $("#province").val();
    const district = $("#district").val();
    const wards = $("#wards").val();
    const uAddress = $("#uAddress").val();
    const uMobile = $("#uMobile").val();
    if (uFirstName.length === 0){
        if ($("#danger-uFirstName").length > 0){
            $("#danger-uFirstName").remove();
            $("#uFirstName").after("<p class=\"text-danger\" id='danger-uFirstName'>Please enter your firstname.</p>");
        }else{
            $("#uFirstName").after("<p class=\"text-danger\" id='danger-uFirstName'>Please enter your firstname.</p>");
        }
        return false;
    }else if (uLastName.length === 0){
        if ($("#danger-uLastName").length > 0){
            $("#danger-uLastName").remove();
            $("#uLastName").after("<p class=\"text-danger\" id='danger-uLastName'>Please enter your lastname.</p>");
        }else{
            $("#uLastName").after("<p class=\"text-danger\" id='danger-uLastName'>Please enter your lastname.</p>");
        }
        return false;
    } else if (province.length === 0){
        if ($("#danger-province").length > 0){
            $("#danger-province").remove();
            $("#province").after("<p class=\"text-danger\" id='danger-province'>Please select your province.</p>");
        }else{
            $("#province").after("<p class=\"text-danger\" id='danger-province'>Please select your province.</p>");
        }
        return false;
    }else if (district.length === 0){
        if ($("#danger-district").length > 0){
            $("#danger-district").remove();
            $("#district").after("<p class=\"text-danger\" id='danger-district'>Please select your district.</p>");
        }else{
            $("#district").after("<p class=\"text-danger\" id='danger-district'>Please select your district.</p>");
        }
        return false;
    }else if (wards.length === 0){
        if ($("#danger-wards").length > 0){
            $("#danger-wards").remove();
            $("#wards").after("<p class=\"text-danger\" id='danger-wards'>Please select your ward.</p>");
        }else{
            $("#wards").after("<p class=\"text-danger\" id='danger-wards'>Please select your ward.</p>");
        }
        return false;
    }else if (uAddress.length === 0){
        if ($("#danger-uAddress").length > 0){
            $("#danger-uAddress").remove();
            $("#uAddress").after("<p class=\"text-danger\" id='danger-uAddress'>Please select your address.</p>");
        }else{
            $("#uAddress").after("<p class=\"text-danger\" id='danger-uAddress'>Please select your address.</p>");
        }
        return false;
    }else if (uMobile.length === 0){
        if ($("#danger-uMobile").length > 0){
            $("#danger-uMobile").remove();
            $("#uMobile").after("<p class=\"text-danger\" id='danger-uMobile'>Please select your mobile.</p>");
        }else{
            $("#uMobile").after("<p class=\"text-danger\" id='danger-uMobile'>Please select your mobile.</p>");
        }
        return false;
    }
    return true;
}

//3. Check Payment

function checkPayment(){
    let radioPayment = $('input[name="radioPayment"]:checked').val();
    if (radioPayment == null){
        if ($("#danger-checkbox-payment").length > 0){
            $("#danger-checkbox-payment").remove();
            $("#div-checkbox-payment").after("<p class=\"text-danger\" id='danger-checkbox-payment'>Please choose a payment method.</p>");
        }else{
            $("#div-checkbox-payment").after("<p class=\"text-danger\" id='danger-checkbox-payment'>Please choose a payment method.</p>");
        }
        return false;
    }else{
        return radioPayment;
    }
}

// ORDER END
$("#confirm-order").click(function (){
    // Validate data order
    //1. Check checked TERMS & CONDITIONS
    if (checkTermsCondition() == false){
        if ($("#danger-checkbox-accept").length > 0){
            $("#danger-checkbox-accept").remove();
            $("#div-checkbox-accept").after("<p class=\"text-danger\" id='danger-checkbox-accept'>Read the terms of service and agree with us.</p>");
        }else{
            $("#div-checkbox-accept").after("<p class=\"text-danger\" id='danger-checkbox-accept'>Read the terms of service and agree with us.</p>");
        }
    } else if (checkPayment() == false) {
        checkPayment();
    } else if (checkBillInfo() == false){
        checkBillInfo();
    }
    else {
        const valPayment = checkPayment();
        const discountCode = $("#code-discount").val();
        Swal.fire({
            title: 'Ordering in progress...',
            text: '',
            allowOutsideClick: false,
            imageUrl: 'public/assets/images/icon/loading.gif',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image'
        });

        //var data_info = new FormData($('form#update-info')[0]);
        var data_info = new FormData(document.querySelector("form"));
        data_info.append("payment", valPayment);
        data_info.append("discountCode", discountCode);
        $.ajax({
            //update-info
            type: "POST",
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            url: "?mod=cart&act=order",
            dataType: 'text',
            //{"payment": valPayment, "discountCode": discountCode},
            data: data_info,
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 0) {
                    Swal.fire({
                        title: '<div class="p-3 mb-2 bg-success text-white">Great!</div>',
                        icon: 'success',
                        html: response.message,
                        allowOutsideClick: false,
                        showCloseButton: false,
                        showCancelButton: true,
                        focusConfirm: true,
                        cancelButtonText:
                            '<a href="?mod=shop"><i class="fa fa-times-circle" aria-hidden="true"></i> Continue Shopping</a>\n',
                        cancelButtonAriaLabel: 'cancel',
                        confirmButtonText:
                            '<a href="?mod=profile&act=bill&id=' + response.id + '"><i class="fa fa-info" aria-hidden="true"></i> Detail!</a>',
                        confirmButtonAriaLabel: 'View detail'
                    })
                    //swal.fire("Success!", response.message, "success");
                } else {
                    swal.fire("Error!", response.message, "error");
                    $("#code-discount").val('');
                }
            }
        });
    }
    if(checkTermsCondition()) {
        $("#danger-checkbox-accept").remove();
    }
});

//FORGET PASSWORD
$("#btnForget").click(function (){
    let email = $("#email").val();
    if (checkmail(email)){
        Swal.fire({
            title: 'Please wait for us to check your information...',
            text: '',
            imageUrl: 'public/assets/images/icon/loading.gif',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            timer:3000
        });
        $.ajax({
            type: "POST",
            url: "?mod=forget&act=get",
            dataType: 'text',
            data: {"email":email},
            success: function (response){
                response = JSON.parse(response);
                if (response.status == 1){
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: true,
                        dangerMode: true,
                    }).then((updatePassword) => {
                        if (updatePassword) {
                            setTimeout(function (){
                                location.href = "?mod=login"
                            }, 1000);
                        }
                    });
                }
                else{
                    swal.fire("Error!", response.message, "error");
                }
            }
        });
    }else{
        swal.fire("Error!", "Please enter your email.", "error");
    }
});

var owl = $('#feedback-auto');
owl.owlCarousel({
    items:1,
    animateOut: 'animate__bounceOutRight',
    animateIn: 'animate__bounceInLeft',
    margin:10,
    loop:true,
    autoplay:true,
    autoplayTimeout:2000,
    autoplayHoverPause:false
});