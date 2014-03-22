<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<p><strong>You should change your password</strong></p>
<form action="<?php echo URL::base() ?>change-password" name="change_password" id="change-password" method="POST">
    <input type="hidden" name="change_password" value="0">
    <div class="group-field-block">
        <label for="password">Your new password</label>
        <input type="password" name="password" id="password">
    </div>
    <div class="group-field-block">
        <label for="password_confirm">Confirm your new password</label>
        <input type="password" name="password_confirm" id="password_confirm">
    </div>
    <input type="submit" value="Change password">
</form>