<div id="tab-1" class="formEl_a">
    <fieldset>
        <h3><a href="<?=URL::base().$role?>/students/view/<?=$student->student_id?>"><?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</a></h3>
        <br>
        <div class="sepH_b">
            <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/achievementstudents/list/<?php echo $student->student_id ?>">
                <select name="year" id="year">
                    <?php for($i = $student->start_year; $i <= $student->end_year; $i++): ?>
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