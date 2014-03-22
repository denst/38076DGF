modules = {
    
    toggle_financial_debtors: function(){
        $(document).ready(function(){
            $('.toggle_fin_debtors').click(function(){
                $('#financial_debtors').toggle('slow');
            });
        });
    },
    
    toggle_financial_class: function(){
        $(document).ready(function(){
            $('.toggle_financial_class').click(function(){
                var id = $(this).attr('id');
                $('#class_' + id).toggle('slow');
            });
        });
    },
    
    toggle_academic_class: function(){
        $(document).ready(function(){
            $('.toggle_academic_class').click(function(){
                var id = $(this).attr('id');
                $('#class_' + id).toggle('slow');
            });
        });
    },
    
    toggle_academic_debtors: function(){
        $(document).ready(function(){
            $('.toggle_academic_debtors').click(function(){
                $('#academic_debtors').toggle('slow');
            });
        });
    }, 
}

$(function() {
    modules.toggle_financial_debtors();
    modules.toggle_financial_class();
    modules.toggle_academic_debtors();
    modules.toggle_academic_class();
});