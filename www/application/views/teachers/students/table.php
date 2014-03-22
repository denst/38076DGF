<div id="tab-2">
    <div class="sepH_c">
            <table cellpadding="0" cellspacing="0" border="0" id="teacher_students_data_table" class="display">
                <thead>
                    <tr>
                        <th><div class="th_wrapp">N</div></th>
                        <th><div class="th_wrapp">Student ID (login)</div></th>
                        <th><div class="th_wrapp">Name</div></th>
                        <th><div class="th_wrapp">Academic Year</div></th>
                        <th><div class="th_wrapp">Promoting / Detaining</div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $level = '' ?>
                <?php $index = 1 ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><a href="<?=URL::base()?>teacher/students/view/<?=$student->id?>"><?php echo $student->username ?></a></td>
                        <td><?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?></td>
                        <td><?php echo $student->level_name ?></td>
                        <td>
                            <?php if(!is_null($student->students->find()->class_id)): ?>
                                <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && $user->id == $student->students->find()->class->teacher_id)): ?>
                                    <?php if(Helper_Main::getStatusForPromotion($student->students->find()->student_id)): ?>
                                        <a href="<?php echo URL::base() ?>levels/promoting-detaining/prom/<?php echo $student->students->find()->student_id ?>">Promoting</a> - 
                                    <?php endif; ?>
                                    <a href="<?php echo URL::base() ?>levels/promoting-detaining/det/<?php echo $student->students->find()->student_id ?>">Detaining</a>
                                <?php else: ?>
                                    <p>You have no rights</p>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>The student is not assigned to a class</p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <? $index++?>
                <?php endforeach; ?>
                </tbody>
            </table>
    </div>
</div>