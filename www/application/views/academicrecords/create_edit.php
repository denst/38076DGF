<div id="tab-2">
    <div id="user-block" class="formEl_a">
        <? if(isset($edit)):?> 
            <form name="edit" class="formEl_a" action="<?php echo URL::base() ?><?=$role?>/achievementrecords/edit" method="POST">
        <? else:?>
            <form class="form-registrate" name="academic_record_new" 
                action="<?=URL::base()?><?=$role?>/academicrecords/create/<?=$student->student_id?>&<?=$subject->id?>" method="POST">
        <? endif;?>
            <fieldset>
                <legend>
                    Create academic record on "<?php echo $subject->pid == 0 ?
                    $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . 
                    $subject->name ?>" for student 
                    <?php echo $student->name ?>
                </legend>
                    <input type="hidden" name="student_id" value="<?=$student->student_id?>" />
                    <input type="hidden" name="subject_id" value="<?=$subject->subject_id?>" />
                    <div class="sepH_b <?=(isset($error))? 'error': ''?>">
                    <?php if($subject->scheme == 0) : ?>
                        <label for="percentage_ev" class="lbl_a">Percentage (%):</label>
                        <input type="text" name="percentage_ev" id="percentage_ev" class="inpt_b" value="">
                    <?php elseif($subject->scheme == 1): ?>
                        <label for="letter_ev" class="lbl_a">Letter (A-F):</label>
                        <select name="letter_ev">
                            <option value="5">A</option>
                            <option value="4">B</option>
                            <option value="3">C</option>
                            <option value="2">D</option>
                            <option value="1">E</option>
                            <option value="0">F</option>
                        </select>
                    <?php else: ?>
                        <label for="comment_ev" class="lbl_a">Comment:</label>
                        <select name="comment_ev">
                            <option value="4">Excellent</option>
                            <option value="3">Very Good</option>
                            <option value="2">Good</option>
                            <option value="1">Satisfactory</option>
                            <option value="0">Poor</option>
                        </select>
                    <?php endif; ?>
                </div>
                    
                <fieldset>
                    <legend><?php echo $student->class->level->name .' - '. $student->class->name ?></legend>
                    <div class="sepH_b">
                    <label for="percentage_ev" class="lbl_a">Order:</label>
                    <select name="order">
                        <?php for($i = 1; $i <= $period->count; $i++): ?>
                            <?php if(Model_Record_Academic::existRecordByPeriodOrder($student, $subject_id, $period->value, $i)): ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </select>
                    </div>
                </fieldset>
                
            </fieldset>
            <? if(isset($edit)):?>
                <button type="submit" name="edit" class="btn btn_dL sepH_b">Edit record</button>
            <? else:?>
                <button type="submit" class="btn btn_dL sepH_b">Create record</button>
            <? endif;?>
        </form>
    </div>
</div>