<div id="tab-2">
    <div class="sepH_c">
            <table cellpadding="0" cellspacing="0" border="0" id="students_data_table" class="display">
                <thead>
                    <tr>
                        <th><div class="th_wrapp">N</div></th>
                        <th><div class="th_wrapp">Student ID (login)</div></th>
                        <th><div class="th_wrapp">Name</div></th>
                        <th><div class="th_wrapp">Logins Count</div></th>
                        <th><div class="th_wrapp">Last Login</div></th>
                        <th class="hide"><div class="th_wrapp">Status</div></th>
                        <th><div class="th_wrapp">Academic Year / Class</div></th>
                        <th><div class="th_wrapp">Records</div></th>
                        <th class="hide"><div class="th_wrapp">Promoting / Detaining</div></th>
                        <th class="hide"><div class="th_wrapp">Dropout</div></th>
                        <th class="hide" style="width: 105px;"><div class="th_wrapp">Actions</div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><a href="<?=URL::base()?><?=$role?>/students/view/<?=$student->id?>"><?php echo $student->username ?></a></td>
                        <td><?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?></td>
                        <td><?php echo $student->logins ?></td>
                        <td><?php echo !empty($student->last_login) ? date('d-m-Y h:i:s A', $student->last_login) : '' ?></td>
                        <td class="hide"></td>
                        <td>
                            <? if(Valid::not_empty($student->class_name)):?>
                                <a href="<?=  URL::base()?><?=$role?>/classes/view/<?=$student->class_id?>"><?=$student->level_name.' - '.$student->class_name?></a>
                            <? else:?>
                                <?php echo $student->level_name ?>
                            <? endif?>
                        </td>
                        <td style="width: 90px;">
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/academicrecords/list/<?php echo $student->students->find()->student_id ?>">Academic</a>
                        </td>
                        <td class="hide"></td>
                        <td class="hide"></td>
                        <td class="hide"></td>
                    </tr>
                    <? $index++?>
                <?php endforeach; ?>
                </tbody>
            </table>
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