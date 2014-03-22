<div id="subject-block">
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
    <form class="form-registrate formEl_a" name="subject_edit" action="<?php echo URL::base() ?><?=$role?>/subjects/edit" method="POST">
        <input type="hidden" name="subject_id" value="<?=$subject->id?>" />
        <fieldset>
            <legend>Subject</legend>
            <div class="group-field-block">
                <label for="name" class="lbl_a">Name:</label>
                <input type="text" class="inpt_b" name="name" id="name" value="<?php echo $subject->name ?>">
            </div>
            <div class="group-field-block">
                <label for="pid" class="lbl_a">Parent Subject:</label>
                <select name="pid" id="pid">
                    <option value="0" <?php echo $subject->pid == 0 ? 'selected' : '' ?>>-</option>
                    <?php $subjects = ORM::factory('subject')->where('pid', '=', 0)->find_all(); ?>
                    <?php foreach($subjects as $value): ?>
                        <option value="<?php echo $value->id ?>" <?php echo $value->id == $subject->pid ? 'selected' : '' ?>><?php echo $value->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </fieldset>
        <button type="submit" class="btn btn_dL sepH_b">Edit Subject</button>
    </form>
</div>