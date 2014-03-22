<div id="achievement-block">
        <table style="text-align: center;" cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
            <thead>
                <tr>
                    <th><div class="th_wrapp">#</div></th>
                    <th><div class="th_wrapp">Subject</div></th>
                    <th><div class="th_wrapp">Class</div></th>
                    <th><div class="th_wrapp">Home Room Teacher</div></th>
                </tr>
            </thead>
            <tbody>
                <? $index = 1;?>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?php echo $index ?></td>
                    <td><?php echo $subject->subject_name ?></td>
                    <td>
                        <a href="<?=URL::base()?>teacher/classes/view/<?=$subject->class_id?>">
                            <?php echo $subject->level_name.$subject->class_name; ?>
                        </a>
                    </td>
                    <? $teacher = Model::factory('teacher')->get_teacher_by_id($subject->teacher_id);?>
                    <td><?php echo ($teacher)? $teacher->name.' '.$teacher->fathername.' '.$teacher->grfathername.
                            ' ('.$teacher->user->username.')'
                            : 'No home room teacher for this class'?></td>
                </tr>
                <? $index++;?>
                <?php endforeach; ?>
            <tbody>
        </table>
</div>