head.js(
        "/laguadmin/js/jquery-1.6.2.min.js",
        "/laguadmin/lib/fusion-charts/FusionCharts.js",
        "/laguadmin/js/jquery.microaccordion.js",
        "/laguadmin/js/jquery.stickyPanel.js",
        "/laguadmin/js/xbreadcrumbs.js",
        "/laguadmin/lib/slidernav/slidernav.js",
        "/laguadmin/js/lagu.js",
                        
        function(){
                lga_flowTabs.tabs_b();
                lga_clearForm.init();
                lga_selectBox.init();
                lga_editor.init();
                lga_fusionCharts.chart_k();
                lga_contentSlider.init();

                lga_datepicker.init();
                lga_datepicker_inline.init();
                messages.hideMessage();
                userForm.setDeleteStudentId();
                userForm.setDeleteTeacherId();
                userForm.setDeleteAdminId();
                
//                lga_form_a_validation.init();
                
                $('.chSel_all').click(function () {
                        $(this).closest('table').find('input[name=row_sel]').attr('checked', this.checked);
                });
                $(".delete_all_simple").click(function () {
                        $('input[name=row_sel]:checked', '.smpl_tbl').closest('tr').fadeTo(600, 0, function () {
                                $(this).remove();
                                $('.chSel_all','.smpl_tbl').attr('checked',false);
                        });
                        return false;
                });
                $('.delete_all_dt').click( function() {
                        oTable = $('#data_table').dataTable();
                        $('input[@name=row_sel]:checked', oTable.fnGetNodes()).closest('tr').fadeTo(600, 0, function () {
                                oTable.fnDeleteRow( this );
                                $('.chSel_all','#data_table').attr('checked',false);
                                return false;
                        });
                });
                $('#students_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                null,
                                null,
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                null,
                                null,
                                null,
                                null
                        ]
                });
                
                $('#students_dropout_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                null,
                                null,
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                null,
                                null
                        ]
                });
                
                $('#current_class_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                { "bSortable": true },
                                null,
                                null,
                                null,
                                null
                        ]
                });
                
                $('#teacher_students_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                                { "bSortable": true },
                        ]
                });
                
                $('#teachers_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                null,
                                null,
                                { "bSortable": true },
                                { "bSortable": true },
                                null,
                                null,
                                null,
                                null
                        ]
                });
                
                $('#admin_data_table').dataTable({
                        "aaSorting": [[ 0, "asc" ]],
                        "aoColumns": [
                                { "bSortable": true },
                                null,
                                null,
                                { "bSortable": true },
                                { "bSortable": true },
                                null,
                                null,
                                null,
                        ]
                });
        }
);
messages = {

    hideMessage: function() {
        setTimeout(function() {
            $('.msg_box').hide('slow');
        }, 2000);
    }
}

userForm = {    
    setDeleteStudentId: function(){
        $('.student_delete_button').click(function(){
            $("#delete_student_id").val($(this).val());
        });
    },
    setDeleteTeacherId: function(){
        $('.teacher_delete_button').click(function(){
            $("#delete_teacher_id").val($(this).val());
        });
    },
    setDeleteAdminId: function(){
        $('.admin_delete_button').click(function(){
            $("#delete_admin_id").val($(this).val());
        });
    }
}