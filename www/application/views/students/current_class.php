    <div id="tab-2">
    <div class="sepH_c formEl_a">
        <fieldset>
            <? if(Valid::not_empty($class_name)):?>
                <legend><a href="<?=URL::base().$role?>/classes/view/<?=$class_id?>"><?=($class_name)? $class_name: ''?></a></legend>
                <? if(Valid::not_empty($students)):?>
                <table cellpadding="0" cellspacing="0" border="0" id="current_class_data_table" class="display">
                    <thead>
                        <tr>
                            <th><div class="th_wrapp">N</div></th>
                            <th><div class="th_wrapp">Student ID (login)</div></th>
                            <th><div class="th_wrapp">Name</div></th>
                            <th><div class="th_wrapp">Logins Count</div></th>
                            <th><div class="th_wrapp">Last Login</div></th>
                            <th><div class="th_wrapp">Records</div></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $index = 1 ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $index ?></td>
                            <td><a href="<?=URL::base()?><?=$role?>/students/view/<?=$student->student_id?>"><?php echo $student->user->username ?></a></td>
                            <td><?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?></td>
                            <td><?php echo $student->user->logins ?></td>
                            <td><?php echo !empty($student->user->last_login) ? date('d-m-Y h:i:s A', $student->user->last_login) : '' ?></td>
                            <td style="width: 90px;">
                                <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/academicrecords/list/<?php echo $student->student_id ?>">Academic</a>
                                <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/achievementstudents/list/<?php echo $student->student_id ?>">Achievement</a>
                                <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/disciplinarystudents/list/<?php echo $student->student_id ?>">Disciplinary</a>
                                <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/financialrecords/list/<?php echo $student->student_id ?>">Financial</a>
                            </td>
                        </tr>
                        <? $index++?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <? else:?>
                    <p>No students for current class</p>
                <? endif?>
            <? else:?>
                <p>You don't have a current class</p>
            <? endif?>
        </fieldset>
    </div>
</div>
<div style="display: none;" class="modal hide" id="deleteStudentModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/students/delete" method="post">
            <input id="delete_student_id" type="hidden" name="student_id" value="" />
            <p class="sepH_b">Are you sure you want to delete student?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>