<div id="level-block">
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
    <form class="form-registrate formEl_a" name="level_edit" action="<?php echo URL::base() ?><?=$role?>/levels/edit/" method="POST">
        <input type="hidden" name="level_id" value="<?=$level->id?>"/>
        <input type="hidden" name="year" value="<?=$year?>"/>
        <fieldset>
            <legend>Level</legend>
            <div class="sepH_b">
                <label for="va_text" class="lbl_a">Name:</label>
                <input type="text" name="name" id="name" class="inpt_b" <?php echo Helper_User::getUserRole($user) != 'sadmin' ? 'disabled' : ''?> value="<?php echo $level->name ?>">
            </div>
            <div class="group-field-block">
                <label for="va_text" class="lbl_a">Order:</label>
                <select type="text" name="order" id="order" <?php echo Helper_User::getUserRole($user) != 'sadmin' ? 'disabled' : ''?>>
                    <?php for($i = 1; $i <= ORM::factory('level')->count_all(); $i++): ?>
                        <option <?php echo $level->order == $i ? 'selected' : ''?> value="<?php echo $i ?>"><?php echo $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </fieldset>
        <fieldset>
            <legend>Classes</legend>
            <?php if(count($classes) > 0): ?>
                <?php foreach($classes as $class): ?>
                    <div class="group-field-block block-class">
                        <label for="va_text" class="lbl_a">Name of class:</label>
                        <select name="old_classes[<?php echo $class->id ?>]">
                            <option <?php echo $class->name == 'A' ? 'selected' : ''?> value="A">A</option>
                            <option <?php echo $class->name == 'B' ? 'selected' : ''?> value="B">B</option>
                            <option <?php echo $class->name == 'C' ? 'selected' : ''?> value="C">C</option>
                            <option <?php echo $class->name == 'D' ? 'selected' : ''?> value="D">D</option>
                            <option <?php echo $class->name == 'E' ? 'selected' : ''?> value="E">E</option>
                            <option <?php echo $class->name == 'F' ? 'selected' : ''?> value="F">F</option>
                        </select>
                        <a href="#" class="remove-cls"><img class="delete-button" src="<?php echo URL::base() ?>laguadmin/images/icons/trashcan_gray.png"></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="classes">
                <div class="group-field-block class block-class" style="display: none">
                    <label for="class" class="lbl_a">Name of class:</label>
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
        <fieldset id="finace" style="margin-top: 10px; margin-bottom: 20px">
            <legend>Finance</legend>
            <div class="group-field-block">
                <label  for="annual" class="lbl_a">Annual:</label>
                <input name="annual" id="annual"  class="inpt_b" value="<?php echo $level->annual != 0 ? $level->annual : '' ?>">
            </div>
            <div class="group-field-block">
                <label for="early_repayment"  class="lbl_a">Early Repayment Discount (%):</label>
                <input name="early_repayment" class="inpt_b" id="early_repayment" value="<?php echo $level->early_repayment != 0 ? $level->early_repayment : '' ?>">
            </div>
            <?php if($level->annual != 0): ?>
                <div id="each">
                    <div>
                        <label class="lbl_a">Early Repayment = </label>
                            <strong><?php echo $level->early_repayment == 0 ? $level->annual : $level->annual - ($level->annual * $level->early_repayment / 100) ?></strong>
                        
                    </div>
                    <div>
                        <?php $academic_period = Helper_Main::getObjectPeriod(ORM::factory('setting', 'academic_period')->value) ?>
                        <label class="lbl_a">Each <?php echo $academic_period->name ?> =                         </label>

                            <strong><?php echo round($level->annual / $academic_period->count, 2) ?>
                            </strong>
                    </div>
                </div>
            <?php endif; ?>
        </fieldset>
        <button type="submit" class="btn btn_dL sepH_b">Edit Level</button>
    </form>
</div>