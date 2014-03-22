financial_record = {
    
    enableScholarship: function(){
        $('#scholarship').click(function(){
            if($(this).is(':checked'))
            {
                $('#scholarship_percent').show();
                financial_record.recalcPayments($('#scholarship_percent').val());
            }
            else
            {
                $('#scholarship_percent').hide();
                financial_record.recalcPayments(0);
            }
        });
    },
            
    setScholarship: function(){
        $('#scholarship_percent').change(function(){
            financial_record.recalcPayments($(this).val());
        });
    },
            
    recalcPayments: function(persent){
        var percent_early_repayment = $("#percent_early_repayment").val();
        var full_level_annual = $("#full_level_annual").val();
        var period_count = $("#period_count").val();
        var full_year_payment = full_level_annual - ((full_level_annual * persent) / 100);
        var early_year_payment = full_year_payment - ((full_year_payment * percent_early_repayment) / 100);
        var period_payment = full_year_payment / period_count;
        $('.each_quarte').text(period_payment);
        $('#early_repayment').text(early_year_payment);
        $('#submit_early_repayment').val(early_year_payment);
        $(".payment_scholarship").each(function(){ 
            $(this).val(persent);
        });
        $(".amount_payment").each(function(){ 
            $(this).val(period_payment);
        });
    },
}

$(function() {
    financial_record.enableScholarship();
    financial_record.setScholarship();
});