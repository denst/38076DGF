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
<form class="form-registrate" name="subject_edit" action="<?php echo URL::base() ?>subjects/edit/<?php echo $subject->id ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="name"><strong>Name</strong></label>
            <input type="text" name="name" id="name" value="<?php echo $subject->name ?>">
        </div>
        <div class="group-field-block">
            <label for="pid"><strong>Parent Subject</strong></label>
            <select name="pid" id="pid">
                <option value="0" <?php echo $subject->pid == 0 ? 'selected' : '' ?>>-</option>
                <?php $subjects = ORM::factory('subject')->where('pid', '=', 0)->find_all(); ?>
                <?php foreach($subjects as $value): ?>
                    <option value="<?php echo $value->id ?>" <?php echo $value->id == $subject->pid ? 'selected' : '' ?>><?php echo $value->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </fieldset>
    <input type="submit" value="Edit subject">
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>subjects/list'">
</form>