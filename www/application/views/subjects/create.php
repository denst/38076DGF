<div id="tab-2">
    <div id="subject-block">
        <?php if(!empty($errors)): ?>
        <div class="error">
            <?php foreach($errors as $error): ?>
                <p><?php echo $error ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <form class="form-registrate formEl_a" name="subject_new" action="<?php echo URL::base() ?><?=$role?>/subjects/create" method="POST">
            <fieldset>
                <legend>New Subject</legend>
                <div class="group-field-block">
                    <label for="name"  class="lbl_a">Name:</label>
                    <input class="inpt_b" type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ?>">
                </div>
                <div class="group-field-block">
                    <label for="pid"   class="lbl_a">Parent Subject:</label>
                    <select name="pid" id="pid">
                        <option value="0">-</option>
                        <?php $subjects = ORM::factory('subject')->where('pid', '=', 0)->find_all(); ?>
                        <?php foreach($subjects as $subject): ?>
                            <option value="<?php echo $subject->id ?>" <?php echo $subject->id == Helper_Main::getPostValue('pid') ? 'selected' : '' ?>><?php echo $subject->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </fieldset>
            <button type="submit" class="btn btn_dL sepH_b">Create Subject</button>
        </form>
    </div>
</div>