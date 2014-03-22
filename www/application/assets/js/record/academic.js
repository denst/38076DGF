academic_record = {
    init: function(){
        this.formSubmit();
        this.orderInit();
        this.selectPeriod();
    },
    
    orderInit: function(){
        $.each($('.order'), function(){
            if($(this).data('period') == $('select[name="period"] :selected').val()){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    },
    
    selectPeriod: function(){
        $('select[name="period"]').change(function(){
            academic_record.orderInit();
        });
    },
    
    formSubmit: function(){
        $('form[name="academic_record_new"]').submit(function(e){
            e.preventDefault();
            var form = this;
            $.each($('.order'), function(){
                if($(this).css('display') != 'none') $(this).find('select[name="order_tmp"]').attr('name', 'order');
            });
            form.submit();
        });
    }
}

$(function() {
    academic_record.init();
});