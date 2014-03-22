<? if(isset($error)):?>
    <div class="msg_box msg_error" id="form_a_errors" style="">
        <label for="va_email" generated="true" class="error" style="">
            <? 
               $error = str_replace('password', '<strong>password</strong>', $error);
               $error = str_replace('confirm password', '<strong>confirm password</strong>', $error);
               echo $error;
            ?>
        </label>
    </div>
<? endif;?>
<form name="resetpassword" action="<?=URL::base()?>resetpassword/setnewpassword" method="POST" class="formEl sepH_c" id="form_login">
    <input type="hidden" name="user_id" value="<?=(isset($user_id))? $user_id: ''?>">
    <div class="sepH_a <?=(isset($error))? 'error': ''?>">
            <label for="password" class="lbl_a">New Password:</label>
            <input type="password" id="lusername" name="password" class="inpt_a" />
    </div>
    <div class="sepH_a <?=(isset($error))? 'error': ''?>">
            <label for="confirm_password" class="lbl_a">Confirm Password:</label>
            <input type="password" id="lusername" name="confirm_password" class="inpt_a" />
    </div>
    <button class="btn_a btn" type="submit">Save</button>
</form>