$(function () {
    //Datetimepicker plugin
    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD HH:mm',
        weekStart: 1,
        clearButton: true
    });
    $('#date_end').bootstrapMaterialDatePicker({ weekStart : 0 });
    $('#date_start').bootstrapMaterialDatePicker({ weekStart : 0 }).on('change', function(e, date)
    {
        $('#date_end').bootstrapMaterialDatePicker('setMinDate', date);
    });
});