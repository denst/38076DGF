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
                        <th><div class="th_wrapp">Status</div></th>
                        <th><div class="th_wrapp">Academic Year / Class</div></th>
                        <th><div class="th_wrapp">Records</div></th>
                        <th><div class="th_wrapp">Promoting / Detaining</div></th>
                        <th><div class="th_wrapp">Dropout</div></th>
                        <th style="width: 105px;"><div class="th_wrapp">Actions</div></th>
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
                        <td><?php echo $student->status == 1 ? 'Approved Student' : 'Pending Review'?></td>
                        <td>
                            <? if(Valid::not_empty($student->class_name)):?>
                                <a href="<?=  URL::base()?><?=$role?>/classes/view/<?=$student->class_id?>"><?=$student->level_name.' - '.$student->class_name?></a>
                            <? else:?>
                                <?php echo $student->level_name ?>
                            <? endif?>
                        </td>
                        <td style="width: 90px;">
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/academicrecords/list/<?php echo $student->students->find()->student_id ?>">Academic</a>
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/achievementstudents/list/<?php echo $student->students->find()->student_id ?>">Achievement</a>
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/disciplinarystudents/list/<?php echo $student->students->find()->student_id ?>">Disciplinary</a>
                            <?php if(Helper_User::getUserRole($user) != 'teacher'): ?>
                                 <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/financialrecords/list/<?php echo $student->students->find()->student_id ?>">Financial</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!is_null($student->students->find()->class_id)): ?>
                                <?php if(Helper_Main::getStatusForPromotion($student->students->find()->student_id)): ?>
                                    <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/levels/promotingdetaining/prom&<?php echo $student->students->find()->student_id ?>">Promoting</a>
                                <?php endif; ?>
                                <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/levels/promotingdetaining/det&<?php echo $student->students->find()->student_id ?>">Detaining</a>
                            <?php else: ?>
                                <p>The student is not assigned to a class</p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?=URL::base() ?><?=$role?>/students/changedropout" method="post">
                                <input type="hidden" name="student_id" 
                                       value="<?=$student->students->find()->student_id?>">
                                <input type="hidden" name="dropout" value="1">
                                <button class="btn btn_bS tb">Dropout</button>
                            </form>
                        </td>
                        <td>
                            <div id="actions">
                            <?php if(($role == 'sadmin' OR $role == 'admin') AND $student->status == 0): ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/students/approve/<?php echo $student->id ?>" class="sepV_a" title="Approve">
                                    <button class="action-button">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/preview_gray.png" alt="" />
                                    </button>
                                </a>
                            <?php endif; ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/students/edit/<?php echo $student->id ?>" class="sepV_a" title="Edit">
                                    <button class="action-button">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                                    </button>
                                </a>
                                <button name="delete" value="<?=$student->id?>" data-toggle="modal" href="#deleteStudentModal" 
                                    class="action-button student_delete_button">
                                <a href="#" title="Delete">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png" alt="" />
                                </a>
                            </button>
                            </div>
                        </td>
                    </tr>
                    <? $index++?>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
    <div>
        <a href="<?=URL::base()?>sadmin/students/create" class="btn btn_dL sepH_b>">Create Student</a>
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