<h2>Achievement Records</h2>
<h3><?php echo $teacher->user->username ?> (<?php echo $teacher->name ?> <?php echo $teacher->fathername ?> <?php echo $teacher->grfathername ?>)</h3>
<?php if(Helper_User::getUserRole($user) != 'teacher'): ?>
    <a href="<?php echo URL::base() ?>sadmin/teachers/achievementrecords/new/<?php echo $teacher->teacher_id ?>">Create record</a>
<?php endif; ?>
<br><br>

<form name="form_year" id="form_year" action="<?php echo URL::base() ?>achievement-teacher-records/list/<?php echo $teacher->teacher_id ?>">
    <select name="year" id="year">
        <?php for($i = $teacher->start_year; $i <= $end_year; $i++): ?>
            <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
        <?php endfor; ?>
    </select>
</form>

<h3>Year: <?php echo ORM::factory('academicyear', $year)->name ?>/<?php echo ORM::factory('academicyear', $year + 1)->name ?></h3>
<?php if(count($records) > 0): ?>
    <table class="table table-condensed" style="width: 650px; border: 1px solid black">
        <thead>
            <tr>
               <th>Date</th>
               <th>Achievement</th>
               <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                    <th>Notes</th>
                    <th colspan="2"></th>
               <?php endif; ?>
            </tr> 
        </thead>
        <tbody>
            <?php foreach ($records as $record): ?>
                <tr>
                    <th><?php echo date('d-m-y', $record->date) ?></th>
                    <th><?php echo $record->achievement ?></th>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'): ?>
                        <th><?php echo $record->notes ?></th>
                        <th><a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>achievement-teacher-records/delete/<?php echo $record->id ?>/<?php echo $teacher->teacher_id ?>/<?php echo $year ?>" class="delete-subj"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a></th>
                        <th><a href="<?php echo URL::base() ?>achievement-teacher-records/edit/<?php echo $record->id ?>/<?php echo $teacher->teacher_id ?>/<?php echo $year ?>">Edit</a></th>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No records for selected year</p>
<?php endif; ?>