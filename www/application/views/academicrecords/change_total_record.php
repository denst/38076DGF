<div id="tab-1" class="formEl_a">
    <fieldset>
        <legend>Override Total</legend>
        <form class="form-registrate" name="academic_record_new"
              action="<?php echo URL::base().$role.'/academicrecords/changetotal/'.$link?>" method="POST">
            <fieldset>
                <div class="group-field-block">
                    <div class="sepH_b">
                        <label for="letter_ev" class="lbl_a">Scheme:</label>
                        <select name="scheme">
                            <option selected value="0">Percentage (%)</option>
                            <option value="1">Letter (A-F)</option>
                            <option value="2">Comment</option>
                        </select>
                    </div>
                    <div class="ev sepH_b" data-scheme="0">
                        <label for="percentage_ev" class="lbl_a">Percentage (%):</label>
                        <input type="text" name="percentage_ev" class="inpt_b" id="percentage_ev" value="">
                    </div>
                    <div class="ev sepH_b" style="display: none" data-scheme="1">
                        <label for="letter_ev" class="lbl_a">Letter (A-F):</label>
                        <select name="letter_ev">
                            <option value="5">A</option>
                            <option value="4">B</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="1">E</option>
                            <option value="0">F</option>
                        </select>
                    </div>
                    <div class="ev sepH_b" style="display: none" data-scheme="2">
                        <label for="comment_ev" class="lbl_a">Comment:</label>
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
            <button type="submit" class="btn btn_dL sepH_b">Override Total</button>
        </form>
    </fieldset>
</div>