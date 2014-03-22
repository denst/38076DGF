var admin = {
    
    init: function(){
        this.formSubmit();
    },

    formSubmit: function(){
        $('.form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var error = false;
            $('input.required').each(function(){
                if($(this).val() === '')
                {
                    $(this).parent().addClass('error');
                    if(! error)
                        error = true;
                }
            });
            if(error)
                $('input[name="name"]').focus();
            else
                form[0].submit();
        });
    },
}


$(function() {
    admin.init();
});