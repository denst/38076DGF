<div id="user-block">
    <div class="formEl_a">
        <fieldset>
            <legend><?php echo $level->name ?> level grade</legend>
            <?php if(count($all_class) > 0): ?>
                <?php if(count($students) > 0): ?>
                    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
                        <thead>
                            <tr>
                                <th><div class="th_wrapp"><input type="checkbox" id="select_all" /></div></th>
                                <th><div class="th_wrapp">ID</div></th>
                                <th><div class="th_wrapp">Name</div></th>
                                <th><div class="th_wrapp">Class assigned</div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><input type="checkbox" class="students" name="student_id" value="<?php echo $student->student_id ?>"></td>
                                <td style="font-weight: normal">
                                    <?php echo $student->user->username ?>
                                </td>
                                <td style="font-weight: normal">
                                    <?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>
                                </td>
                                <td>
                                    <form name="move_student" action="<?php echo URL::base() ?><?=$role?>/classes/movestudent" method="POST">
                                        <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
                                        <span style="font-weight: normal"> <?php echo $level->name ?></span>
                                        <select name="class">
                                            <?php foreach($all_class as $cls): ?>
                                                <option <?php echo $cls->id == $student->class_id ? 'selected' : '' ?> value="<?php echo $cls->id ?>"><?php echo $cls->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn_dS">Assigned</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <form name="auto_assigned" action="<?php echo URL::base() ?><?=$role?>/levels/autoassigned/" method="POST">
                        <input type="hidden" name="level_id" value="<?=$level->id?>"/>
                        <input type="hidden" name="year" value="<?=$year?>"/>
                        <input type="hidden" name="students" value="">
                        <button type="submit" class="btn btn_d fl">Auto assigned</button>
                    </form>
                <?php else: ?>
                    <p>No student for this level grade</p>
                <?php endif; ?>
            <?php else: ?>
                <p>No classes for this level grade</p>
            <?php endif; ?>
        </fieldset>
    </div>
</div>