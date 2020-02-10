<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/chart.min.js"></script>
<script src="../js/chart-data.js"></script>
<script src="../js/easypiechart.js"></script>
<script src="../js/easypiechart-data.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/custom.js"></script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script> -->
<script>CKEDITOR.replace("eventDesc");</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
<script>

// 地點選項為其他時，會顯示input輸入框
$("#localid").change(function () {
    var selected_option = $('#localid').val();
    if (selected_option === 'other') {
        $('#localinput').attr('style','display:block').show();
    }
    if (selected_option != 'other') {
        $("#localinput").hide();
    }
})
$(document).ready( function () {
    $('#myTable').DataTable();
} );

</script>