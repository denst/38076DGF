<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?=URL::base()?>css/pdf/perort_card.css">
    </head>
    <body>
        <table style="margin-top: -20px;">
            <tr>
                <td>
                    <img style="width: 300px;" src="<?=URL::base()?>img/grading_code.png" alt="">
                </td>
                <td>
                    <img id="big_logo" src="<?=URL::base()?>img/big_logo.png" alt="">
                </td>
            </tr>
        </table>
        <table id="student_title_table">
            <tr>
                <td colspan="3">
                    <table style="margin-left: 30px;">
                        <tr>
                            <td>Name:
                                <span class="text-underline">
                                    <?=Helper_Output::set_empty_space(3)?>
                                    <?=$student->name.' '.$student->fathername.' '.$student->grfathername?>
                                    <?=Helper_Output::set_empty_space(3)?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Grade:
                     <span class="text-underline">
                        <?=Helper_Output::set_empty_space(2)?>
                        <?=$student->class->level->name.' - '.$student->class->name?>
                        <?=Helper_Output::set_empty_space(2)?>
                    </span>                   
                </td>
                <td>Sex:
                    <span class="text-underline">
                        <?=Helper_Output::set_empty_space(2)?>
                        <?=($student->sex == 0)? 'male': 'female'?>
                        <?=Helper_Output::set_empty_space(2)?>
                    </span>
                </td>
                <td>Age:
                    <span class="text-underline">
                        <?=Helper_Output::set_empty_space(2)?>
                        <?=$student_data['age']?>
                        <?=Helper_Output::set_empty_space(2)?>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table style="margin-left: 30px;">
                        <tr>
                            <td>Academic Year:
                                <span class="text-underline">
                                    <?=Helper_Output::set_empty_space(5)?>
                                    <?=$student_data['academic_year']?>
                                    <?=Helper_Output::set_empty_space(5)?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">______________________________________________________</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table style="margin-left: 90px; margin-top: -15px;">
                        <tr>
                            <td>Signed (Home Room Teacher)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table  id="page_logo" style="margin-left: 125px">
            <tr>
                <td>
                    <img src="<?=URL::base()?>img/school_title.png" alt="">
                </td>
                <td>
                    <img id="logo" style="margin: 54px 0 0 110px;"
                         src="<?=URL::base()?>img/logo_1.png" alt="">
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <table id="table_1">
                        <thead>
                            <tr>
                                <td style="width: 169px;">SUBJECT</td>
                                <td style="width: 144px">TEACHER'S NAME</td>
                                <td class="period">1st Quarter</td>
                                <td class="tr">TR</td>
                                <td class="period">2st Quarter</td>
                                <td class="tr">TR</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                $sbjcts = array();
                                $sum_perc = 0;
                                $count_rcrds = 0;
                                $count_perc = 0;
                                $avg_result = array();
                                $gank_result = array();
                                $counter = 0;
                                $count_subjects = 0;
                                $total_rating = array();
                            ?>
                            <?php foreach ($subjects_records as $subject): ?>
                            <?php $sbjcts[] = $subject->id ?>
                            <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                <?php $subject_parent = $subject->parent_subject ?>
                                <tr>
                                    <td style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                                    <td style="background-color: gainsboro" class="total"></td>
                                    <td style="background-color: gainsboro" class="total"></td>
                                    <td style="background-color: gainsboro" class="total"></td>
                                    <td style="background-color: gainsboro" class="total"></td>
                                    <td style="background-color: gainsboro" class="total"></td>
                                </tr>
                                <? $counter++?>
                            <?php endif; ?>
                            <tr>
                                <td><?php echo $subject->subject_name ?></td>
                                <? $count_subjects++ ?>
                                <? $teacher = Model::factory('class_subject')->get_teacher_by_subject($subject->id)?>
                                <td><?=$teacher['name'].' '.$teacher['fathername'].' '.$teacher['grfathername']?></td>
                                <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                                <?php if(count($records) > 0): ?>
                                    <?php $count_rcrds++ ?>
                                    <?php $rcrds = array() ?>
                                    <?php foreach($records as $record): ?>
                                        <?php $rcrds[$record->order] = $record ?>
                                    <?php endforeach; ?>
                                    <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                    <?php for($i = 1; $i <= 2; $i++): ?>
                                        <?php if(!empty($rcrds[$i])): ?>
                                            <td>
                                                <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                   echo Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                ?>
                                            </td>
                                            <td></td>
                                        <?php else: ?>
                                            <td>-</td>
                                            <td></td>
                                            <? $total_rating[] = 0;?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <td>-</td>
                                    <td></td>
                                    <td>-</td>
                                    <td></td>
                                <?php endif; ?>
                            </tr>
                            <? $counter++?>
                            <?php endforeach; ?>
                            <? $rest = 9 - $counter?>
                            <? if($rest > 0):?>
                                <? for ($i = 1; $i < $rest; $i++):?>
                                    <tr>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                   </tr>
                                <? endfor;?>
                            <? endif?>
                            <tr>
                                <td>Total</td>
                                <td rowspan="5">&nbsp;</td>
                                 <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 2);?>
                                 <? foreach ($full_total_rating as $rating):?>
                                   <td><?=$rating?>%</td>
                                   <td></td>
                                 <? endforeach;?>
                            </tr>
                            <tr>
                              <td>Average</td>
                                <? foreach ($full_total_rating as $rating):?>
                                <td><?=round($rating / $count_subjects, 2)?>%</td>
                                <td></td>
                                <? endforeach;?>
                            </tr>
                            <tr>
                                <td>Rank</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Conduct</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Days of Absence</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table id="table_1" style="margin-left: 50px">
                        <thead>
                            <tr>
                                <td class="period">3rd Quarter</td>
                                <td class="tr">TR</td>
                                <td class="period">4rd Quarter</td>
                                <td class="tr">TR</td>
                                <td style="width: 30px;">Year Ave.</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                $sbjcts= array();
                                $sum_perc = 0;
                                $count_rcrds = 0;
                                $count_perc = 0;
                                $counter = 0;
                                $total_rating = array();
                            ?>
                            <?php foreach ($subjects_records as $subject): ?>
                            <?php $sbjcts[] = $subject->id ?>
                            <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                <?php $subject_parent = $subject->parent_subject ?>
                                <tr>
                                    <td style="background-color: gainsboro" class="total">&nbsp;</td>
                                    <td style="background-color: gainsboro" class="total">&nbsp;</td>
                                    <td style="background-color: gainsboro" class="total">&nbsp;</td>
                                    <td style="background-color: gainsboro" class="total">&nbsp;</td>
                                    <td style="background-color: gainsboro" class="total">&nbsp;</td>
                                </tr>
                                <? $counter++?>
                            <?php endif; ?>
                            <tr>
                                <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                                <?php if(count($records) > 0): ?>
                                    <?php $count_rcrds++ ?>
                                    <?php $rcrds = array() ?>
                                    <?php foreach($records as $record): ?>
                                        <?php $rcrds[$record->order] = $record ?>
                                    <?php endforeach; ?>
                                    <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                    <?php for($i = 3; $i <= 4; $i++): ?>
                                        <?php if(!empty($rcrds[$i])): ?>
                                            <td>
                                                <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                   echo Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                ?>
                                            </td>
                                            <td></td>
                                        <?php else: ?>
                                            <td>-</td>
                                            <td></td>
                                            <? $total_rating[] = 0;?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <td>-</td>
                                    <td></td>
                                    <td>-</td>
                                    <td></td>
                                <?php endif; ?>
                                <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                                <?php if($type == 'percentage'): ?>
                                    <?php $count_perc++ ?>
                                    <?php $sum_perc += $avg_rank ?>
                                <?php endif; ?>
                                <td><?=$avg_rank?></td>
                                <? $total_rating[] = $avg_rank;?>
                            </tr>
                            <? $counter++?>
                            <?php endforeach; ?>
                            <? $rest = 9 - $counter?>
                            <? if($rest > 0):?>
                                <? for ($i = 1; $i < $rest; $i++):?>
                                    <tr>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                       <td>&nbsp;</td>
                                   </tr>
                                <? endfor;?>
                            <? endif?>
                            <tr>
                                <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 3);?>
                                <? for ($i = 0; $i < 2; $i++):?>
                                   <td><?=$full_total_rating[$i]?>%</td>
                                   <td></td>
                                <? endfor;?>
                                <td><?=$full_total_rating[2]?>%</td>
                            </tr>
                            <tr>
                                <? for ($i = 0; $i < 2; $i++):?>
                                    <td><?=round($full_total_rating[$i] / $count_subjects, 2)?>%</td>
                                    <td></td>
                                <? endfor;?>
                                <td><?=round($full_total_rating[2] / $count_subjects, 2)?>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <table id="table_2">
                        <thead>
                            <tr>
                                <td style="width: 180px">TEACHER REMARKS</td>
                                <td style="width: 30px">CODE</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Actively Participates</td>
                                <td>AP</td>
                            </tr>
                            <tr>
                                <td>Outstanding Progress</td>
                                <td>OP</td>
                            </tr>
                            <tr>
                                <td>Very Good Work Habits</td>
                                <td>WH</td>
                            </tr>
                            <tr>
                                <td>Completes Work on Time</td>
                                <td>CW</td>
                            </tr>
                            <tr>
                                <td>Well Behaved Student</td>
                                <td>WB</td>
                            </tr>
                            <tr>
                                <td>Made Improvements This Qtr</td>
                                <td>MI</td>
                            </tr>
                            <tr>
                                <td>Has Acquired good Knowledge</td>
                                <td>HK</td>
                            </tr>
                            <tr>
                                <td>Needs Improvement</td>
                                <td>NI</td>
                            </tr>
                            <tr>
                                <td>Cutting Class</td>
                                <td>CT</td>
                            </tr>
                            <tr>
                                <td>Disturbs in Class</td>
                                <td>DC</td>
                            </tr>
                            <tr>
                                <td>Irregular Work Habits</td>
                                <td>IW</td>
                            </tr>
                            <tr>
                                <td>Often Late to school</td>
                                <td>OL</td>
                            </tr>
                            <tr>
                                <td>Incomplete Tests/Assignments</td>
                                <td>IT</td>
                            </tr>
                            <tr>
                                <td>Cheating on Tests</td>
                                <td>CH</td>
                            </tr>
                            <tr>
                                <td>Damaging School Property</td>
                                <td>DP</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <br/>
        <table id="sign_table">
            <tr>
                <td></td>
                <td>
                    <table class="sign">
                        <tr>
                            <td>Promoted to Grade ________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <table class="sign">
                        <tr>
                            <td>Detained in Grade _________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>__________________________________________________</td>
                <td>
                    <table class="sign">
                        <tr>
                            <td>______________________________________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table id="parent_sign">
                        <tr>
                            <td>Parent's Signature (4th Quarter)</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table id="princ_sign">
                        <tr>
                            <td>Principal's Signature</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>