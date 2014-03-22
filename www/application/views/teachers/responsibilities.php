<div id="tab-1" class="formEl_a">
    <fieldset>
        <legend>Current Responsibilities</legend>
        <h3><?php echo $teacher->user->username ?> (<?php echo $teacher->name ?> <?php echo $teacher->grfathername ?> <?php echo $teacher->fathername ?>)</h3>
        <br>
        <div class="sepH_b">
            <?php if(count($subjects) > 0): ?>
                <? if(isset($table))
                    echo $table;?>
            <?php else: ?>
                <p>No records for selected year</p>
            <?php endif; ?>
        </div>
    </fieldset>
</div>
