<div id="tab-1" class="formEl_a">
    <fieldset>
        <legend>Achievement Records</legend>
        <h3><?php echo $teacher->user->username ?> (<?php echo $teacher->name ?> <?php echo $teacher->fathername ?> <?php echo $teacher->grfathername ?>)</h3>
        <br>
        <div class="sepH_b">
            <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/achievementteachers/list/<?php echo $teacher->teacher_id ?>">
                <select name="year" id="year">
                    <?php for($i = $teacher->start_year; $i <= $end_year; $i++): ?>
                        <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        </div>

        <div class="sepH_b">
            <?php if(count($records) > 0): ?>
                <? if(isset($table))
                    echo $table;?>
            <?php else: ?>
                <p>No records for selected year</p>
            <?php endif; ?>
        </div>
    </fieldset>
</div>