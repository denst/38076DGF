<!-- Terms -->
<fieldset>
<legend>Terms</legend>

    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">1st Term Result</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">2st Term Result</div></th>
                <th <?=($role == 'sadmin' OR $role == 'admin')? 'colspan="2"': '' ?>><div class="th_wrapp">3st Term Result</div></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php for($i = 1; $i <= 3; $i++): ?>
                   <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                   <td><?php echo $paid ?></td>
                   <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <td>Finished Payment (<a href="<?php echo URL::base() ?><?=$role?>/financialrecords/paid/<?php echo $student->student_id . '&' . $period . '&' . $i . '&' . $year . '&1' ?>">Yes</a>/
                            <a href="<?php echo URL::base() ?><?=$role?>/financialrecords/paid/<?php echo $student->student_id . '&' . $period . '&' . $i . '&' . $year . '&0' ?>">No</a>)
                        </td>
                   <?php endif; ?>
               <?php endfor; ?>
            </tr>
        <tbody>
    </table>

</fieldset>
<!--End Terms -->       
