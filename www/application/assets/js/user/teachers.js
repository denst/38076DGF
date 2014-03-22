var teacher = {
    
    init: function(){
        this.addedQualification();
        this.addedExperience();
        this.formSubmit();
    },
    
    
    addedQualification: function(){
        $('#more-qualification').click(function(e){
            e.preventDefault();
            var qualifications = $('.qualifications');
            var qual           = $('.qualification').clone()[0];
            var qual_name      = $(qual).find('#qualification_0_name');
            var qual_level     = $(qual).find('#qualification_0_level');
            var qual_year      = $(qual).find('#qualification_0_year');
            var qual_grade     = $(qual).find('#qualification_0_grade');
            var qual_rel       = $(qual).find('#qualification_0_relation');
            var count          = $('.qualification').length;
            
            qual_name.val('');
            qual_name.attr('id', 'qualification_' + count + '_name');
            qual_name.prev().attr('for', 'qualification_' + count + '_name');
            qual_name.attr('name', 'qualification[' + count + '][name]');
            
            qual_level.val('');
            qual_level.attr('id', 'qualification_' + count + '_level');
            qual_level.prev().attr('for', 'qualification_' + count + '_level');
            qual_level.attr('name', 'qualification[' + count + '][level]');
            
            qual_year.val('');
            qual_year.attr('id', 'qualification_' + count + '_year');
            qual_year.prev().attr('for', 'qualification_' + count + '_year');
            qual_year.attr('name', 'qualification[' + count + '][year]');
            
            qual_grade.val('');
            qual_grade.attr('id', 'qualification_' + count + '_grade');
            qual_grade.prev().attr('for', 'qualification_' + count + '_grade');
            qual_grade.attr('name', 'qualification[' + count + '][grade]');
            
            qual_rel.val('');
            qual_rel.attr('id', 'qualification_' + count + '_relation');
            qual_rel.prev().attr('for', 'qualification_' + count + '_relation');
            qual_rel.attr('name', 'qualification[' + count + '][relation]');
            
            qualifications.append(qual);
        });
    },
    
    
    addedExperience: function(){
        $('#more-experience').click(function(e){
            e.preventDefault();
            var experiences = $('.experiences');
            var exp         = $('.experience').clone()[0];
            var exp_yfr     = $(exp).find('#experience_0_yfr');
            var exp_yto     = $(exp).find('#experience_0_yto');
            var exp_pw      = $(exp).find('#experience_0_pw');
            var exp_job     = $(exp).find('#experience_0_job');
            var exp_contact = $(exp).find('#experience_0_contact');
            var exp_address = $(exp).find('#experience_0_address');
            var exp_to      = $(exp).find('#experience_0_to');
            var exp_tm      = $(exp).find('#experience_0_tm');
            var count       = $('.experience').length;

            exp_yfr.val('');
            exp_yfr.attr('id', 'experience_' + count + '_yfr');
            exp_yfr.prev().attr('for', 'experience_' + count + '_yfr');
            exp_yfr.attr('name', 'experience[' + count + '][yfr]');

            exp_yto.val('');
            exp_yto.attr('id', 'experience_' + count + '_yto');
            exp_yto.prev().attr('for', 'experience_' + count + '_yto');
            exp_yto.attr('name', 'experience[' + count + '][yto]');

            exp_pw.val('');
            exp_pw.attr('id', 'experience_' + count + '_pw');
            exp_pw.prev().attr('for', 'experience_' + count + '_pw');
            exp_pw.attr('name', 'experience[' + count + '][pw]');
            
            exp_job.val('');
            exp_job.attr('id', 'experience_' + count + '_job');
            exp_job.prev().attr('for', 'experience_' + count + '_job');
            exp_job.attr('name', 'experience[' + count + '][job]');
            
            exp_contact.val('');
            exp_contact.attr('id', 'experience_' + count + '_contact');
            exp_contact.prev().attr('for', 'experience_' + count + '_contact');
            exp_contact.attr('name', 'experience[' + count + '][contact]');
            
            exp_address.val('');
            exp_address.attr('id', 'experience_' + count + '_address');
            exp_address.prev().attr('for', 'experience_' + count + '_address');
            exp_address.attr('name', 'experience[' + count + '][address]');
            
            exp_to.val('');
            exp_to.attr('id', 'experience_' + count + '_to');
            exp_to.prev().attr('for', 'experience_' + count + '_to');
            exp_to.attr('name', 'experience[' + count + '][to]');

            exp_tm.val('');
            exp_tm.attr('id', 'experience_' + count + '_tm');
            exp_tm.prev().attr('for', 'experience_' + count + '_tm');
            exp_tm.attr('name', 'experience[' + count + '][tm]');

            experiences.append(exp);
        });
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
            })
            if(error)
                $('input[name="name"]').focus();
            else
                form[0].submit();
        });
    },
}


$(function() {
    teacher.init();
});