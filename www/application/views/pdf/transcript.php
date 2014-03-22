<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?=URL::base()?>css/pdf/transcript.css">
    </head>
    <body>
        <table>
            <tr>
                <td>
                    <img id="logo" src="<?echo URL::base()?>img/logo_transcript.png" alt="">
                </td>
                <td>
                    <? if(Valid::not_empty($student_data['image'])):?>
                        <img id="user" src="<?echo URL::base()?>files/users/<?=$student_data['student_id']?>/110x110/<?=$student_data['image']?>" alt="">
                    <? else:?>
                        <img id="user" src="<?echo URL::base()?>/laguadmin/images/user_noPhoto100.gif" alt="">
                    <? endif?>
                </td>
            </tr>
        </table>
        <table id="title-table">
            <tr>
                <td>Name - <?=$student->name.' '.$student->fathername.' '.$student->grfathername?></td>
                <td></td>
            </tr>
            <tr>
                <td>Gender - <?=($student->sex == 0)? 'male': 'female'?></td>
                <td><table style="margin-left: 35px;">
                        <tr>
                            <td>Date of Birth - <?=$student_data['dob']['ec']?></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td>Issuance Date - <?=date('m/d/Y')?></td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td>
                    <table id="subject-table">
                        <? $total_subjects_index = 0;?>
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: <?=$total_subjects_records[$total_subjects_index]['grade']?></td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: <?=$total_subjects_records[$total_subjects_index]['year']?></td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                            <? 
                               $sbjcts    = array(); 
                               $sum_perc = 0; 
                               $count_rcrds = 0; 
                               $count_perc = 0; 
                               $counter = 0;
                               $count_subjects = 0;
                               $total_rating = array();
                            ?>
                            <?php foreach ($total_subjects_records[$total_subjects_index]['subjects'] as $subject): ?>
                                <?php $sbjcts[] = $subject->id ?>
                                <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                    <?php $subject_parent = $subject->parent_subject ?>
                                    <tr>
                                        <td class="border-right-bold" style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total border-right-bold"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                    </tr>
                                    <? $counter++?>
                                <?php endif; ?>
                                <tr>
                                    <td class="border-right-bold"><?php echo $subject->subject_name ?></td>
                                    <? $counter++?>
                                    <? $count_subjects++?>
                                    <?php $records = Model::factory('record_academic')->get_subject_records(
                                        $student, $subject, $period);?>
                                    <?php if(count($records) > 0): ?>
                                        <?php $count_rcrds++ ?>
                                        <?php $rcrds = array() ?>
                                        <?php foreach($records as $record): ?>
                                            <?php $rcrds[$record->order] = $record ?>
                                        <?php endforeach; ?>
                                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                            <?php if(!empty($rcrds[$i])): ?>
                                                <td>
                                                    <div id="actions">
                                                        <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                           echo Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                        ?>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td>-</td>
                                                <? $total_rating[] = 0;?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                                    <?php if($type == 'percentage'): ?>
                                        <?php $count_perc++ ?>
                                        <?php $sum_perc += $avg_rank ?>
                                    <?php endif; ?>
                                        <td><?=$avg_rank?></td>
                                        <? $total_rating[] = $avg_rank;?>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <? $rest = 11 - $counter?>
                                 <? if($rest > 0):?>
                                     <? for ($i = 1; $i < $rest; $i++):?>
                                         <tr>
                                             <td class="border-right-bold">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                          </tr>
                                     <? endfor;?>
                                 <? endif?>
                             <tr>
                                  <td class="border-right-bold">Total</td>
                                  <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 5);?>
                                  <? foreach ($full_total_rating as $rating):?>
                                    <td><?=$rating?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <? foreach ($full_total_rating as $rating):?>
                                  <td><?=round($rating / $count_subjects, 2)?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                    <? $total_subjects_index++;?>
                </td>
                <? if($year_count > 1):?>
                <td>
                    <table id="subject-table">
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: <?=$total_subjects_records[$total_subjects_index]['grade']?></td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: <?=$total_subjects_records[$total_subjects_index]['year']?></td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                               $sbjcts    = array(); 
                               $sum_perc = 0;
                               $count_rcrds = 0;
                               $count_perc = 0;
                               $counter = 0;
                               $count_subjects = 0;
                               $total_rating = array();
                            ?>
                            <?php foreach ($total_subjects_records[$total_subjects_index]['subjects'] as $subject): ?>
                                <?php $sbjcts[] = $subject->id ?>
                                <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                    <?php $subject_parent = $subject->parent_subject ?>
                                    <tr>
                                        <td class="border-right-bold" style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total border-right-bold"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                    </tr>
                                    <? $counter++?>
                                <?php endif; ?>
                                <tr>
                                    <td class="border-right-bold"><?php echo $subject->subject_name ?></td>
                                    <? $counter++?>
                                    <? $count_subjects++?>
                                    <?php $records = Model::factory('record_academic')->get_subject_records(
                                        $student, $subject, $period);?>
                                    <?php if(count($records) > 0): ?>
                                        <?php $count_rcrds++ ?>
                                        <?php $rcrds = array() ?>
                                        <?php foreach($records as $record): ?>
                                            <?php $rcrds[$record->order] = $record ?>
                                        <?php endforeach; ?>
                                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                            <?php if(!empty($rcrds[$i])): ?>
                                                <td>
                                                    <div id="actions">
                                                        <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                           echo Helper_Main::getRatingFromRecord($rcrds[$i]);?>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td>-</td>
                                                <? $total_rating[] = 0;?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                                    <?php if($type == 'percentage'): ?>
                                        <?php $count_perc++ ?>
                                        <?php $sum_perc += $avg_rank ?>
                                    <?php endif; ?>
                                        <td><?=$avg_rank?></td>
                                        <? $total_rating[] = $avg_rank;?>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <? $rest = 11 - $counter?>
                                 <? if($rest > 0):?>
                                     <? for ($i = 1; $i < $rest; $i++):?>
                                         <tr>
                                             <td class="border-right-bold">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                          </tr>
                                     <? endfor;?>
                                 <? endif?>
                              <tr>
                                  <td class="border-right-bold">Total</td>
                                  <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 5);?>
                                  <? foreach ($full_total_rating as $rating):?>
                                    <td><?=$rating?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <? foreach ($full_total_rating as $rating):?>
                                  <td><?=round($rating / $count_subjects, 2)?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                    <? $total_subjects_index++?>
                </td>
                <? else:?>
                 <td>
                    <table id="subject-table">
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: </td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: </td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                              <? for ($i = 0; $i < 10; $i++):?>
                                <tr>
                                    <td class="border-right-bold">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                              <? endfor;?>
                              <tr>
                                  <td class="border-right-bold">Total</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                </td>
                <? endif?>
            </tr>
        </table>
        <? if($year_count > 2):?>
        <table>
            <tr>
                <td>
                    <table id="subject-table">
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: <?=$total_subjects_records[$total_subjects_index]['grade']?></td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: <?=$total_subjects_records[$total_subjects_index]['year']?></td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                            <? 
                               $sbjcts    = array(); 
                               $sum_perc = 0; 
                               $count_rcrds = 0; 
                               $count_perc = 0; 
                               $counter = 0;
                               $count_subjects = 0;
                               $total_rating = array();
                            ?>
                            <?php foreach ($total_subjects_records[$total_subjects_index]['subjects'] as $subject): ?>
                                <?php $sbjcts[] = $subject->id ?>
                                <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                    <?php $subject_parent = $subject->parent_subject ?>
                                    <tr>
                                        <td class="border-right-bold" style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total border-right-bold"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                    </tr>
                                    <? $counter++?>
                                <?php endif; ?>
                                <tr>
                                    <td class="border-right-bold"><?php echo $subject->subject_name ?></td>
                                    <? $counter++?>
                                    <? $count_subjects++?>
                                    <?php $records = Model::factory('record_academic')->get_subject_records(
                                        $student, $subject, $period);?>
                                    <?php if(count($records) > 0): ?>
                                        <?php $count_rcrds++ ?>
                                        <?php $rcrds = array() ?>
                                        <?php foreach($records as $record): ?>
                                            <?php $rcrds[$record->order] = $record ?>
                                        <?php endforeach; ?>
                                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                            <?php if(!empty($rcrds[$i])): ?>
                                                <td>
                                                    <div id="actions">
                                                        <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                           echo Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                        ?>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td>-</td>
                                                <? $total_rating[] = 0;?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                                    <?php if($type == 'percentage'): ?>
                                        <?php $count_perc++ ?>
                                        <?php $sum_perc += $avg_rank ?>
                                    <?php endif; ?>
                                        <td><?=$avg_rank?></td>
                                        <? $total_rating[] = $avg_rank;?>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <? $rest = 11 - $counter?>
                                 <? if($rest > 0):?>
                                     <? for ($i = 1; $i < $rest; $i++):?>
                                         <tr>
                                             <td class="border-right-bold">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                          </tr>
                                     <? endfor;?>
                                 <? endif?>
                             <tr>
                                  <td class="border-right-bold">Total</td>
                                  <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 5);?>
                                  <? foreach ($full_total_rating as $rating):?>
                                    <td><?=$rating?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <? foreach ($full_total_rating as $rating):?>
                                  <td><?=round($rating / $count_subjects, 2)?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                    <? $total_subjects_index++;?>
                </td>
                <? if($year_count > 3):?>
                <td>
                    <table id="subject-table">
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: <?=$total_subjects_records[$total_subjects_index]['grade']?></td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: <?=$total_subjects_records[$total_subjects_index]['year']?></td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                               $sbjcts    = array(); 
                               $sum_perc = 0;
                               $count_rcrds = 0;
                               $count_perc = 0;
                               $counter = 0;
                               $count_subjects = 0;
                               $total_rating = array();
                            ?>
                            <?php foreach ($total_subjects_records[$total_subjects_index]['subjects'] as $subject): ?>
                                <?php $sbjcts[] = $subject->id ?>
                                <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                                    <?php $subject_parent = $subject->parent_subject ?>
                                    <tr>
                                        <td class="border-right-bold" style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total border-right-bold"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                        <td style="background-color: gainsboro" class="total"></td>
                                    </tr>
                                    <? $counter++?>
                                <?php endif; ?>
                                <tr>
                                    <td class="border-right-bold"><?php echo $subject->subject_name ?></td>
                                    <? $counter++?>
                                    <? $count_subjects++?>
                                    <?php $records = Model::factory('record_academic')->get_subject_records(
                                        $student, $subject, $period);?>
                                    <?php if(count($records) > 0): ?>
                                        <?php $count_rcrds++ ?>
                                        <?php $rcrds = array() ?>
                                        <?php foreach($records as $record): ?>
                                            <?php $rcrds[$record->order] = $record ?>
                                        <?php endforeach; ?>
                                        <?php $type = Helper_Main::getRatingType($records[0]) ?>
                                        <?php for($i = 1; $i <= 4; $i++): ?>
                                            <?php if(!empty($rcrds[$i])): ?>
                                                <td>
                                                    <div id="actions">
                                                        <? $total_rating[] = Helper_Main::getRatingFromRecord($rcrds[$i]);
                                                           echo Helper_Main::getRatingFromRecord($rcrds[$i]);?>
                                                    </div>
                                                </td>
                                            <?php else: ?>
                                                <td>-</td>
                                                <? $total_rating[] = 0;?>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                                    <?php if($type == 'percentage'): ?>
                                        <?php $count_perc++ ?>
                                        <?php $sum_perc += $avg_rank ?>
                                    <?php endif; ?>
                                        <td><?=$avg_rank?></td>
                                        <? $total_rating[] = $avg_rank;?>
                                    <?php else: ?>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                            <? $rest = 11 - $counter?>
                                 <? if($rest > 0):?>
                                     <? for ($i = 1; $i < $rest; $i++):?>
                                         <tr>
                                             <td class="border-right-bold">&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                              <td>&nbsp;</td>
                                          </tr>
                                     <? endfor;?>
                                 <? endif?>
                              <tr>
                                  <td class="border-right-bold">Total</td>
                                  <? $full_total_rating = Helper_Main::get_total_rating($total_rating, $count_subjects, 5);?>
                                  <? foreach ($full_total_rating as $rating):?>
                                    <td><?=$rating?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <? foreach ($full_total_rating as $rating):?>
                                  <td><?=round($rating / $count_subjects, 2)?>%</td>
                                  <? endforeach;?>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                </td>
                <? else:?>
                <td>
                    <table id="subject-table">
                        <thead>
                            <tr>
                                <td rowspan="4" id="subject_title">SUBJECT</td>
                                <td colspan="5">Grade: </td>
                            </tr>
                            <tr>
                                <td colspan="5">Academic Year: </td>
                            </tr>
                            <tr>
                                <td style="text-align: center" colspan="5">Quarters</td>
                            </tr>
                            <tr id="period_number">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>AV</td>
                            </tr>
                        </thead>
                        <tbody>
                              <? for ($i = 0; $i < 10; $i++):?>
                                <tr>
                                    <td class="border-right-bold">&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                              <? endfor;?>
                              <tr>
                                  <td class="border-right-bold">Total</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Average</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Rank</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Conduct</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold">Days Absent</td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                              </tr>
                              <tr>
                                  <td class="border-right-bold border-top-bold">Remark</td>
                                  <td class="border-top-bold" colspan="5">Promoted</td>
                              </tr>
                        </tbody>
                    </table>
                </td>
                <? endif?>
            </tr>
        </table>
        <? endif?>
        
        <table id="footer-table">
            <tr>
                <td>Comments - ___________________________________________________________</td>
                <td></td>
            </tr>
            <tr>
                <td>Record officer's Name and Signature : _____________________________</td>
                <td><table style="margin-left: 80px;">
                        <tr>
                            <td>Date -</td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td>Principal's Name and Signature : ___________________________________</td>
                <td>
                    <table style="margin-left: 80px;">
                        <tr>
                            <td>Date -</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>