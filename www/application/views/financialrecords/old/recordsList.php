<h2>Financial Records</h2>
<h3>Name: <?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</h3>
<br>
<form name="form_year" id="form_year" action="<?php echo URL::base() ?>financial-records/list/<?php echo $student->student_id ?>">
    <select name="year" id="year">
        <?php for($i = $student->start_year; $i <= $student->end_year; $i++): ?>
            <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
        <?php endfor; ?>
    </select>
</form>

<h3>Year: <?php echo ORM::factory('academicyear', $year)->name ?>/<?php echo ORM::factory('academicyear', $year + 1)->name ?></h3>
<?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
    <div class="group-field-block">
        <label style="float: left; margin-right: 10px"><strong>Scholarship</strong></label>
        <input name="scholarship" type="checkbox" id="scholarship" <?php echo $scholarship == 1 ? 'checked' : '' ?>>
    </div>
<?php endif; ?>

<?php if($period == 0): ?>
    <!-- Semesters -->
    <br>
    <h4>Semesters</h4>
    <table class="table table-condensed" style="width: 650px; border: 1px solid black">
        <thead style="background-color: gainsboro">
            <tr>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>1st Semester Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>2nd Semester Result</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <?php for($i = 0; $i < 2; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <th><?php echo $paid ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Finished Payment (<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/1' ?>">Yes</a>/<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/0' ?>">No</a>)</th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if($period == 1): ?>
    <!-- Terms -->
    <br>
    <h4>Terms</h4>
    <table class="table table-condensed" style="width: 750px;  border: 1px solid black">
        <thead style="background-color: gainsboro">
            <tr>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>1st Terms Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>2nd Terms Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>3rd Terms Result</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <?php for($i = 0; $i < 3; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <th><?php echo $paid ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Finished Payment (<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/1' ?>">Yes</a>/<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/0' ?>">No</a>)</th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if($period == 2): ?>
    <!-- Quarters -->
    <br>
    <h4>Quarters</h4>
    <table class="table table-condensed" style="width: 850px;  border: 1px solid black">
        <thead style="background-color: gainsboro">
            <tr>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>1st Quarter Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>2nd Quarter Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>3rd Quarter Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>4th Quarter Result</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <?php for($i = 0; $i < 4; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <th><?php echo $paid ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Finished Payment (<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/1' ?>">Yes</a>/<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/0' ?>">No</a>)</th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if($period == 3): ?>
    <!-- Custom8 -->
    <br>
    <h4>Custom 8</h4>
    <table class="table table-condensed" style="width: 950px;  border: 1px solid black">
        <thead style="background-color: gainsboro">
            <tr>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>1st Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>2nd Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>3rd Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>4th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>5th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>6th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>7th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>8th Custom Result</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <?php for($i = 0; $i < 8; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <th><?php echo $paid ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Finished Payment (<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/1' ?>">Yes</a>/<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/0' ?>">No</a>)</th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr>
        </tbody>
    </table>
<?php endif; ?>

<?php if($period == 4): ?>
    <!-- Customs16 -->
    <br>
    <h4>Customs 16</h4>
    <table class="table table-condensed" style="width: 1150px;  border: 1px solid black">
        <thead style="background-color: gainsboro">
            <tr>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>1st Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>2nd Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>3rd Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>4th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>5th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>6th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>7th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>8th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>9th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>10th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>11th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>12th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>13th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>14th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>15th Custom Result</th>
               <th <?php echo Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' ? 'colspan="2"' : '' ?>>16th Custom Result</th>
            </tr> 
        </thead>
        <tbody>
            <tr>
                <?php for($i = 0; $i < 16; $i++): ?>
                    <?php $paid =  Model_Record_Financial::getStatusPaid($student->student_id, $period, $i, $year) ?>
                    <th><?php echo $paid ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th>Finished Payment (<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/1' ?>">Yes</a>/<a href="<?php echo URL::base() ?>financial-records/paid/<?php echo $student->student_id . '/' . $period . '/' . $i . '/' . $year . '/0' ?>">No</a>)</th>
                    <?php endif; ?>
                <?php endfor; ?>
            </tr> 
        </tbody>
    </table>
<?php endif; ?>

<?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
    <form name="finish_payment" action="<?php echo URL::base() ?>financial-records/finish-payment" style="margin-top: 20px" method="POST">
        <div class="group-field-block">
            <input type="hidden" name="student" value="<?php echo $student->student_id ?>">
            <input type="hidden" name="year" value="<?php echo $year ?>">
            <input type="submit" value="Paid for the year" class="btn btn-primary" <?php echo Model_Record_Financial::getStatusPaidForYear($student->student_id, $period, $year) ? 'disabled' : '' ?>>
        </div>
    </form>
<?php endif; ?>
<?php if($scholarship == 1): ?>
    <p><strong>The student receives a scholarship</strong></p>
<?php elseif(!empty($accounting)): ?>
    <p>1) <strong><?php echo $not_paid_count == 0 ? 'No outstanding Fees' : $not_paid_count * $annual_period . ' outstanding Fees'?></strong></p>
    <br>
    <p>2) <strong><?php echo $paid_count == 0 ? 'No Paid' : $paid_count * $annual_period . ' Paid'?></strong></p>
<?php endif; ?>