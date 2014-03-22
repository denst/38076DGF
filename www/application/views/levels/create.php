<div id="tab-2">
    <div id="level-block">
        <?php if(!empty($errors)): ?>
            <div class="error">
                <?php foreach($errors as $error): ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form class="form-registrate formEl_a" name="level_new" action="<?php echo URL::base() ?><?=$role?>/levels/create" method="POST">
            <input type="hidden" name="year" value="<?=$year?>" />
            <fieldset>
                <legend>New Level</legend>
                <div class="sepH_b">
                    <label for="name" class="lbl_a">Name:</label>
                    <input type="text" id="name" name="name" class="inpt_b" />
                </div>
            </fieldset>
            <fieldset>
                <legend>Classes</legend>
                <div class="classes">
                    <div class="group-field-block class block-class" style="display: none">
                        <label for="va_text" class="lbl_a">Name of class:</label>
                        <select name="class">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                        </select>
                        <a href="#" class="hide-cls"><img class="delete-button" src="<?php echo URL::base() ?>laguadmin/images/icons/trashcan_gray.png"></a>
                    </div>
                </div>
                <a href="#" id="more-cls"><img src="<?php echo URL::base() ?>laguadmin/images/icons/add.png"></a>
            </fieldset>
            <button class="btn btn_dL sepH_b">Create Level</button>
        </form>
    </div>
</div>
