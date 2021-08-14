$("#login").click(function (){
    let username = $("#username").val();
    let password = $("#password").val();
    if (username == null || password == null || username === "" || password === ""){
        //alert(username);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please enter your username and password!'
        })
    }else{
        $.ajax({
            type: "POST",
            url: "?mod=login&act=act_login",
            dataType: 'text',
            data: {"username":username,"password":password},
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Đăng nhập thành công, vui lòng chờ chuyển hướng về trang chủ'
                    })
                    setTimeout(function(){ location.href = "?mod=index" },2000);
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.mess
                    })
                }
            }
        });
    }
});

function deleteProduct(id){
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa sản phẩm!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=product&act=delete",
                dataType: 'text',
                data: {'proID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                                title: 'Xóa thành công!',
                                text: response.message,
                                icon: 'success',
                                allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}

// short name file input
$(".custom-file-input").on("change", function() {
    var fileNameSort;
    var fileName = $(this).val().split("\\").pop();
    if (fileName.length > 20 ){
        fileNameSort = fileName.slice(0,20).concat("...");
    }else{
        fileNameSort = fileName;
    }
    $(this).siblings(".custom-file-label").addClass("selected").html(fileNameSort);
});


// check image product is empty
function checkImageProductIsEmpty(image_product){
    let check_image = image_product.length;
    for (let i = 0; i <= image_product.length; i++) {
        if (typeof image_product[i] !== "undefined"){
            if (image_product[i].length) {
                check_image -= 1;
            }
        }
    }
    if (check_image >= image_product.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng thêm ít nhất 1 ảnh sản phẩm.';
        showNotification(colorName, text);
        $( "#inputGroupFile01" ).focus();
        $(window).scrollTop($('input#inputGroupFile01').position().top);
        return false;
    }
    return true;
}

function validateImage(id) {
    var formData = new FormData();
    var file = document.getElementById(id).files[0];
    formData.append("Filedata", file);
    var t = file.type.split('/').pop().toLowerCase();
    if (t != "jpeg" && t != "jpg" && t != "png") {
        let colorName = 'alert-danger';
        let text = 'Vui lòng tải ảnh lên thuộc một trong các định dạng sau: jpeg,png,jpg';
        showNotification(colorName, text);
        $( "#inputGroupFile01" ).focus();
        $(window).scrollTop($('input#inputGroupFile01').position().top);
        document.getElementById(id).value = '';
        return false;
    }
    if (file.size > 5120000) {
        let colorName = 'alert-danger';
        let text = 'Kích thước ảnh tối đa cho phép là 5MB';
        showNotification(colorName, text);
        $( "#inputGroupFile01" ).focus();
        $(window).scrollTop($('input#inputGroupFile01').position().top);
        document.getElementById(id).value = '';
        return false;
    }
    return true;
}

// check name product
function checkNameProduct(name_product){
    if (!name_product.length || name_product.length < 20){
        let colorName = 'alert-danger';
        let text = 'Vui lòng thêm tên sản phẩm và tối thiểu 20 kí tự.';
        showNotification(colorName, text);
        $( "#name_product" ).focus();
        $(window).scrollTop($('input#name_product').position().top);
        return false;
    }
    return true;
}

//check price product
function checkPriceProduct(price_product,discount_product){
    if (!price_product.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập giá sản phẩm.';
        showNotification(colorName, text);
        $( "#price_product" ).focus();
        $(window).scrollTop($('input#name_product').position().top);
        return false;
    }else if (discount_product > price_product){
        let colorName = 'alert-danger';
        let text = 'Giá sau khi giảm phải nhỏ hơn giá bán ban đầu.';
        showNotification(colorName, text);
        $( "#discount_product" ).focus();
        $(window).scrollTop($('input#discount_product').position().top);
        return false;
    }
    return true;
}

// check select category
function checkSelectCategory(cate_product){
    if (!cate_product.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng chọn thư mục của sản phẩm.';
        showNotification(colorName, text);
        $( "#cate_product" ).focus();
        $(window).scrollTop($('select#cate_product').position().top);
        return false;
    }
    return true;
}

// check color product

function checkColorProduct(color_product,quantity_product){
    let check_color = color_product.length;
    for (let i = 0; i <= color_product.length; i++) {
        if (typeof color_product[i] !== "undefined" && typeof quantity_product[i] !== "undefined"){
            if (quantity_product[i] === "") {
                let colorName = 'alert-danger';
                let text = 'Vui lòng nhập số lượng sản phẩm.';
                showNotification(colorName, text);
                $('input[name="group-a['+i+'][quantity_product]"]').focus();
                $(window).scrollTop($('input[name="group-a['+i+'][quantity_product]"]').position().top);
                return false;
            }else if (color_product[i] === "" ){
                let colorName = 'alert-danger';
                let text = 'Vui lòng chọn màu cho sản phẩm.';
                showNotification(colorName, text);
                $('select[name="group-a['+i+'][color_product]"]').focus();
                $(window).scrollTop($('select[name="group-a['+i+'][color_product]"]').position().top);
                return false;
            }
        }
    }
    return true;
}

// add product
$("#add-product").click(function () {
    let name_product = $('#name_product').val();
    let price_product = $('#price_product').val();
    let discount_product = $('#discount_product').val();
    let cate_product = $('#cate_product').val();
    let image_product = $("input[name='image[]']").map(function(){return $(this).val();}).get();
    let color_product = $("select[name$='[color_product]']").map(function(){return $(this).val();}).get();
    let quantity_product = $("input[name$='[quantity_product]']").map(function(){return $(this).val();}).get();
    if(checkNameProduct(name_product) && checkPriceProduct(price_product,discount_product) && checkImageProductIsEmpty(image_product) && checkColorProduct(color_product,quantity_product) && checkSelectCategory(cate_product)){
        // form_add_product
        Swal.fire({
            title: 'Đang thêm sản phẩm...',
            html: 'Vui lòng chờ trong giây lát...',
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
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=product&act=add_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        let response = JSON.parse(res);
                        if (response.status === 1) {
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Chi Tiết Sản Phẩm`,
                                denyButtonText: `Thêm Sản Phẩm Mới`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    setTimeout(function () {
                                        location.href = "?mod=product&act=detail&id=" + response.idProduct
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function () {
                                        location.href = "?mod=product&act=add"
                                    }, 1000);
                                }
                            });
                        } else {
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    },
                    error: function (res) {

                    }
                });
            }
        },1000);
} })

// edit product
$("#edit-product").click(function () {
    let name_product = $('#name_product').val();
    let price_product = $('#price_product').val();
    let discount_product = $('#discount_product').val();
    let cate_product = $('#cate_product').val();
    let image_product = $("input[name='image[]']").map(function(){return $(this).val();}).get();
    let color_product = $("select[name$='[color_product]']").map(function(){return $(this).val();}).get();
    let quantity_product = $("input[name$='[quantity_product]']").map(function(){return $(this).val();}).get();
    if(checkNameProduct(name_product) && checkPriceProduct(price_product,discount_product) && checkColorProduct(color_product,quantity_product) && checkSelectCategory(cate_product)){
        // form_add_product
        Swal.fire({
            title: 'Đang Lưu Thông Tin sản phẩm...',
            html: 'Vui lòng chờ trong giây lát...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            timer: 5000,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        setTimeout(function () {
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=product&act=edit_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        let response = JSON.parse(res);
                        if (response.status === 1) {
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Tiếp Tục Chỉnh Sửa Sản Phẩm`,
                                denyButtonText: `Chi Tiết Sản Phẩm`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    setTimeout(function () {
                                        location.href = ""
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function () {
                                        location.href = "?mod=product&act=detail&id=" + response.idProduct
                                    }, 1000);
                                }
                            });
                        } else {
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    },
                    error: function (res) {

                    }
                });
            }
        },1000);
    } })
// #END edit product


// show error


function showNotification(colorName, text) {
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    let animateEnter = 'animated fadeInDown';
    let animateExit = 'animated fadeOutUp';
    let placementFrom = 'top';
    let placementAlign = 'right';
    var allowDismiss = true;
    $.notify({
            message: text
        },
        {
            type: colorName,
            allow_dismiss: allowDismiss,
            newest_on_top: true,
            timer: 1000,
            placement: {
                from: placementFrom,
                align: placementAlign
            },
            animate: {
                enter: animateEnter,
                exit: animateExit
            },
            showProgressbar: false,
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 5000,
            mouse_over: null,
            onShow: null,
            onShown: null,
            onClose: null,
            onClosed: null,
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert {0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
}

$('button .close').on('click', function(e) {
    $(this).parent().hide();
});
//  repeater form

// Category script
function deleteCategory(id){
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa danh mục!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=category&act=delete",
                dataType: 'text',
                data: {'cateID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}

$("#add-category").click(function () {
    let name_category = $('#name_category').val();
    if (!name_category.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tên danh mục.';
        showNotification(colorName, text);
        $("#name_category").focus();
        $(window).scrollTop($('#name_category').position().top);
    }else{
        Swal.fire({
            title: 'Đang thêm danh mục...',
            html: 'Vui lòng chờ trong giây lát...',
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
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=category&act=add_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        let response = JSON.parse(res);
                        if (response.status === 1) {
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Danh Sách Danh Mục`,
                                denyButtonText: `Thêm Mới Danh Mục`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function () {
                                        location.href = "?mod=category"
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function () {
                                        location.href = "?mod=category&act=add"
                                    }, 1000);
                                }
                            });
                        } else {
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    },
                    error: function (res) {

                    }
                });
            }
        },1000);
    }
})
function getValueCategory(id){
    let cateID = $('#id-category-'+id).text();
    let name = $('#name-category-'+id).text();
    let cateStatus = $('#status-category-'+id).text();
    $("#name-category").val(name);
    $("#id-category").val(cateID);
    let contentShow = '<input checked name="status_category" id="status_category" type="checkbox">\n' +
        '                            <label for="status_category">\n' +
        '                                Hiển thị danh mục\n' +
        '                            </label>';
    let contentHidden = '<input name="status_category" id="status_category" type="checkbox">\n' +
        '                            <label for="status_category">\n' +
        '                                Hiển thị danh mục\n' +
        '                            </label>';
    if ($("#show_category").length){
        $("#show_category").empty();
        if (cateStatus == 1){
            $("#show_category").prepend(contentHidden);
        }else{
            $("#show_category").prepend(contentShow);
        }
    }else{
        if (cateStatus == 1){
            $("#show_category").prepend(contentHidden);
        }else{
            $("#show_category").prepend(contentShow);
        }
    }
}

$("#edit-category-action").on('click',function() {
    let name_category = $('#name-category').val();
    if (!name_category.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tên phương thức thanh toán.';
        showNotification(colorName, text);
        $("#name-category").focus();
        $(window).scrollTop($('#name-category').position().top);
    }else {
        Swal.fire({
            title: 'Đang chỉnh sửa danh mục...',
            html: 'Vui lòng chờ trong giây lát...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            timer: 3000,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        setTimeout(function () {
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=category&act=edit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        let response = JSON.parse(res);
                        if (response.status === 1) {
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Danh Sách Danh Mục`,
                                denyButtonText: `Thêm Mới Danh Mục`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function () {
                                        location.href = "?mod=category"
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function () {
                                        location.href = "?mod=category&act=add"
                                    }, 1000);
                                }
                            });
                        } else {
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    }
                });
            }
        }, 2000);
    }
});
// #END category script

// customer script
function deleteCustomer(id){
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa khách hàng!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=customer&act=delete",
                dataType: 'text',
                data: {'uID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}
$("#edit-customer").on('click',function() {
    let first_name = $('#first_name').val();
    let last_name = $('#last_name').val();
    let mobile = $('#mobile').val();
    let province = $('#province').val();
    let district = $('#district').val();
    let wards = $('#wards').val();
    let address = $('#address').val();
    if (!first_name.length || !last_name.length || !mobile.length || !province.length || !district.length || !wards.length || !address.length) {
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập điền đầy đủ thông tin khách hàng.';
        showNotification(colorName, text);
    }else{
        Swal.fire({
            title: 'Đang chỉnh sửa thông tin khách hàng...',
            html: 'Vui lòng chờ trong giây lát...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        setTimeout(function(){
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=customer&act=edit_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        let response = JSON.parse(res);
                        if (response.status === 1){
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Tiếp Tục Chỉnh Sửa`,
                                denyButtonText: `Danh Sách Khách Hàng`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function (){
                                        location.href = ""
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function (){
                                        location.href = "?mod=customer"
                                    }, 1000);
                                }
                            });
                        }else{
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    }
                });
            }
        }, 2000);
    }
});
$("#add-customer").on('click',function() {
    let first_name = $('#first_name').val();
    let last_name = $('#last_name').val();
    let mobile = $('#mobile').val();
    let province = $('#province').val();
    let district = $('#district').val();
    let wards = $('#wards').val();
    let address = $('#address').val();
    if (!first_name.length || !last_name.length || !mobile.length || !province.length || !district.length || !wards.length || !address.length) {
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập điền đầy đủ thông tin khách hàng.';
        showNotification(colorName, text);
    }else{
        Swal.fire({
            title: 'Đang thêm khách hàng...',
            html: 'Vui lòng chờ trong giây lát...',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            timer: 2000,
            didOpen: () => {
                Swal.showLoading()
            }
        });
        setTimeout(function(){
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=customer&act=add_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        let response = JSON.parse(res);
                        if (response.status === 1){
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Thêm Mới Khách Hàng`,
                                denyButtonText: `Danh Sách Khách Hàng`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function (){
                                        location.href = "?mod=customer&act=add"
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function (){
                                        location.href = "?mod=customer"
                                    }, 1000);
                                }
                            });
                        }else{
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    }
                });
            }
        }, 2000);
    }
});
// #END customer script

// bill script
function updateStatusBill(id,status) {
    let tag_bill_name = "#name_bill_" + id;
    let name_bill = $(tag_bill_name).text();
    if ($(".name_bill_update").length != 0) {
        $(".name_bill_update").empty();
        $(".name_bill_update").append("<p>Đơn hàng: <b>" + name_bill + "</b></p>");
    }else{
        $(".name_bill_update").append("<p>Đơn hàng: <b>" + name_bill + "</b></p>");
    }
    $("#id_bill_status").val(id);
    var assignedRoleId = [];
    $('#status_bill option').each(function(){
        assignedRoleId.push(this.value);
    });
    for (var i = 0; i < assignedRoleId.length; i++){
        if (assignedRoleId[i] == status){
            $('#status_bill option').eq(i).prop('selected', true);
        }
    }
}

$("#update_status_bill_action").on('click',function (){
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, cập nhật ngay!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=bill&act=update",
                data: $("#form_update_status").serialize(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Cập nhật thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
});
// #END bill script

// feedback script
function getStatusFeedback(id,status) {
    var arrStatusFB = [];
    $('#status_fb option').each(function(){
        arrStatusFB.push(this.value);
    });
    for (var i = 0; i < arrStatusFB.length; i++){
        if (arrStatusFB[i] == status){
            $('#status_fb option').eq(i).prop('selected', true);
        }
    }
    $("#id_fb_status").val(id);
}
$("#update_status_fb_action").on('click',function (){
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, cập nhật ngay!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=feedback&act=update",
                data: $("#form_update_status_fb").serialize(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Cập nhật thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
});
function deleteFB(id) {
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa phản hồi!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=feedback&act=delete",
                dataType: 'text',
                data: {'fbID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}
// #END feedback script

// payment script
function getValuePayment(id_pay,name_pay,status_pay){
    $("#id_payment").val(id_pay);
    $("#name_payment").val(name_pay);
    var arrStatusPay = [];
    $('#status_payment option').each(function(){
        arrStatusPay.push(this.value);
    });
    for (var i = 0; i < arrStatusPay.length; i++){
        if (arrStatusPay[i] == status_pay){
            $('#status_payment option').eq(i).prop('selected', true);
        }
    }
}
$("#update_payment").on('click',function (){
    let name_payment = $('#name_payment').val();
    if (!name_payment.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tên phương thức thanh toán.';
        showNotification(colorName, text);
        $("#name_payment").focus();
        $(window).scrollTop($('#name_payment').position().top);
    }else{
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, cập nhật ngay!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=payment&act=update",
                data: $("#form_update_payment").serialize(),
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
    }
});
function deletePayment(id) {
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa phương thức!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=payment&act=delete",
                dataType: 'text',
                data: {'payID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}
$("#add-payment").click(function () {
    let name_payment = $('#name_payment').val();
    if (!name_payment.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tên phương thức thanh toán.';
        showNotification(colorName, text);
        $("#name_payment").focus();
        $(window).scrollTop($('#name_payment').position().top);
    }else{
        Swal.fire({
            title: 'Đang thêm phương thức...',
            html: 'Vui lòng chờ trong giây lát...',
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
        var formData = new FormData(document.querySelector("form"));
        if (formData) {
            $.ajax({
                url: "?mod=payment&act=add_action",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    let response = JSON.parse(res);
                    if (response.status === 1){
                        Swal.fire({
                            title: "Thành Công!",
                            text: response.message,
                            icon: "success",
                            allowOutsideClick: false,
                            buttons: true,
                            dangerMode: true,
                            showDenyButton: true,
                            showCancelButton: false,
                            confirmButtonText: `Danh Sách Phương Thức`,
                            denyButtonText: `Thêm Mới Phương Thức`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                setTimeout(function (){
                                    location.href = "?mod=payment"
                                }, 1000);
                            } else if (result.isDenied) {
                                setTimeout(function (){
                                    location.href = "?mod=payment&act=add"
                                }, 1000);
                            }
                        });
                    }else{
                        swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                    }
                }
            });
        }
        },1000);
    }
})
// #END payment script

// Coupon script
$('#edit-coupon').on('click',function (){
    let name_coupon = $('#name_coupon').val();
    let value_coupon = $('#value_coupon').val();
    let date_start = $('#date_start').val();
    let date_end = $('#date_end').val();
    let amount_coupon = $('#amount_coupon').val();
    if (!name_coupon.length || !value_coupon.length || !date_start.length || !date_end.length || !amount_coupon.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tất cả các trường bắt buộc (có dấu *).';
        showNotification(colorName, text);
    }else{
        Swal.fire({
            title: 'Bạn có chắc không?',
            text: "Hãy kiểm tra lại và xác nhận",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý, cập nhật ngay!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "?mod=coupon&act=edit_action",
                    data: $("#form_edit_coupon").serialize(),
                    success: function (response) {
                        response = JSON.parse(response);
                        if (Number(response.status) === 0){
                            swal.fire("Error!", response.message, "error");
                        }else{
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                icon: 'success',
                                allowOutsideClick: false
                            }).then((confirm) => {
                                if (confirm){
                                    setTimeout(function(){ location.href = "" },100);
                                }
                            })
                        }
                    }
                });
            }
        });
    }
});
function deleteCoupon(id) {
    Swal.fire({
        title: 'Bạn có chắc không?',
        text: "Hãy kiểm tra lại và xác nhận",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa mã giảm giá!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "?mod=coupon&act=delete",
                dataType: 'text',
                data: {'couponID': id},
                success: function (response) {
                    response = JSON.parse(response);
                    if (Number(response.status) === 0){
                        swal.fire("Error!", response.message, "error");
                    }else{
                        Swal.fire({
                            title: 'Xóa thành công!',
                            text: response.message,
                            icon: 'success',
                            allowOutsideClick: false
                        }).then((confirm) => {
                            if (confirm){
                                setTimeout(function(){ location.href = "" },100);
                            }
                        })
                    }
                }
            });
        }
    });
}
$("#add-coupon").click(function () {
    let name_coupon = $('#name_coupon').val();
    let value_coupon = $('#value_coupon').val();
    let date_start = $('#date_start').val();
    let date_end = $('#date_end').val();
    let amount_coupon = $('#amount_coupon').val();
    if (!name_coupon.length || !value_coupon.length || !date_start.length || !date_end.length || !amount_coupon.length){
        let colorName = 'alert-danger';
        let text = 'Vui lòng nhập tất cả các trường bắt buộc (có đánh dấu *).';
        showNotification(colorName, text);
    }else{
        Swal.fire({
            title: 'Đang thêm mã giảm giá...',
            html: 'Vui lòng chờ trong giây lát...',
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
            var formData = new FormData(document.querySelector("form"));
            if (formData) {
                $.ajax({
                    url: "?mod=coupon&act=add_action",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        let response = JSON.parse(res);
                        if (response.status === 1){
                            Swal.fire({
                                title: "Thành Công!",
                                text: response.message,
                                icon: "success",
                                allowOutsideClick: false,
                                buttons: true,
                                dangerMode: true,
                                showDenyButton: true,
                                showCancelButton: false,
                                confirmButtonText: `Danh Sách Mã Giảm Giá`,
                                denyButtonText: `Thêm Mới Mã Giảm Giá`,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    setTimeout(function (){
                                        location.href = "?mod=coupon"
                                    }, 1000);
                                } else if (result.isDenied) {
                                    setTimeout(function (){
                                        location.href = "?mod=coupon&act=add"
                                    }, 1000);
                                }
                            });
                        }else{
                            swal.fire("Có Lỗi Xảy Ra!", response.message, "error");
                        }
                    }
                });
            }
        },1000);
    }
})
// #END coupon script
$( "#pick_color" ).change(function(event) {
    $('#amount_coupon').val(event.target.value);
});
$(function () {
    $('.colorpicker').colorpicker();
})

// $("#pick_color").on('change', 'input', function() {
//     //
//
// });
