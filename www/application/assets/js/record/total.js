total = {
    init: function(){
        this.selectScheme();
    },
    
    evInit: function(){
        $.each($('.ev'), function(){
            if($(this).data('scheme') == $('select[name="scheme"] :selected').val()){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    },
    
    selectScheme: function(){
        $('select[name="scheme"]').change(function(){
            total.evInit();
        });
    }
}

$(function() {
    total.init();
});