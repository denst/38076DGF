<?php if(count($teachers) > 0): ?>
<table class="table table-condensed">
        <thead>
            <tr>
                <th>Teacher ID (login)</th>
                <th>Name</th>
                <th>Logins Count</th>
                <th>Last Login</th>
                <th>Subject</th>
                <th style="width: 10%">Status</th>
                <th>Records</th>
                <th style="width: 20%">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($teachers as $teacher): ?>
            <tr>
                <th><?php echo $teacher->username ?></th>
                <th><?php echo $teacher->name ?> <?php echo $teacher->fathername ?> <?php echo $teacher->grfathername ?></th>
                <th><?php echo $teacher->logins ?></th>
                <th><?php echo $teacher->last_login ?></th>
                <th>
                    <?php $subjects = $teacher->teachers->find()->subjects->find_all() ?>
                    <?php if(count($subjects) > 0): ?>
                        <?php foreach($subjects as $subject): ?>
                            <p>
                                <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>teachers/delete-subject/<?php echo $teacher->id ?>/<?php echo $subject->id ?>" class="delete-subj"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                <?php echo $subject->name ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php $all_subjects = ORM::factory('subject')->order_by('pid')->find_all() ?>
                    <?php if(count($all_subjects) > 0): ?>
                        <form name="set_subject" action="<?php echo URL::base() ?>teachers/associate-subject" method="POST">
                            <input type="hidden" name="teacher" value="<?php echo $teacher->id ?>">
                            <label for="subject">Associate with the Subject:</label>
                            <select name="subject">
                                <?php foreach($all_subjects as $value): ?>
                                <option value="<?php echo $value->id ?>"><?php echo $value->pid == 0 ? $value->name : ORM::factory('subject', $value->pid)->name . ' | ' . $value->name?></option>
                                <?php endforeach; ?>
                            </select>
                            <div>
                                <input type="submit" value="Associate" class="btn btn-primary">
                            </div>
                        </form>
                    <?php endif; ?>
                </th>
                <th><?php echo $teacher->status == 1 ? 'Approved Teacher' : 'Pending Review'?></th>
                <th>
                    <a href="<?php echo URL::base() ?>achievement-teacher-records/list/<?php echo $teacher->id ?>">Achievement Record</a>
                    <br>
                    <a href="<?php echo URL::base() ?>disciplinary-teacher-records/list/<?php echo $teacher->id ?>">Disciplinary Record</a>         
                </th>
                <th>
                    <?php if($teacher->status == 0): ?>
                        <a href="<?php echo URL::base() ?>main/approve/teacher/<?php echo $teacher->id ?>">Approve</a>
                    <?php endif; ?>
                    <a href="<?php echo URL::base() ?>teachers/edit/<?php echo $teacher->id ?>">View/Edit</a>
                </th>
            </tr>
        <?php endforeach; ?>
        </tbody>
</table>
<?php else: ?>
    <p>The teachers are not found</p>
<?php endif; ?>
<a href="<?php echo URL::base() ?>teachers/new">Create Teacher</a>