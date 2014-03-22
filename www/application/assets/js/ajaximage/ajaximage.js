head.js(
    "/js/ajaximage/jquery.form.js",
    function() {
        ajaxImage.load();
    }
);
ajaxImage = {
    load: function() {
        $('#photoimg').live('change', function() {
            $("#block-loader").html('<img id="loader" alt="Uploading...." src="/img/loader.gif" />');
            ajaxImage.blockedButton();
            $("#imageform").ajaxForm(
            {
                success: function(data){
                    ajaxImage.unblockedButton();
                    if(data === "")
                        $("#block-loader").html("file can't be loaded");
                    else
                    {
                        $("#block-loader").html("");
                        $('#img-polaroid').attr('src', data);
                        $('#image_path').val(data);
                    }
                }, 
            }).submit();
        });
    },
    
    blockedButton: function() {
        $("#submit_button").attr('disabled','disabled');
        $("#submit_button").removeClass('btn_dL');
        $("#submit_button").addClass('btn_bL');
    },
            
    unblockedButton: function() {
        $("#submit_button").removeAttr('disabled');
        $("#submit_button").removeClass('btn_bL');
        $("#submit_button").addClass('btn_dL');
    },
}