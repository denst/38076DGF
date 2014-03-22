student = {
    init: function(){
        this.autoAssigned();
        this.submitForm();
    },
    
    autoAssigned: function(){
       students_array = [];
       $('.students').click(function(){
           if($(this).is(':checked')){
               students_array.push($(this).val());
           }else{
               students_array = _.without(students_array, $(this).val());
           }
           $('input[name="students"]').val(students_array);
       });
    }, 
    
    submitForm: function(){
        $('form[name="auto_assigned"]').submit(function(e){
            e.preventDefault();
            if($('input[name="students"]').val() != ''){
                $('form[name="auto_assigned"]')[0].submit();
            }
        });
    }
}

$(function() {
//    $('#dob_ec').datepicker();
    $('#dob_gc').datepicker({ dateFormat: 'dd-mm-y' });
//    $('#dob').datepicker();
    setTimeout(function(){
        $('.success').hide();
    }, 2000);
    student.init();
});