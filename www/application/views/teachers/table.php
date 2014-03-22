<div id="tab-2">
    <div class="sepH_c teacher-table">
            <table cellpadding="0" cellspacing="0" border="0" id="teachers_data_table" class="display">
                <thead>
                    <tr>
                        <th><div class="th_wrapp">N</div></th>
                        <th><div class="th_wrapp">Teacher ID (login)</div></th>
                        <th><div class="th_wrapp">Name</div></th>
                        <th><div class="th_wrapp">Logins Count</div></th>
                        <th><div class="th_wrapp">Home Room Teacher</div></th>
                        <th><div class="th_wrapp">Subject</div></th>
                        <th><div class="th_wrapp">Status</div></th>
                        <th><div class="th_wrapp">Records</div></th>
                        <th style="width: 106px;"><div class="th_wrapp">Actions</div></th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1 ?>
                <?php foreach ($teachers as $teacher): ?>
                    <tr>
                        <td><?php echo $index ?></td>
                        <td><a href="<?=URL::base()?><?=$role?>/teachers/view/<?php echo $teacher->id ?>"><?=$teacher->username?></a></td>
                        <td><?php echo $teacher->name ?> <?php echo $teacher->fathername ?> <?php echo $teacher->grfathername ?></td>
                        <td><?php echo $teacher->logins ?></td>
                        <td><?php echo (Valid::not_empty($teacher->class_name))? 
                             '<a href="'.URL::base().$role.'/classes/view/'.$teacher->class_id.'">'.$teacher->level_name.' - '.$teacher->class_name.'</a>': 
                            'No current class'?></td>
                        <td>
                            <?php $subjects = Model::factory('subject')->get_subjects_by_teacher($teacher)->as_array() ?>
                            <? $array_subjects = array();?>
                            <? foreach ($subjects as $subject) {
                                    $array_subjects[] = $subject->id;
                            }?>
                            <?php if(count($all_subjects) > 0): ?>
                                <form name="set_subject" action="<?php echo URL::base() ?><?=$role?>/teachers/associatesubject" method="POST">
                                    <input type="hidden" name="teacher" value="<?php echo $teacher->id ?>">
                                    <label for="subject">Associate with the Subject:</label>
                                    <select data-placeholder="Choose a Sybject..." multiple class="chzn-select" name="subjects[]">
                                        <?php foreach($all_subjects as $value): ?>
                                        <option value="<?php echo $value->id ?>" 
                                            <?=  in_array($value->id, $array_subjects)? 'selected': ''?>> 
                                                <?=$value->name?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div>
                                        <input type="submit" value="Associate" class="btn btn_dS fl">
                                    </div>
                                </form>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $teacher->status == 1 ? 'Approved Teacher' : 'Pending Review'?></td>
                        <td>
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/achievementteachers/list/<?php echo $teacher->id ?>">Achievement</a>
                            <br>
                            <a class="btn btn_bS tb" href="<?php echo URL::base() ?><?=$role?>/disciplinaryteachers/list/<?php echo $teacher->id ?>">Disciplinary</a>         
                        </td>
                        <td>
                            <div id="actions">
                                <?php if($role == 'sadmin' AND $teacher->status == 0): ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/teachers/approve/<?php echo $teacher->id ?>" class="sepV_a" title="Approve">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/preview_gray.png" alt="" />
                                    </button>
                                </a>
                                <?php endif; ?>
                                <a href="<?php echo URL::base() ?><?=$role?>/teachers/edit/<?php echo $teacher->id ?>" class="sepV_a" title="Edit">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                                    </button>
                                </a>
                                <button name="delete" value="<?=$teacher->id?>" data-toggle="modal" href="#deleteTeacherModal" 
                                    class="action-button teacher_delete_button">
                                    <a href="" title="Delete">
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
</div>
<br/>
<br/>
<div>
    <a href="<?=URL::base()?>sadmin/teachers/create" class="btn btn_dL sepH_b>">Create Teacher</a>
</div>
<div style="display: none;" class="modal hide" id="deleteTeacherModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/teachers/delete" method="post">
            <input id="delete_teacher_id" type="hidden" name="teacher_id" value="" />
            <p class="sepH_b">Are you sure you want to delete student?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>