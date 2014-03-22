<h2>Academic Records</h2>
<h3>Name: <?php echo $student->user->username ?> (<?php echo $student->name ?> <?php echo $student->fathername ?> <?php echo $student->grfathername ?>)</h3>
<?php if(Helper_User::getUserRole($user) != 'student'): ?>
    <?php if(!empty($subjects) && count($subjects) > 0): ?>
        <h3>Current Class: <?php echo $student->class->level->name . $student->class->name ?></h3>
        <table class="table table-condensed" style="width: 250px; border: 1px solid black">
                <thead style="background-color: gainsboro">
                    <tr>
                        <th>Subject</th>
                        <th style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <th>
                            <?php echo $subject->pid == 0 ? $subject->name : ORM::factory('subject', $subject->pid)->name . ' | ' . $subject->name ?>
                        </th>
                        <th>
                            <?php if(Helper_User::getUserRole($user) == 'admin' || Helper_User::getUserRole($user) == 'sadmin' || (Helper_User::getUserRole($user) == 'teacher' && ($user->teachers->find()->teacher_id == $subject->teacher_id || (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id)))): ?>
                                <a href="<?php echo URL::base() ?>academic-records/new/<?php echo $student->student_id ?>/<?php echo $subject->id ?>">Create record</a>
                            <?php endif; ?>
                        </th>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>
<form name="form_year" id="form_year" action="<?php echo URL::base() ?>academic-records/list/<?php echo $student->student_id ?>">
    <select name="year" id="year">
        <?php for($i = $student->start_year; $i <= $student->end_year; $i++): ?>
            <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
        <?php endfor; ?>
    </select>
</form>
    
    
<h3>Class: <?php echo $class ?></h3>
<h3>Year: <?php echo ORM::factory('academicyear', $year)->name ?>/<?php echo ORM::factory('academicyear', $year + 1)->name ?></h3>
<?php if(count($subjects_records) > 0): ?>
    <?php if($period == 0): ?>
        <!-- Semesters -->
        <br>
        <h4>Semesters</h4>
        <table class="table table-condensed" style="width: 650px; border: 1px solid black">
            <thead style="background-color: gainsboro">
                <tr>
                   <th>Subject</th>
                   <th>1st Semester Result</th>
                   <th>2nd Semester Result</th>
                   <th>Automatically Calculated Average</th>
                   <th>Automatically Calculated Rank in Class</th>
                </tr> 
            </thead>
            <tbody>
                <?php $sbjcts    = array() ?>
                <?php $sum_perc = 0 ?>
                <?php $count_rcrds = 0 ?>
                <?php $count_perc = 0 ?>
                <?php foreach ($subjects_records as $subject): ?>
                <?php $sbjcts[] = $subject->id ?>
                <?php if(!is_null($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                    <?php $subject_parent = $subject->parent_subject ?>
                    <tr>
                        <th style="background-color: gainsboro"><?php echo $subject->parent_subject ?></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $subject->subject ?></th>
                    <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                    <?php if(count($records) > 0): ?>
                        <?php $count_rcrds++ ?>
                        <?php $rcrds = array() ?>
                        <?php foreach($records as $record): ?>
                            <?php $rcrds[$record->order] = $record ?>
                        <?php endforeach; ?>
                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                        <?php for($i = 0; $i < 2; $i++): ?>
                            <?php if(!empty($rcrds[$i])): ?>
                                <th>
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && !empty($subjects) && $user->teachers->find()->teacher_id == ORM::factory('class_subject')->join('dg_sbjcts')->on('class_subject.subject_id', '=', 'dg_sbjcts.id')->where('dg_sbjcts.name', '=', $subject->subject)->where('class_subject.class_id', '=', $student->class->id)->find()->teacher_id) || (Helper_User::getUserRole($user) == 'teacher' && (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id))): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>academic-records/delete/<?php echo $rcrds[$i]->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" class="delete-subj" style="float: right"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                    <?php endif; ?>
                                </th>
                            <?php else: ?>
                                <th>-</th>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                        <?php if($type == 'percentage'): ?>
                            <?php $count_perc++ ?>
                            <?php $sum_perc += $avg_rank ?>
                        <?php endif; ?>
                        <th><?php echo $avg_rank ?></th>
                        <th><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></th>
                    <?php else: ?>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th>TOTAL</th>
                    <th>
                    <?php if($count_rcrds > 0): ?>
                        <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                    <?php endif; ?>
                    </th>
                    <th><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></th>
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
                   <th>Subject</th>
                   <th>1st Terms Result</th>
                   <th>2nd Terms Result</th>
                   <th>3rd Terms Result</th>
                   <th>Automatically Calculated Average</th>
                   <th>Automatically Calculated Rank in Class</th>
                </tr> 
            </thead>
            <tbody>
                <?php $sbjcts    = array() ?>
                <?php $sum_perc = 0 ?>
                <?php $count_rcrds = 0 ?>
                <?php $count_perc = 0 ?>
                <?php foreach ($subjects_records as $subject): ?>
                <?php $sbjcts[] = $subject->id ?>
                <?php if(!is_null($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                    <?php $subject_parent = $subject->parent_subject ?>
                    <tr>
                        <th style="background-color: gainsboro"><?php echo $subject->parent_subject ?></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $subject->subject ?></th>
                    <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                    <?php if(count($records) > 0): ?>
                        <?php $count_rcrds++ ?>
                        <?php $rcrds = array() ?>
                        <?php foreach($records as $record): ?>
                            <?php $rcrds[$record->order] = $record ?>
                        <?php endforeach; ?>
                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                        <?php for($i = 0; $i < 3; $i++): ?>
                            <?php if(!empty($rcrds[$i])): ?>
                                <th>
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && !empty($subjects) && $user->teachers->find()->teacher_id == ORM::factory('class_subject')->join('dg_sbjcts')->on('class_subject.subject_id', '=', 'dg_sbjcts.id')->where('dg_sbjcts.name', '=', $subject->subject)->where('class_subject.class_id', '=', $student->class->id)->find()->teacher_id) || (Helper_User::getUserRole($user) == 'teacher' && (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id))): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>academic-records/delete/<?php echo $rcrds[$i]->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" class="delete-subj" style="float: right"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                    <?php endif; ?>
                                </th>
                            <?php else: ?>
                                <th>-</th>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                        <?php if($type == 'percentage'): ?>
                            <?php $count_perc++ ?>
                            <?php $sum_perc += $avg_rank ?>
                        <?php endif; ?>
                        <th><?php echo $avg_rank ?></th>
                        <th><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></th>
                    <?php else: ?>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th>TOTAL</th>
                    <th>
                    <?php if($count_rcrds > 0): ?>
                        <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                    <?php endif; ?>
                    </th>
                    <th><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></th>
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
                   <th>Subject</th>
                   <th>1st Quarter Result</th>
                   <th>2nd Quarter Result</th>
                   <th>3rd Quarter Result</th>
                   <th>4th Quarter Result</th>
                   <th>Automatically Calculated Average</th>
                   <th>Automatically Calculated Rank in Class</th>
                </tr> 
            </thead>
            <tbody>
                <?php $sbjcts    = array() ?>
                <?php $sum_perc = 0 ?>
                <?php $count_rcrds = 0 ?>
                <?php $count_perc = 0 ?>
                <?php foreach ($subjects_records as $subject): ?>
                <?php $sbjcts[] = $subject->id ?>
                <?php if(!is_null($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                    <?php $subject_parent = $subject->parent_subject ?>
                    <tr>
                        <th style="background-color: gainsboro"><?php echo $subject->parent_subject ?></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $subject->subject ?></th>
                    <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                    <?php if(count($records) > 0): ?>
                        <?php $count_rcrds++ ?>
                        <?php $rcrds = array() ?>
                        <?php foreach($records as $record): ?>
                            <?php $rcrds[$record->order] = $record ?>
                        <?php endforeach; ?>
                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                        <?php for($i = 0; $i < 4; $i++): ?>
                            <?php if(!empty($rcrds[$i])): ?>
                                <th>
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && !empty($subjects) && $user->teachers->find()->teacher_id == ORM::factory('class_subject')->join('dg_sbjcts')->on('class_subject.subject_id', '=', 'dg_sbjcts.id')->where('dg_sbjcts.name', '=', $subject->subject)->where('class_subject.class_id', '=', $student->class->id)->find()->teacher_id) || (Helper_User::getUserRole($user) == 'teacher' && (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id))): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>academic-records/delete/<?php echo $rcrds[$i]->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" class="delete-subj" style="float: right"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                    <?php endif; ?>
                                </th>
                            <?php else: ?>
                                <th>-</th>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                        <?php if($type == 'percentage'): ?>
                            <?php $count_perc++ ?>
                            <?php $sum_perc += $avg_rank ?>
                        <?php endif; ?>
                        <th><?php echo $avg_rank ?></th>
                        <th><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></th>
                    <?php else: ?>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th>TOTAL</th>
                    <th>
                    <?php if($count_rcrds > 0): ?>
                        <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                    <?php endif; ?>
                    </th>
                    <th><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></th>
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
                   <th>Subject</th>
                   <th>1st Custom Result</th>
                   <th>2nd Custom Result</th>
                   <th>3rd Custom Result</th>
                   <th>4th Custom Result</th>
                   <th>5th Custom Result</th>
                   <th>6th Custom Result</th>
                   <th>7th Custom Result</th>
                   <th>8th Custom Result</th>
                   <th>Automatically Calculated Average</th>
                   <th>Automatically Calculated Rank in Class</th>
                </tr> 
            </thead>
            <tbody>
                <?php $sbjcts    = array() ?>
                <?php $sum_perc = 0 ?>
                <?php $count_rcrds = 0 ?>
                <?php $count_perc = 0 ?>
                <?php foreach ($subjects_records as $subject): ?>
                <?php $sbjcts[] = $subject->id ?>
                <?php if(!is_null($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                    <?php $subject_parent = $subject->parent_subject ?>
                    <tr>
                        <th style="background-color: gainsboro"><?php echo $subject->parent_subject ?></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $subject->subject ?></th>
                    <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                    <?php if(count($records) > 0): ?>
                        <?php $count_rcrds++ ?>
                        <?php $rcrds = array() ?>
                        <?php foreach($records as $record): ?>
                            <?php $rcrds[$record->order] = $record ?>
                        <?php endforeach; ?>
                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                        <?php for($i = 0; $i < 8; $i++): ?>
                            <?php if(!empty($rcrds[$i])): ?>
                                <th>
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && !empty($subjects) && $user->teachers->find()->teacher_id == ORM::factory('class_subject')->join('dg_sbjcts')->on('class_subject.subject_id', '=', 'dg_sbjcts.id')->where('dg_sbjcts.name', '=', $subject->subject)->where('class_subject.class_id', '=', $student->class->id)->find()->teacher_id) || (Helper_User::getUserRole($user) == 'teacher' && (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id))): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>academic-records/delete/<?php echo $rcrds[$i]->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" class="delete-subj" style="float: right"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                    <?php endif; ?>
                                </th>
                            <?php else: ?>
                                <th>-</th>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                        <?php if($type == 'percentage'): ?>
                            <?php $count_perc++ ?>
                            <?php $sum_perc += $avg_rank ?>
                        <?php endif; ?>
                        <th><?php echo $avg_rank ?></th>
                        <th><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></th>
                    <?php else: ?>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th>TOTAL</th>
                    <th>
                    <?php if($count_rcrds > 0): ?>
                        <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                    <?php endif; ?>
                    </th>
                    <th><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></th>
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
                   <th>Subject</th>
                   <th>1st Custom Result</th>
                   <th>2nd Custom Result</th>
                   <th>3rd Custom Result</th>
                   <th>4th Custom Result</th>
                   <th>5th Custom Result</th>
                   <th>6th Custom Result</th>
                   <th>7th Custom Result</th>
                   <th>8th Custom Result</th>
                   <th>9th Custom Result</th>
                   <th>10th Custom Result</th>
                   <th>11th Custom Result</th>
                   <th>12th Custom Result</th>
                   <th>13th Custom Result</th>
                   <th>14th Custom Result</th>
                   <th>15th Custom Result</th>
                   <th>16th Custom Result</th>
                   <th>Automatically Calculated Average</th>
                   <th>Automatically Calculated Rank in Class</th>
                </tr> 
            </thead>
            <tbody>
                <?php $sbjcts    = array() ?>
                <?php $sum_perc = 0 ?>
                <?php $count_rcrds = 0 ?>
                <?php $count_perc = 0 ?>
                <?php foreach ($subjects_records as $subject): ?>
                <?php $sbjcts[] = $subject->id ?>
                <?php if(!is_null($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                    <?php $subject_parent = $subject->parent_subject ?>
                    <tr>
                        <th style="background-color: gainsboro"><?php echo $subject->parent_subject ?></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                        <th class="total"></th>
                    </tr>
                <?php endif; ?>
                <tr>
                    <th><?php echo $subject->subject ?></th>
                    <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                    <?php if(count($records) > 0): ?>
                        <?php $count_rcrds++ ?>
                        <?php $rcrds = array() ?>
                        <?php foreach($records as $record): ?>
                            <?php $rcrds[$record->order] = $record ?>
                        <?php endforeach; ?>
                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                        <?php for($i = 0; $i < 16; $i++): ?>
                            <?php if(!empty($rcrds[$i])): ?>
                                <th>
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <?php if(Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (Helper_User::getUserRole($user) == 'teacher' && !empty($subjects) && $user->teachers->find()->teacher_id == ORM::factory('class_subject')->join('dg_sbjcts')->on('class_subject.subject_id', '=', 'dg_sbjcts.id')->where('dg_sbjcts.name', '=', $subject->subject)->where('class_subject.class_id', '=', $student->class->id)->find()->teacher_id) || (Helper_User::getUserRole($user) == 'teacher' && (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id))): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>academic-records/delete/<?php echo $rcrds[$i]->id ?>/<?php echo $student->student_id ?>/<?php echo $year ?>" class="delete-subj" style="float: right"><img src="<?php echo URL::base() ?>img/delete_icon.png"></a>
                                    <?php endif; ?>
                                </th>
                            <?php else: ?>
                                <th>-</th>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                        <?php if($type == 'percentage'): ?>
                            <?php $count_perc++ ?>
                            <?php $sum_perc += $avg_rank ?>
                        <?php endif; ?>
                        <th><?php echo $avg_rank ?></th>
                        <th><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></th>
                    <?php else: ?>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th class="total"></th>
                    <th>TOTAL</th>
                    <th>
                    <?php if($count_rcrds > 0): ?>
                        <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                    <?php endif; ?>
                    </th>
                    <th><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></th>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
<?php endif; ?>