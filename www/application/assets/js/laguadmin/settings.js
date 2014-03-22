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
    setDeleteAllСlassSubject: function(){
        $('.class_all_subject_delete_button').click(function(){
            var all_subjects = '';
            $(".delete_subject").each(function(){
                if($(this).is(':checked'))
                    all_subjects = all_subjects + $(this).val() + '&&';
            });
            $("#delete_all_class_subject").val(all_subjects);
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
    settingsForm.setDeleteAllСlassSubject();
    settingsForm.setDeleteСlassStudent();
});