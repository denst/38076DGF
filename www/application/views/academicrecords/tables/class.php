<!-- Class -->
<fieldset>
    <legend>Subjects</legend>
    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
                <th>#</th>
                <th><div class="th_wrapp">Subject</div></th>
                <? if($role != 'student'):?>
                    <th><div class="th_wrapp">Actions</div></th>
                <? endif?>
            </tr>
        </thead>
        <tbody>
            <? $index = 1;?>
            <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?=$index?></td>
                <td>
                    <?php echo $subject->pid == 0 ? $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . $subject->name ?>
                </td>
                <? if($role != 'student'):?>
                    <td>
                        <?php if(Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin' || (Helper_User::getUserRole($user) == 'teacher' && ($user->teachers->find()->teacher_id == $subject->teacher_id || (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id)))): ?>
                            <a href="<?php echo URL::base() ?><?=$role?>/academicrecords/create/<?php echo $student->student_id ?>&<?php echo $subject->id ?>">Create record</a>
                        <?php endif; ?>
                    </td>
                <? endif?>
            </tr>
            <? $index++;?>
            <?php endforeach; ?>
        <tbody>
    </table>

</fieldset>
<!--End Class -->
