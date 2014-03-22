records = {
    setDeleteAchievementId: function(){
        $('.achievement_delete_button').click(function(){
            $("#delete_achievement").val($(this).val());
        });
    },
    setDeleteDisciplinaryId: function(){
        $('.disciplinary_delete_button').click(function(){
            $("#delete_disciplinary").val($(this).val());
        });
    },
    setDeleteAcademicId: function(){
        $('.academic_delete_button').click(function(){
            var record_id = $(this).children('input:hidden').val();
            $("#delete_academic").val($(this).val() + '&' + record_id);
        });
    },
}

$(function(){
    records.setDeleteAchievementId();
    records.setDeleteDisciplinaryId();
    records.setDeleteAcademicId();
});