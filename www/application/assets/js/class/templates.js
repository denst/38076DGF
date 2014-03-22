var template_class = {
    
    init: function(){
        this.addedClass();
        this.successInit();
        this.removeClass();
        this.checked_inputs();
        this.checked_delete_subjects();
        this.change_scheme();
    },
    
    successInit: function(){
        setTimeout(function(){
            $('.success').hide();
        }, 2000);
    },
    
    addedClass: function(){
        var i = 0;
        $('#more-cls').click(function(e){
            e.preventDefault();
            var classes = $('.classes');
            var clss    = $('.class').clone()[0];
            $(clss).find('select[name="class"]')
                .attr('name', 'classes[]').attr('id', i);
            classes.append($(clss).show());
            $('select[id='+ i +']').find('option:eq('+ i +')').attr("selected", "selected")
            template_class.hideClass();
            i++;
        });
    },
    
    removeClass: function(){
        $('.remove-cls').click(function(e){
            e.preventDefault();
            var block  = $(this).parent();
            var select = block.find('select');
            var name   = select.attr('name').split('old').join('delete');
            select.attr('name', name);
            block.hide();
        })
    }, 
    
    hideClass: function(){
        $('.hide-cls').click(function(e){
            e.preventDefault();
            $(this).parent().remove();
        })
    },
    
    checked_inputs: function(){
        $(document).ready(function(){
            $('#select_all_cheme').click(function(){
                if($('#select_all_cheme').is(':checked') == false){
                    $('.scheme').each(function(){
                        $(this).attr('checked', false);
                    });
                }
                else{
                    $('.scheme').each(function(){
                        $(this).attr('checked', true);
                    });
                }
            });
        });
    },
    
    checked_delete_subjects: function(){
        $(document).ready(function(){
            $('#select_all_delete_subjects').click(function(){
                if($('#select_all_delete_subjects').is(':checked') == false){
                    $('.delete_subject').each(function(){
                        $(this).attr('checked', false);
                    });
                }
                else{
                    $('.delete_subject').each(function(){
                        $(this).attr('checked', true);
                    });
                }
            });
        });
    },
    
    change_scheme: function(){
        $(document).ready(function(){
            $('#all_scheme').change(function(){
                var select_value = $("#all_scheme").val();
                $('.scheme').each(function(){
                    if($(this).is(':checked') == true){
                        $(this).next().val(select_value);
                    }
                });
            });
        });
    },
}


$(function() {
    template_class.init();
});