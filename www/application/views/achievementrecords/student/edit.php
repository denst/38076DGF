<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<form class="form-registrate" name="achievement_student_record_edit" action="<?php echo URL::base() ?>achievement-student-records/edit/<?php echo $record->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="date"><strong>Date: </strong></label>
            <input name="date" id="date" value="<?php echo Helper_Main::getPostValue('date') ? date('Y-m-d', Helper_Main::getPostValue('date')) : date('Y-m-d', $record->date) ?>">
        </div>
        <div class="group-field-block">
            <label for="achievement"><strong>Achievement: </strong></label>
            <br>
            <textarea name="achievement" id="achievement"><?php echo Helper_Main::getPostValue('achievement') ? Helper_Main::getPostValue('achievement') : $record->achievement ?></textarea>
        </div>
        <?php if(Helper_User::getUserRole($user) == 'sadmin' OR $role == 'admin'): ?>
            <div class="group-field-block">
                <label for="notes"><strong>Notes: </strong></label>
                <br>
                <textarea name="notes" id="notes"><?php echo Helper_Main::getPostValue('notes') ? Helper_Main::getPostValue('notes') : $record->notes ?></textarea>
            </div>
        <?php endif; ?>
    </fieldset>
    <input type="submit" value="Edit record">
</form>