<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h3>Create disciplinary record student <?php echo $teacher->user->username ?> (<?php echo $teacher->name ?> <?php echo $teacher->fathername ?> <?php echo $teacher->grfathername ?>)</h3>
<form class="form-registrate" name="disciplinary_teacher_record_new" action="<?php echo URL::base() ?>disciplinary-teacher-records/new/<?php echo $teacher->teacher_id ?>" method="POST">
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
        <div class="group-field-block">
            <label for="notes"><strong>Notes: </strong></label>
            <br>
            <textarea name="notes" id="notes"><?php echo Helper_Main::getPostValue('notes') ?></textarea>
        </div>
        <div class="group-field-block">
            <label for="action"><strong>Action: </strong></label>
            <br>
            <textarea name="action" id="action"><?php echo Helper_Main::getPostValue('action') ?></textarea>
        </div>
    </fieldset>
    <input type="submit" value="Create record">
</form>