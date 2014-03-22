<div id="user-block">
    <div class="formEl_a">
        <fieldset>
            <legend><?php echo $level->name . $class->name ?></legend>

            <div class="sepH_b">
                <label for="name" class="lbl_a" style="width: 140px">Home Room Teacher:</label>
                <?php if(count($all_teachers) > 0): ?>
                    <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <form name="room_teacher" action="<?php echo URL::base() ?><?=$role?>/classes/changeteacher" method="POST">
                        <input type="hidden" name="class" value="<?php echo $class->id ?>">
                        <div>
                            <select name="teacher">
                                <option <?php echo $class->teacher_id == 0 ? 'selected' : '' ?> value="0">None</option>
                                <?php foreach($all_teachers as $tchr): ?>
                                    <option <?php echo $tchr->teacher_id == $class->teacher_id ? 'selected' : '' ?> value="<?php echo $tchr->teacher_id ?>"><?php echo $tchr->name . ' ' . $tchr->fathername . ' ' . $tchr->grfathername . ' (' . $tchr->user->username . ')' ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn_d fl">
                            <?php echo $class->teacher_id == 0 ? 'Set' : 'Change' ?> Home Room Teacher
                        </button>
                    </form>
                    <? else:?>
                        <? if($class->teacher_id != 0):?>
                            <h3><?php echo $class->teacher->name . ' ' . $class->teacher->fathername . ' ' . $class->teacher->grfathername . ' (' . $class->teacher->user->username . ')' ?></h3>
                        <? else:?>
                            <p>No teacher for this class</p>
                        <? endif?>
                    <? endif?>
                <?php else: ?>
                    <p>No teachers for this subject</p>
                <?php endif; ?>
            </div>
        
            <div class="sepH_b" id="subject-table">
                <?php if(count($subjects) > 0): ?>
                    <? if($table_subjects){
                        echo $table_subjects;
                    }?>
                <?php else: ?>
                    <p>No subjects in this class</p>
                <?php endif; ?>
                <? if($role == 'sadmin' OR $role == 'admin'):?>
                    <form name="add_subject_class" action="<?php echo URL::base() ?><?=$role?>/classes/addsubject" method="POST">
                        <input type="hidden" name="class" value="<?php echo $class->id ?>">
                        <div>
                            <select name="subject" style="width: 100px">
                                <?php foreach($all_subject as $subj): ?>
                                <option value="<?php echo $subj->id ?>"><?php echo $subj->pid == 0 ? $subj->name : ORM::factory('subject', $subj->pid)->name . ' | ' . $subj->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                        <div>
                            <button type="submit" class="btn btn_d fl">Add Subject</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <div class="sepH_b" id="subject-table">
                <?php if(count($students) > 0): ?>
                    <? if($table_students){
                        echo $table_students;
                    }?>
                <?php else: ?>
                    <p>No students for this class</p>
                <?php endif; ?>
            </div>
        </fieldset>
    </div>
</div>