$(function () {
    $('.basic-repeater').repeater({
        show: function () {
            $(this).slideDown();
        }
    });

    $('.alert-repeater').repeater({
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            swal.fire({
                title: "Xác nhận xóa lựa chọn",
                text: "Bạn có chắc chắn xóa lựa chọn này ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $(this).slideUp(deleteElement);
                    }
                })
        }
    });
});
