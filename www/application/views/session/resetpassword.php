<? if(isset($error)):?>
    <div class="msg_box msg_error" id="form_a_errors" style="">
        <label for="va_email" generated="true" class="error" style="">
            <? 
               $error = str_replace('email', '<strong>email</strong>', $error);
               echo $error;
            ?>
        </label>
    </div>
<? endif;?>
<form name="resetpassword" action="<?=URL::base()?>resetpassword" method="POST" class="formEl sepH_c" id="form_login">
    <div class="sepH_a <?=(isset($error))? 'error': ''?>">
            <label for="username" class="lbl_a">Email:</label>
            <input type="text" id="lusername" name="email" class="inpt_a" 
                   value="<?=(isset($email))? $email: ''?>"/>
    </div>
    <div class="sepH_a <?=(isset($error))? 'error': ''?>">
            <label for="captcha" class="lbl_a">Captcha:</label>
            <input type="text" name="captcha" class="inpt_a" 
                   value=""/>
    </div>
    <div>
        <?php echo $captcha; ?>
    </div>
    <button class="btn_a btn" type="submit">Get new password</button>
</form>