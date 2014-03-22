<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h3>Create achievement record student <?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</h3>
<form class="form-registrate" name="achievement_record_new" action="<?php echo URL::base() ?>achievement-records/new/<?php echo $student->student_id ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="date"><strong>Date: </strong></label>
            <input name="date" id="date" value="<?php echo Helper_Main::getPostValue('date') ? date('Y-m-d', Helper_Main::getPostValue('date')) : date('Y-m-d') ?>">
        </div>
        <div class="group-field-block">
            <label for="achievement"><strong>Achievement: </strong></label>
            <br>
            <textarea name="achievement" id="achievement"><?php echo Helper_Main::getPostValue('achievement') ?></textarea>
        </div>
        <?php if(Helper_User::getUserRole($user) == 'sadmin'  OR $role == 'admin'): ?>
            <div class="group-field-block">
                <label for="notes"><strong>Notes: </strong></label>
                <br>
                <textarea name="notes" id="notes"><?php echo Helper_Main::getPostValue('notes') ?></textarea>
            </div>
        <?php endif; ?>
    </fieldset>
    <input type="submit" value="Create record">
</form>