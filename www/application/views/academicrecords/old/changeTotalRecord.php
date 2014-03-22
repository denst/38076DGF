<?php if(!empty($errors)): ?>
    <div class="error">
        <?php foreach($errors as $error): ?>
            <p><?php echo $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<h3>Override Total</h3>
<form class="form-registrate" name="academic_record_new" action="<?php echo URL::base() . 'academic-records/change-total/' . $link ?>" method="POST">
    <fieldset>
        <div class="group-field-block">
            <div>
                <label for="letter_ev"><strong>Scheme:</strong></label>
                <select name="scheme">
                    <option selected value="0">Percentage (%)</option>
                    <option value="1">Letter (A-F)</option>
                    <option value="2">Comment</option>
                </select>
            </div>
            <div class="ev" data-scheme="0">
                <label for="percentage_ev"><strong>Percentage (%):</strong></label>
                <input type="text" name="percentage_ev" id="percentage_ev" value="">
            </div>
            <div class="ev" style="display: none" data-scheme="1">
                <label for="letter_ev"><strong>Letter (A-F):</strong></label>
                <select name="letter_ev">
                    <option value="5">A</option>
                    <option value="4">B</option>
                    <option value="3">C</option>
                    <option value="2">D</option>
                    <option value="1">E</option>
                    <option value="0">F</option>
                </select>
            </div>
            <div class="ev" style="display: none" data-scheme="2">
                <label for="comment_ev"><strong>Comment:</strong></label>
                <select name="comment_ev">
                    <option value="4">Excellent</option>
                    <option value="3">Very Good</option>
                    <option value="2">Good</option>
                    <option value="1">Satisfactory</option>
                    <option value="0">Poor</option>
                </select>
            </div>
        </div>
    </fieldset>
    <input type="submit" value="Override Total">
    <input type="button" style="cursor: pointer" value="Cancel" onclick="javascript: location.href='<?php echo URL::base() ?>academic-records/list/<?php echo $student_id ?>'">
</form>