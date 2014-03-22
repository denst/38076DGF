<? if(isset($error)):?>
    <div class="msg_box msg_error" id="form_a_errors" style="">
        <label for="va_email" generated="true" class="error" style="">
            <strong>Email</strong> or <strong>Password</strong> is incorrect.
        </label>
    </div>
<? endif;?>
<form name="login" action="<?=URL::base()?>session/index" method="POST" class="formEl sepH_c" id="form_login">
    <div class="msg_box msg_error" id="allErrors" style="display:none"></div>
    <div class="sepH_a <?=(isset($error))? 'error': ''?>">
            <label for="username" class="lbl_a">Username:</label>
            <input type="text" id="lusername" name="username" class="inpt_a" />
    </div>
    <div class="sepH_b <?=(isset($error))? 'error': ''?>">
            <label for="password" class="lbl_a">Password:</label>
            <input type="password" id="lpassword" name="password" class="inpt_a" />
    </div>
    <div class="sepH_b">
            <input type="checkbox" class="inpt_c" id="remember" />
            <label for="remember" class="lbl_c">Remember me</label>
    </div>
    <button class="btn_a btn" type="submit">Login</button>
</form>
<div class="content_btm">
        <a href="<?=URL::base()?>resetpassword" class="small">Forgot your password?</a>
</div>