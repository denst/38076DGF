settingsForm = {
    setDeleteLevelId: function(){
        $('.level_delete_button').click(function(){
            $("#delete_level_id").val($(this).val());
        });
    },
    setDeleteSubjectId: function(){
        $('.subject_delete_button').click(function(){
            $("#delete_subject_id").val($(this).val());
        });
    },
    setDeleteСlassSubject: function(){
        $('.class_subject_delete_button').click(function(){
            $("#delete_class_subject").val($(this).val());
        });
    },
    setDeleteСlassStudent: function(){
        $('.class_student_delete_button').click(function(){
            $("#delete_class_student").val($(this).val());
        });
    },
}

$(function(){
    settingsForm.setDeleteLevelId();
    settingsForm.setDeleteSubjectId();
    settingsForm.setDeleteСlassSubject();
    settingsForm.setDeleteСlassStudent();
});