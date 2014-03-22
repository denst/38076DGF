<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="subject_new" action="<?php echo URL::base() ?>subjects/new" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="name"><strong>Name</strong></label>
            <input type="text" name="name" id="name" value="<?php echo Helper_Main::getPostValue('name') ?>">
        </div>
        <div class="group-field-block">
            <label for="pid"><strong>Parent Subject</strong></label>
            <select name="pid" id="pid">
                <option value="0">-</option>
                <?php $subjects = ORM::factory('subject')->where('pid', '=', 0)->find_all(); ?>
                <?php foreach($subjects as $subject): ?>
                    <option value="<?php echo $subject->id ?>" <?php echo $subject->id == Helper_Main::getPostValue('pid') ? 'selected' : '' ?>><?php echo $subject->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </fieldset>
    <input type="submit" value="Create subject">
</form>