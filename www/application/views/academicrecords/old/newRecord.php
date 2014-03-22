<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h3>Create academic record on "<?php echo $subject->pid == 0 ? $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . $subject->name ?>" for student <?php echo $student->name ?></h3>
<form class="form-registrate" name="academic_record_new" action="<?php echo URL::base() ?>academic-records/new/<?php echo $student->student_id ?>/<?php echo $subject->id ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <?php if($subject->scheme == 0) : ?>
                <label for="percentage_ev"><strong>Percentage (%):</strong></label>
                <input type="text" name="percentage_ev" id="percentage_ev" value="">
            <?php elseif($subject->scheme == 1): ?>
                <label for="letter_ev"><strong>Letter (A-F):</strong></label>
                <select name="letter_ev">
                    <option value="5">A</option>
                    <option value="4">B</option>
                    <option value="3">C</option>
                    <option value="2">D</option>
                    <option value="1">E</option>
                    <option value="0">F</option>
                </select>
            <?php else: ?>
                <label for="comment_ev"><strong>Comment:</strong></label>
                <select name="comment_ev">
                    <option value="4">Excellent</option>
                    <option value="3">Very Good</option>
                    <option value="2">Good</option>
                    <option value="1">Satisfactory</option>
                    <option value="0">Poor</option>
                </select>
            <?php endif; ?>
        </div>
        <strong><?php echo $period->name ?></strong>
        <div class="group-field-block order">
            <label><strong>Order:</strong></label>
            <select name="order">
                <?php for($i = 0; $i < $period->count; $i++): ?>
                    <?php if(Model_Record_Academic::existRecordByPeriodOrder($student, $subject_id, $period->value, $i)): ?>
                        <option value="<?php echo $i ?>"><?php echo $i + 1 ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
        </div>
    </fieldset>
    <input type="submit" value="Create record">
</form>