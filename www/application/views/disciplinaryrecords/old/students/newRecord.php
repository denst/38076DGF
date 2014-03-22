<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h3>Create disciplinary record student <?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</h3>
<form class="form-registrate" name="disciplinary_record_new" action="<?php echo URL::base() ?>disciplinary-records/new/<?php echo $student->student_id ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <label for="date"><strong>Date: </strong></label>
            <input name="date" id="date" value="<?php echo Helper_Main::getPostValue('date') ? date('Y-m-d', Helper_Main::getPostValue('date')) : date('Y-m-d') ?>">
        </div>
        <div class="group-field-block">
            <label for="record"><strong>Record: </strong></label>
            <br>
            <textarea name="record" id="record"><?php echo Helper_Main::getPostValue('record') ?></textarea>
        </div>
        <?php if(Helper_User::getUserRole($user) == 'sadmin'): ?>
            <div class="group-field-block">
                <label for="notes"><strong>Notes: </strong></label>
                <br>
                <textarea name="notes" id="notes"><?php echo Helper_Main::getPostValue('notes') ?></textarea>
            </div>
        <?php endif; ?>
        <div class="group-field-block">
            <label for="action"><strong>Action: </strong></label>
            <br>
            <textarea name="action" id="action"><?php echo Helper_Main::getPostValue('action') ?></textarea>
        </div>
    </fieldset>
    <input type="submit" value="Create record">
</form>