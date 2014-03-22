<?php if(!empty($success)): ?>
    <div class="success">
        <p><?php echo $success ?></p>
    </div>
<?php endif; ?>
<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="level_edit" action="<?php echo URL::base() ?>levels/edit/<?php echo $level->id ?>/<?php echo $year ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="name"><strong>Name</strong></label>
            <input type="text" name="name" id="name" <?php echo Helper_User::getUserRole($user) != 'sadmin' ? 'disabled' : ''?> value="<?php echo $level->name ?>">
        </div>
        <div class="group-field-block">
            <label for="order"><strong>Order</strong></label>
            <select type="text" name="order" id="order" <?php echo Helper_User::getUserRole($user) != 'sadmin' ? 'disabled' : ''?>>
                <?php for($i = 1; $i <= ORM::factory('level')->count_all(); $i++): ?>
                    <option <?php echo $level->order == $i ? 'selected' : ''?> value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </fieldset>
    <fieldset>
        <legend>“Classes”</legend>
        <?php if(count($classes) > 0): ?>
            <?php foreach($classes as $class): ?>
                <div class="group-field-block">
                    <label for="name"><strong>Name “class”</strong></label>
                    <select name="old_classes[<?php echo $class->id ?>]">
                        <option <?php echo $class->name == 'A' ? 'selected' : ''?> value="A">A</option>
                        <option <?php echo $class->name == 'B' ? 'selected' : ''?> value="B">B</option>
                        <option <?php echo $class->name == 'C' ? 'selected' : ''?> value="C">C</option>
                        <option <?php echo $class->name == 'D' ? 'selected' : ''?> value="D">D</option>
                        <option <?php echo $class->name == 'E' ? 'selected' : ''?> value="E">E</option>
                        <option <?php echo $class->name == 'F' ? 'selected' : ''?> value="F">F</option>
                    </select>
                    <a href="#" class="remove-cls"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
    <fieldset style="margin-top: 10px; margin-bottom: 20px">
        <legend>Finance</legend>
        <div class="group-field-block">
            <label for="annual"><strong>Annual</strong></label>
            <input name="annual" id="annual" value="<?php echo $level->annual != 0 ? $level->annual : '' ?>">
        </div>
        <div class="group-field-block">
            <label for="early_repayment"><strong>Early Repayment Discount (%)</strong></label>
            <input name="early_repayment" id="early_repayment" value="<?php echo $level->early_repayment != 0 ? $level->early_repayment : '' ?>">
        </div>
        <?php if($level->annual != 0): ?>
            <div>
                Early Repayment = 
                <strong><?php echo $level->early_repayment == 0 ? $level->annual : $level->annual - ($level->annual * $level->early_repayment / 100) ?></strong>
            </div>
            <div>
                <?php $academic_period = Helper_Main::getObjectPeriod(ORM::factory('setting', 'academic_period')->value) ?>
                Each <?php echo $academic_period->name ?> = <strong><?php echo round($level->annual / $academic_period->count, 2) ?></strong>
            </div>
        <?php endif; ?>
    </fieldset>
    <input type="submit" value="Edit level">
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>levels/list/<?php echo $year ?>'">
</form>