<?php if(count($students) > 0): ?>
<table class="table table-condensed">
        <thead>
                <tr>
                        <th>Student ID (login)</th>
                        <th>Name</th>
                        <th>Logins Count</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th>Academic Year</th>
                        <th style="width: 10%">Records</th>
                        <th>Promoting/Detaining</th>
                        <th style="width: 20%">Actions</th>
                </tr>
        </thead>
        <tbody>
        <?php $level = '' ?>
        <?php foreach ($students as $student): ?>
            <?php if($level != $student->level_name): ?>
                <?php $level = $student->level_name ?>
                <tr>
                    <th class="academic"></th>
                    <th class="academic"></th>
                    <th class="academic"></th>
                    <th class="academic">
                        <?php echo $level ?> Year Level
                    </th>
                    <th class="academic"></th>
                    <th class="academic"></th>
                    <th class="academic"></th>
                    <th class="academic"></th>
                    <th class="academic"></th>
                </tr>
            <?php endif; ?>
            <tr>
                <th><?php echo $student->username ?></th>
                <th><?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?></th>
                <th><?php echo $student->logins ?></th>
                <th><?php echo !empty($student->last_login) ? date('d-m-Y h:i:s A', $student->last_login) : '' ?></th>
                <th><?php echo $student->status == 1 ? 'Approved Student' : 'Pending Review'?></th>
                <th><?php echo $student->level_name ?></th>
                <th>
                    <a href="<?php echo URL::base() ?>academic-records/list/<?php echo $student->students->find()->student_id ?>">Academic</a> - 
                    <a href="<?php echo URL::base() ?>achievement-records/list/<?php echo $student->students->find()->student_id ?>">Achievement</a> - 
                    <a href="<?php echo URL::base() ?>disciplinary-records/list/<?php echo $student->students->find()->student_id ?>">Disciplinary</a>
                    <?php if(Helper_User::getUserRole($user) != 'teacher'): ?>
                         - <a href="<?php echo URL::base() ?>financial-records/list/<?php echo $student->students->find()->student_id ?>">Financial</a>
                    <?php endif; ?>
                </th>
                <th>
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
                </th>
                <th>
                    <?php if($student->status == 0): ?>
                        <a href="<?php echo URL::base() ?>main/approve/student/<?php echo $student->id ?>">Approve</a>
                    <?php endif; ?>
                    <a href="<?php echo URL::base() ?>students/edit/<?php echo $student->id ?>">View<?php echo Helper_User::getUserRole($user) != 'teacher' ? '/Edit' : '' ?></a>
                </th>
            </tr>
        <?php endforeach; ?>
        </tbody>
</table>
<?php else: ?>
    <p>The students are not found</p>
<?php endif; ?>
<a href="<?php echo URL::base() ?>students/new">Create Student</a>