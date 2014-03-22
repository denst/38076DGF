<h2><?php echo $level->name ?> level grade</h2>
<div class="left">
    <?php if(count($all_class) > 0): ?>
        <?php if(count($students) > 0): ?>
            <table class="table table-condensed" border="1" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Class assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <th><input type="checkbox" class="students" name="student_id" value="<?php echo $student->student_id ?>"></th>
                            <th style="font-weight: normal">
                                <?php echo $student->user->username ?>
                            </th>
                            <th style="font-weight: normal">
                                <?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>
                            </th>
                            <th>
                                <form name="move_student" action="<?php echo URL::base() ?>classes/move-student" method="POST">
                                    <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
                                    <span style="font-weight: normal"> <?php echo $level->name ?></span>
                                    <select name="class">
                                        <?php foreach($all_class as $cls): ?>
                                            <option <?php echo $cls->id == $student->class_id ? 'selected' : '' ?> value="<?php echo $cls->id ?>"><?php echo $cls->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="submit" value="Assigned">
                                </form>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
            <form name="auto_assigned" action="<?php echo URL::base() ?>levels/auto-assigned/<?php echo $level->id ?>/<?php echo $year ?>" method="POST">
                <input type="hidden" name="students" value="">
                <input type="submit" value="Auto assigned">
            </form>
        <?php else: ?>
            <p>No student for this level grade</p>
        <?php endif; ?>
    <?php else: ?>
        <p>No classes for this level grade</p>
    <?php endif; ?>
</div>