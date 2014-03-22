<!-- Quarters -->
<fieldset>
    <legend>
        <? if($role != 'student'):?>
        
            <? if(isset($class_name)):?>
                <a href="<?=URL::base().$role?>/classes/view/<?=$class_id?>">
                    <?=$class_name?>
                </a>
            <? else:?>

                <? if(Valid::not_empty($student->class->id)):?>
                    <a href="<?=URL::base().$role?>/classes/view/<?=$student->class->id?>">
                        <?php echo $student->class->level->name .' - '. $student->class->name ?>
                    </a>
                <? else:?>
                    No current class
                <? endif?>
                    
            <? endif;?>
        <? else:?>
            <?php echo $student->class->level->name .' - '. $student->class->name ?>
        <? endif?>
    </legend>

    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
                <th><div class="th_wrapp">Period</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">1st Quarter Result</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">2st Quarter Result</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">3st Quarter Result</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">4st Quarter Result</div></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tab-title">Each Quarte</td>
                <td class="each_quarte" <?=($role == 'sadmin' OR $role == 'admin')? 
                    'colspan="2"': ''?>><?=$level_annual?></td>
                <td class="each_quarte" <?=($role == 'sadmin' OR $role == 'admin')?
                    'colspan="2"': ''?>><?=$level_annual?></td>
                <td class="each_quarte" <?=($role == 'sadmin' OR $role == 'admin')?
                    'colspan="2"': ''?>><?=$level_annual?></td>
                <td class="each_quarte" <?=($role == 'sadmin' OR $role == 'admin')?
                    'colspan="2"': ''?>><?=$level_annual?></td>
            </tr>
            <tr>
                <td class="tab-title">Status</td>
                <?php for($i = 1; $i <= 4; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <td><?php echo $paid ?></td>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <td style="width: 75px;">
                        <form class="payment_form" action="<?php echo URL::base()?><?=$role?>/financialrecords/payment" method="POST">
                        <div>
                            Finished Payment 
                        </div>
                            <input type="hidden" name="student_id" value="<?=$student->student_id?>">
                            <input type="hidden" name="period" value="<?=$period ?>">
                            <input type="hidden" name="order" value="<?=$i?>">
                            <input type="hidden" name="year" value="<?=$year?>">
                            <input type="hidden" name="year" value="<?=$year?>">
                            <input class="amount_payment" type="hidden" name="amount_payment" value="<?=$level_annual?>">
                            <input type="hidden" class="payment_scholarship" name="schoralship" value="">
                            <button type="submit" name="paid" value="1">Yes</button>
                            <button type="submit" name="paid" value="0">No</button>
                        </form>
                    </td>
                    <? endif?>
                <?php endfor; ?>
            </tr>
            <tr>
                <td class="tab-title">Early Repayment</td>
                <td id="early_repayment" colspan="8"><?=$early_repayment?></td>
            </tr>
        <tbody>
    </table>
</fieldset>
<!--End Quarters -->        
