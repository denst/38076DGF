<h2><?php echo $level->name . $class->name ?></h2>
<?php if(Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin'): ?>
    <div style="margin-left: 10px; margin-bottom: 20px">
        <?php $all_teachers = ORM::factory('teacher')->find_all() ?>
        <?php if(count($all_teachers) > 0): ?>
            <form name="room_teacher" action="<?php echo URL::base() ?>sadmin/classes/changeteacher" method="POST">
                <input type="hidden" name="class" value="<?php echo $class->id ?>">
                <select name="teacher">
                    <option <?php echo $class->teacher_id == 0 ? 'selected' : '' ?> value="0">None</option>
                    <?php foreach($all_teachers as $tchr): ?>
                        <option <?php echo $tchr->teacher_id == $class->teacher_id ? 'selected' : '' ?> value="<?php echo $tchr->teacher_id ?>"><?php echo $tchr->name . ' ' . $tchr->fathername . ' ' . $tchr->grfathername . ' (' . $tchr->user->username . ')' ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <input type="submit" value="<?php echo $class->teacher_id == 0 ? 'Set' : 'Change' ?> Home Room Teacher">
            </form>
        <?php else: ?>
            <p>No teachers for this subject</p>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="<?php echo Helper_User::getUserRole($user) != 'student' ? 'left' : '' ?>">
    <?php if(count($subjects) > 0): ?>
    <table class="table table-condensed" border="1" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="2">Subject</th>
                    <th>Scheme</th>
                    <th>Teacher Name</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($subjects as $subject): ?>
                <tr>
                    <th style="font-weight: normal; width: 150px">
                        <?php echo $subject->pid == 0 ? $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . $subject->name ?>
                    </th>
                    <th>
                        <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                            <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>classes/delete-subject/<?php echo $subject->subject_id ?>/<?php echo $class->id ?>" class="delete-subj"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                        <?php endif; ?>
                    </th>
                    <th>
                        <form name="sheme_subject" action="<?php echo URL::base() ?>subjects/change-scheme" method="POST">
                            <input type="hidden" name="subject" value="<?php echo $subject->id ?>">
                            <select name="scheme" <?php echo Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin' ? '' : 'disabled' ?>>
                                <option <?php echo $subject->scheme == 0 ? 'selected' : '' ?> value="0">Percentage</option>
                                <option <?php echo $subject->scheme == 1 ? 'selected' : '' ?> value="1">Letter</option>
                                <option <?php echo $subject->scheme == 2 ? 'selected' : '' ?> value="2">Comment</option>
                            </select>
                            <?php if(Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin'): ?>
                                <input type="submit" value="Change scheme">
                            <?php endif; ?>
                        </form>
                    </th>
                    <th style="font-weight: normal">
                        <?php $teachers = ORM::factory('subject', $subject->subject_id)->teachers->find_all() ?>
                        <?php if(count($teachers) > 0): ?>
                            <form name="teacher_subject" action="<?php echo URL::base() ?>subjects/change-teacher" method="POST">
                                <input type="hidden" name="subject" value="<?php echo $subject->id ?>">
                                <select name="teacher" <?php echo Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin' ? '' : 'disabled' ?>>
                                    <option <?php echo $subject->teacher_id == 0 ? 'selected' : '' ?> value="0">None</option>
                                    <?php foreach($teachers as $teacher): ?>
                                        <option <?php echo $subject->teacher_id == $teacher->teacher_id ? 'selected' : '' ?> value="<?php echo $teacher->teacher_id ?>"><?php echo $teacher->name . ' ' . $teacher->fathername . ' ' . $teacher->grfathername . ' (' . $teacher->user->username . ')' ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin'): ?>
                                    <input type="submit" value="Change teacher">
                                <?php endif; ?>
                            </form>
                        <?php else: ?>
                            <p>No teachers for this subject</p>
                        <?php endif; ?>
                    </th>
                </tr>
            <?php endforeach; ?>
            </tbody>
    </table>
    <?php else: ?>
        <p>No subjects in this class</p>
    <?php endif; ?>
    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
    <form name="add_subject_class" action="<?php echo URL::base() ?>classes/add-subject" method="POST">
        <input type="hidden" name="class" value="<?php echo $class->id ?>">
        <select name="subject" style="width: 100px">
            <?php foreach($all_subject as $subj): ?>
            <option value="<?php echo $subj->id ?>"><?php echo $subj->pid == 0 ? $subj->name : ORM::factory('subject', $subj->pid)->name . ' | ' . $subj->name ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Add Subject">
    </form>
    <?php endif; ?>
</div>


<?php if(Helper_User::getUserRole($user) != 'student'): ?>
<div class="right">
        <?php if(count($students) > 0): ?>
        <table class="table table-condensed" border="1" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                            <th colspan="2">Actions</th>
                        <?php endif; ?>
                        <th>Records</th>
                        <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Promoting / Detaining</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <th style="font-weight: normal">
                            <?php echo $student->user->username ?>
                        </th>
                        <th style="font-weight: normal">
                            <?php echo $student->name ?>
                        </th>
                        <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                            <th>
                                <a onclick="if(!confirm('Really delete student from this class?')) return false" href="<?php echo URL::base() ?>classes/delete-student/<?php echo $student->student_id ?>/<?php echo $class->id ?>" class="delete-subj"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                            </th>
                            <th>
                                <form name="move_student" action="<?php echo URL::base() ?>classes/move-student" method="POST">
                                    <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
                                    <input type="hidden" name="current_class" value="<?php echo $student->class_id ?>">
                                    <span style="font-weight: normal"> <?php echo $level->name ?></span>
                                    <select name="class">
                                        <?php foreach($all_class as $cls): ?>
                                            <option <?php echo $cls->id == $student->class_id ? 'selected' : '' ?> value="<?php echo $cls->id ?>"><?php echo $cls->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="submit" value="Move student">
                                </form>
                            </th>
                        <?php endif; ?>
                        <th>
                            <a href="<?php echo URL::base() ?>academic-records/list/<?php echo $student->student_id ?>">Academic</a> - 
                            <a href="<?php echo URL::base() ?>achievement-records/list/<?php echo $student->student_id ?>">Achievement</a> - 
                            <a href="<?php echo URL::base() ?>disciplinary-records/list/<?php echo $student->student_id ?>">Disciplinary</a> -
                            <?php if(Helper_User::getUserRole($user) != 'teacher'): ?>
                                <a href="<?php echo URL::base() ?>financial-records/list/<?php echo $student->student_id ?>">Financial</a>
                            <?php endif; ?>
                        </th>
                        <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>
                            <?php if(Helper_Main::getStatusForPromotion($student->student_id)): ?>
                                <a href="<?php echo URL::base() ?>levels/promoting-detaining/prom/<?php echo $student->student_id ?>">Promoting</a> - 
                            <?php endif; ?>
                            <a href="<?php echo URL::base() ?>levels/promoting-detaining/det/<?php echo $student->student_id ?>">Detaining</a>
                        </th>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
        <?php else: ?>
            <p>No students for this class</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <br><br>
    <a href="<?php echo URL::base() ?>academic-records/list/<?php echo $user->students->find()->student_id ?>">Academic Record</a> - 
    <br>
    <a href="<?php echo URL::base() ?>achievement-records/list/<?php echo $user->students->find()->student_id ?>">Achievement Record</a> - 
    <br>
    <a href="<?php echo URL::base() ?>disciplinary-records/list/<?php echo $user->students->find()->student_id ?>">Disciplinary Record</a> -
    <br>
    <a href="<?php echo URL::base() ?>financial-records/list/<?php echo $user->students->find()->student_id ?>">Financial</a>
<?php endif; ?>