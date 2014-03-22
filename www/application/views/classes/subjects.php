<fieldset>
    <legend>Subjects</legend>
    <form name="sheme_subject" action="<?php echo URL::base() ?><? echo $role?>/subjects/changesubjects" method="POST">
        <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
            <thead>
                <tr>
                    <th><div class="th_wrapp">N</div></th>
                    <th><div class="th_wrapp">Subject</div></th>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <th>
                            <div class="th_wrapp">Scheme</div>
                            <input type="checkbox" id="select_all_cheme">
                            <select name="scheme" id="all_scheme">
                                <option <?php echo $subject->scheme == 0 ? 'selected' : '' ?> value="0">Percentage</option>
                                <option <?php echo $subject->scheme == 1 ? 'selected' : '' ?> value="1">Letter</option>
                                <option <?php echo $subject->scheme == 2 ? 'selected' : '' ?> value="2">Comment</option>
                            </select>
                        </th>
                    <? endif?>
                    <th><div class="th_wrapp">Teacher</div></th>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <th><div class="th_wrapp">Action</div>
                        <div id="actions">
                            <input type="checkbox" id="select_all_delete_subjects">
                            <button style="float: right" name="delete" value="<?=$subject->subject_id.'&'.$class->id?>" data-toggle="modal" href="#deleteAllClassSubjectModal" 
                               class="action-button class_all_subject_delete_button">
                                <a href="" title="delete">
                                <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png"></a>
                           </button>
                        </div>
                        </th>
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
                            <input type="hidden" name="subjects[]" value="<?php echo $subject->id ?>">
                            <input type="checkbox" class="scheme">
                            <select name="schemes[]">
                                <option <?php echo $subject->scheme == 0 ? 'selected' : '' ?> value="0">Percentage</option>
                                <option <?php echo $subject->scheme == 1 ? 'selected' : '' ?> value="1">Letter</option>
                                <option <?php echo $subject->scheme == 2 ? 'selected' : '' ?> value="2">Comment</option>
                            </select>
                        </td>
                        <? endif?>
                        <td style="font-weight: normal">
                            <?php $teachers = ORM::factory('subject', $subject->subject_id)->teachers->find_all() ?>
                            <?php if(count($teachers) > 0): ?>
                                <? if($role == 'sadmin' OR $role == 'admin'):?>
                                    <input type="hidden" name="subject" value="<?php echo $subject->id ?>">
                                    <select name="teachers[]">
                                        <option <?php echo $subject->teacher_id == 0 ? 'selected' : '' ?> value="0">None</option>
                                        <?php foreach($teachers as $teacher): ?>
                                            <option <?php echo $subject->teacher_id == $teacher->teacher_id ? 'selected' : '' ?> value="<?php echo $teacher->teacher_id ?>"><?php echo $teacher->name . ' ' . $teacher->fathername . ' ' . $teacher->grfathername . ' (' . $teacher->user->username . ')' ?></option>
                                        <?php endforeach; ?>
                                     </select>
                               <? else:?>
                                   <? $teacher = Model::factory('teacher')->get_teacher_by_id($subject->teacher_id);?>
                                   <p><?php echo $teacher->name . ' ' . $teacher->fathername . ' ' . $teacher->grfathername . ' (' . $teacher->user->username . ')' ?></p>
                               <? endif?>
                           <?php else: ?>
                                <input type="hidden" name="teachers[]" value="0">
                               <p>No teachers for this subject</p>
                           <?php endif; ?>
                        </td>
                        <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <td>
                            <div id="actions">
                               <input type="checkbox" class="delete_subject" value="<?=$subject->subject_id.'&'.$class->id?>">
                               <button style="float: right" name="delete" value="<?=$subject->subject_id.'&'.$class->id?>" data-toggle="modal" href="#deleteClassSubjectModal" 
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
            </tbody>
        </table>
        <? if($role == 'sadmin' OR $role == 'admin'):?>
        <button type="submit" class="btn btn_d fl">Save subjects</button>
        <? endif?>
    </form>
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
<div style="display: none;" class="modal hide" id="deleteAllClassSubjectModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/classes/deleteallsubjects" method="post">
            <input id="delete_all_class_subject" type="hidden" name="class_subjects" value="" />
            <input type="hidden" name="class_id" value="<?=$class->id?>" />
            <p class="sepH_b">Are you sure you want to delete selected subjects?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>