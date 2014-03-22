<? $picker_number = 1;?>
<? foreach ($periods as $period):?>
    <div class="sepH_c cf period_block" id="period_<?=$period->id?>" style="display: none;">
        <? for ($i = 1; $i <= $period->orders; $i++):?>
        <fieldset>
            <legend><?=$i?>st <?=Text::ucfirst($period->name)?></legend>
            <div class="period">
                <label for="datepick-<?=$picker_number?>" class="lbl_a">From:</label>
                <input type="text" name="period_dates[<?=$period->id?>][]" 
                    id="datepick-<?=$picker_number?>" class="inpt_b datepicker" 
                    value="<?=($period->id == $period_dates[0]->period_id)? 
                    Helper_Times::convert_date($period_dates[$i-1]->from): ''?>"/>
            </div>
            <? $picker_number++;?>
            <div>
                <label for="datepick-<?=$picker_number?>" class="lbl_a">To:</label>
                <input type="text" name="period_dates[<?=$period->id?>][]" 
                    id="datepick-<?=$picker_number?>" class="inpt_b datepicker" 
                    value="<?=($period->id == $period_dates[0]->period_id)? 
                    Helper_Times::convert_date($period_dates[$i-1]->to): ''?>"/>
            </div>
        </fieldset>
        <? $picker_number++;?>
        <? endfor;?>
    </div>
 <? endforeach;?>

<!--<div class="sepH_c cf period_block" id="period_0" style="display: none;">
    <fieldset>
        <legend>1st Semester</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[0][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[0][]" id="datepick-2" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>2st Semester</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[0][]" id="datepick-3" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[0][]" id="datepick-4" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
</div>

<div class="sepH_c cf period_block" id="period_1" style="display: none;">
    <fieldset>
        <legend>1st Terms</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>2st Terms</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>3st Terms</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[1][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
</div>

<div class="sepH_c cf period_block" id="period_2" style="display: none;">
    <fieldset>
        <legend>1st Quarter</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>2st Quarter</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>3st Quarter</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>4st Quarter</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[2][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
</div>

<div class="sepH_c cf period_block" id="period_3" style="display: none;">
    <fieldset>
        <legend>1st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>2st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>3st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>4st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>5st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>6st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>7st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>8st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[3][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
</div>

<div class="sepH_c cf period_block" id="period_4" style="display: none;">
    <fieldset>
        <legend>1st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>2st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>3st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>4st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>5st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>6st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>7st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>8st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>9st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>10st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>11st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>12st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>13st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>14st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>15st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
    <fieldset>
        <legend>16st Custom</legend>
        <div class="period">
            <label for="datepick-1" class="lbl_a">From:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
        <div>
            <label for="datepick-2" class="lbl_a">To:</label>
            <input type="text" name="period_dates[4][]" id="datepick-1" class="inpt_b datepicker" value="<?=(isset($user_data))? $user_data['dob']['ec']: ''?>"/>
        </div>
    </fieldset>
</div>-->