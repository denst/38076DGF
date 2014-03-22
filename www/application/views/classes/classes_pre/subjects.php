<fieldset>
    <legend>Subjects</legend>
    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
                <th><div class="th_wrapp">N</div></th>
                <th><div class="th_wrapp">Subject</div></th>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <th><div class="th_wrapp">Scheme</div></th>
                <? endif?>
                <th><div class="th_wrapp">Teacher</div></th>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <th><div class="th_wrapp">Action</div></th>
                <? endif?>
            </tr>
        </thead>
        <tbody>
            <? $index = 1;?>
            <?php foreach ($subjects as $subject): ?>
                 <tr>
                     <td><?=$index?></td>
                     <td style="font-weight: normal; width: 150px">
                         <?php echo $subject->pid == 0 ? $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . $subject->name ?>
                     </td>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <td>
                            <form name="sheme_subject" action="<?php echo URL::base() ?><?=$role?>/subjects/changescheme" method="POST">
                                <input type="hidden" name="subject" value="<?php echo $subject->id ?>">
                                <select name="scheme">
                                    <option <?php echo $subject->scheme == 0 ? 'selected' : '' ?> value="0">Percentage</option>
                                    <option <?php echo $subject->scheme == 1 ? 'selected' : '' ?> value="1">Letter</option>
                                    <option <?php echo $subject->scheme == 2 ? 'selected' : '' ?> value="2">Comment</option>
                                </select>
                               <button type="submit" class="btn btn_dS">Change scheme</button>
                            </form>
                        </td>
                     <? endif?>
                     <td style="font-weight: normal">
                         <?php $teachers = ORM::factory('subject', $subject->subject_id)->teachers->find_all() ?>
                         <?php if(count($teachers) > 0): ?>
                             <? if($role == 'sadmin' OR $role == 'admin'):?>
                                <form name="teacher_subject" action="<?php echo URL::base() ?><?=$role?>/subjects/changeteacher" method="POST">
                                    <input type="hidden" name="subject" value="<?php echo $subject->id ?>">
                                    <select name="teacher">
                                        <option <?php echo $subject->teacher_id == 0 ? 'selected' : '' ?> value="0">None</option>
                                        <?php foreach($teachers as $teacher): ?>
                                            <option <?php echo $subject->teacher_id == $teacher->teacher_id ? 'selected' : '' ?> value="<?php echo $teacher->teacher_id ?>"><?php echo $teacher->name . ' ' . $teacher->fathername . ' ' . $teacher->grfathername . ' (' . $teacher->user->username . ')' ?></option>
                                        <?php endforeach; ?>
                                       </select>
                                   <button type="submit" class="btn btn_dS">Change teacher</button>
                               </form>
                            <? else:?>
                                <? $teacher = Model::factory('teacher')->get_teacher_by_id($subject->teacher_id);?>
                                <p><?php echo $teacher->name . ' ' . $teacher->fathername . ' ' . $teacher->grfathername . ' (' . $teacher->user->username . ')' ?></p>
                            <? endif?>
                        <?php else: ?>
                            <p>No teachers for this subject</p>
                        <?php endif; ?>
                     </td>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <td>
                            <div id="actions">
                               <button name="delete" value="<?=$subject->subject_id.'&'.$class->id?>" data-toggle="modal" href="#deleteClassSubjectModal" 
                                   class="action-button class_subject_delete_button">
                                   <a href="" title="delete">
                                    <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png"></a>
                               </button>
                            </div>
                        </td>
                     <? endif?>
                 </tr>
                 <? $index++;?>
             <?php endforeach; ?>
        <tbody>
    </table>
    <button class="btn btn_dL">Save subjects</button>
</fieldset>
<div style="display: none;" class="modal hide" id="deleteClassSubjectModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/classes/deletesubject" method="post">
            <input id="delete_class_subject" type="hidden" name="class_subject" value="" />
            <p class="sepH_b">Are you sure you want to delete subject?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>