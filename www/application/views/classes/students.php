<fieldset>
    <legend>Students</legend>
        <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table_a smpl_tbl">
        <thead>
            <tr>
                <th><div class="th_wrapp">N</div></th>
                <th><div class="th_wrapp">ID</div></th>
                <th><div class="th_wrapp">Name</div></th>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <th><div class="th_wrapp">Records</div></th>
                    <th style="width: 95px;"><div class="th_wrapp">Records</div></th>
                    <th><div class="th_wrapp">Promoting / Detaining</div></th>
                    <th><div class="th_wrapp">Actions</div></th>
                <? endif?>

            </tr>
        </thead>
        <tbody>
        <? $index = 1;?>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?=$index?></td>
                <td style="font-weight: normal">
                    <a href="<?=URL::base()?><?=$role?>/students/view/<?=$student->user->id?>"><?php echo $student->user->username ?></a>
                </td>
                <td style="font-weight: normal">
                    <?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>
                </td>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                <td>
                    <form name="move_student" action="<?php echo URL::base() ?><?=$role?>/classes/movestudent" method="POST">
                        <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
                        <input type="hidden" name="class_id" value="<?php echo $student->class_id ?>">
                        <span style="font-weight: normal"> <?php echo $level->name ?></span>
                        <select name="class">
                            <?php foreach($all_class as $cls): ?>
                                <option <?php echo $cls->id == $student->class_id ? 'selected' : '' ?> value="<?php echo $cls->id ?>"><?php echo $cls->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn_dS">Move student</button>
                    </form>
                </td>
                <td>
                    <a href="<?php echo URL::base() ?><?=$role?>/academicrecords/list/<?php echo $student->student_id ?>">Academic</a> - 
                    <a href="<?php echo URL::base() ?><?=$role?>/achievementstudents/list/<?php echo $student->student_id ?>">Achievement</a> - 
                    <a href="<?php echo URL::base() ?><?=$role?>/disciplinarystudents/list/<?php echo $student->student_id ?>">Disciplinary</a> -
                    <?php if(Helper_User::getUserRole($user) != 'teacher'): ?>
                        <a href="<?php echo URL::base() ?><?=$role?>/financialrecords/list/<?php echo $student->student_id ?>">Financial</a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if(Helper_Main::getStatusForPromotion($student->student_id)): ?>
                        <a href="<?php echo URL::base() ?><?=$role?>/levels/promotingdetaining/prom&<?php echo $student->student_id ?>">Promoting</a> - 
                    <?php endif; ?>
                    <a href="<?php echo URL::base() ?><?=$role?>/levels/promotingdetaining/det&<?php echo $student->student_id ?>">Detaining</a>
                </td>
                <td>
                    <div id="actions">
                        <button name="delete" value="<?=$student->student_id .'&'.$class->id?>" data-toggle="modal" href="#deleteClassStudentModal" 
                                class="action-button class_student_delete_button">
                            <a href="#" title="delete">
                                <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png"></a>
                        </button>  
                    </div>
                </td>
                <? endif?>
            </tr>
            <? $index++;?>
        <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>
<div style="display: none;" class="modal hide" id="deleteClassStudentModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/classes/deletestudent" method="post">
            <input id="delete_class_student" type="hidden" name="class_student" value="" />
            <p class="sepH_b">Are you sure you want to delete subject?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>