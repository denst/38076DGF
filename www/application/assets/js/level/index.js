level = {
    init: function(){
        this.changeYear();
        this.checked_inputs();
        this.checked_periods();
        this.load_period();
    },

    changeYear: function(){
        var form = $('#form_year');
        form.find('.year').change(function(){
            var year = $(this).select().val();
            location.href = form.attr('action') + '/' + year;
        });
    },
    
    checked_inputs: function(){
        $(document).ready(function(){
            $('#select_all').click(function(){
                if($('#select_all').is(':checked') == false){
                    $('.students').each(function(){
                        $(this).attr('checked', false);
                    });
                    $('input[name=students]').val('');
                }
                else{
                    var students = new Array();
                    $('.students').each(function(){
                        students.push($(this).val());
                        $(this).attr('checked', true);
                    });
                    $('input[name=students]').val(students);
                }
            });
        });
    },
    
    load_period: function(){
        this.change_period();
    },

    checked_periods: function(){
        $(document).ready(function(){
            $('.periods').change(function(){
                level.change_period();
            });
        });

    },
    
    change_period: function(){
        $(document).ready(function(){
            $('.period_block').css('display', 'none');
            var val = $('.periods :selected').val();
            $('#period_'+val).css('display', 'block');
        });

    }
}

$(function() {
    level.init();
});