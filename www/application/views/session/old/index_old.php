<?php if(!empty($error)): ?>
<div class="error">
    <p><?php echo $error ?></p>
</div>
<?php endif; ?>
<form class="form-login" name="login" action="<?php echo URL::base() ?>session/index" method="POST">
    <div class="field-block">
        <label for="username"><strong>Login (user ID)</strong></label>
        <input type="text" name="username" id="username" value="<?php echo Helper_Main::getPostValue('username')?>">
    </div>
    <div class="field-block">
        <label for="password"><strong>Password</strong></label>
        <input type="password" name="password" id="password">
    </div>
    <input type="submit" value="Login">
</form>
<p><a href="<?php echo URL::base() ?>student-registration">Register for students</a></p>
<p><a href="<?php echo URL::base() ?>teacher-registration">Register for teachers</a></p>
<p><a href="<?php echo URL::base() ?>admin-registration">Register for administrators</a></p>