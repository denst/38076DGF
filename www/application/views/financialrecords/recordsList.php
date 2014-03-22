<div id="user-block">
    <div class="formEl_a">
        <fieldset>
        <legend>Financial Records</legend>
        <h3><a href="<?=URL::base().$role?>/students/view/<?=$student->student_id?>"><?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</a></h3>
        <br/>
        
        <div class="sepH_b">
            <label for="name" class="lbl_a">Year:</label>
            <? if($role == 'sadmin' OR $role == 'admin'):?>
                <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/financialrecords/list/<?php echo $student->student_id ?>">
            <? else:?>
                <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/financialrecords/list/<?php echo $student->student_id ?>">
            <? endif?>
                <select name="year" id="year">
                    <?php for($i = $student->start_year; $i <= $student->end_year; $i++): ?>
                        <option <?php echo $i == $year ? 'selected' : '' ?> 
                            value="<?php echo $i ?>">
                                <?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>
        <div class="sepH_b">
            
            <label for="name" class="lbl_a label_scholarship">Scholarship:</label>
            <? if($role == 'sadmin' OR $role == 'admin'):?>
                <input type="hidden" id="full_level_annual" value="<?=$full_level_annual?>">
                <input type="hidden" id="period_count" value="<?=$period_count?>">
                <input type="hidden" id="percent_early_repayment" value="<?=$percent_early_repayment?>">
                <input type="checkbox" id="scholarship" 
                    <?=(isset($scholarship))? 'checked': ''?>>
            <? endif?>
            <select style="display: <?=(isset($scholarship)? 'inline;': 'none;')?>" name="scholarship_percent" id="scholarship_percent"
                <?=($role == 'sadmin' OR $role == 'admin')? '': 'disabled'?>>
                <? for($i = 1; $i <= 100; $i++):?>
                <option value="<?=$i?>" <?=(isset($scholarship) AND $scholarship == $i)?
                        'selected': ''?>><?=$i.'%'?></option>
                <? endfor?>
            </select>
        </div>
        
        <?if(isset($table))
            echo $table;
        ?>

        
        <? if($role == 'sadmin' OR $role == 'admin'):?>
            <form id="finish_payment" action="<?php echo URL::base() ?><?=$role?>/financialrecords/finishpayment" style="margin-top: 20px" method="POST">
                <div class="group-field-block">
                    <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
                    <input type="hidden" name="year" value="<?php echo $year ?>">
                    <input id="submit_early_repayment" type="hidden" name="early_repaymen" value="<?=$early_repayment?>">
                    <input type="hidden" class="payment_scholarship" name="scholarship" value="">
                    <button type="submit" class="btn btn_dL sepH_b"
                            <?php echo Model_Record_Financial::getStatusPaidForYear($student->student_id, $period, $year) ?
                                'disabled' : '' ?>>Paid for the year</button>

                </div>
            </form>
        <? endif?>
        
        <fieldset>
            <?php // if($scholarship == 1): ?>
                <!--<p><strong>The student receives a scholarship</strong></p>-->
            <?php if(!empty($accounting)): ?>
                <p>1) <strong><?php echo $not_paid_count == 0 ? 'No outstanding Fees' : $not_paid_count * $annual_period . ' outstanding Fees'?></strong></p>
                <br>
                <p>2) <strong><?php echo $paid_count == 0 ? 'No Paid' : $paid_count * $annual_period . ' Paid'?></strong></p>
            <?php endif; ?>
        </fieldset>
        
        </fieldset>
    </div>
</div>