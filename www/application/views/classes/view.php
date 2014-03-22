<div id="user-block">
    <div class="formEl_a">
        <fieldset>
            <legend><?php echo $level->name .' - '. $class->name ?></legend>
            <div class="sepH_b class-block">
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
            
            <? if($role == 'sadmin' OR $role == 'admin'):?>
            <div id="class_subjects" class="sepH_b class-block">
                <label for="name" class="lbl_a" style="width: 140px">Subjects:</label>
                <?php if(count($all_subject) > 0): ?>
                    <form name="add_subject_class" action="<?php echo URL::base() ?><?=$role?>/classes/addsubjects" method="POST">
                        <input type="hidden" name="class" value="<?php echo $class->id ?>">
                        <select data-placeholder="Choose a Sybject..." multiple class="chzn-select" name="subjects[]">
                            <?php foreach($all_subject as $value): ?>
                                <option value="<?php echo $value->id ?>"> 
                                    <?=$value->name?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn_d fl">Add subjects</button>
                    </form>
                <?php endif; ?>
            </div>
            <? endif?>
        
            <div class="sepH_b" id="subject-table">
                <?php if(count($subjects) > 0): ?>
                    <? if($table_subjects){
                        echo $table_subjects;
                    }?>
                <?php else: ?>
                <fieldset>
                    <legend>Subjects</legend>
                    <p>No subjects in this class</p>
                </fieldset>
                <?php endif; ?>
            </div>

            <div class="sepH_b" id="class-students">
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