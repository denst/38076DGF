<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="level_new" action="<?php echo URL::base() ?>levels/new/<?php echo $year ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="name"><strong>Name</strong></label>
            <input type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ?>">
        </div>
    </fieldset>
    <fieldset>
        <legend>“Classes”</legend>
        <div class="classes">
            <div class="group-field-block class" style="display: none">
                <label for="name"><strong>Name “class”</strong></label>
                <select name="class">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                </select>
                <a href="#" class="hide-cls"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
            </div>
        </div>
        <a href="#" id="more-cls"><img src="<?php echo URL::base() ?>img/add_icon.png"></a>
    </fieldset>
    <input type="submit" value="Create level">
</form>