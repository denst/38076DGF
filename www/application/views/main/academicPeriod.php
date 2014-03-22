<div id="academic-period">
    <form class="formEl_a" action="<?php echo URL::base() ?><?=$role?>/academicperiod" name="academic_period" id="academic-period" method="POST">
        <fieldset>
            <legend>Academic Period</legend>
            <div class="group-field-block">
                <label for="value" class="lbl_a">Period:</label>
                <select name="period" id="value" class="periods">
                    <option <?php echo $period->value == 1 ? 'selected' : '' ?> value="1">Semester</option>
                    <option <?php echo $period->value == 2 ? 'selected' : '' ?> value="2">Term</option>
                    <option <?php echo $period->value == 3 ? 'selected' : '' ?> value="3">Quarter</option>
                    <option <?php echo $period->value == 4 ? 'selected' : '' ?> value="4">Custom8</option>
                    <option <?php echo $period->value == 5 ? 'selected' : '' ?> value="5">Custom16</option>
                </select>
            </div>
            <? if(isset($periods)){
                echo $periods;
            }?>
        </fieldset>
        <button type="submit" class="btn btn_dL sepH_b">Change Academic Period</button>
    </form>
</div>