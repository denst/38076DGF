<!-- Terms -->
<fieldset>
    <legend><?php echo $student->class->level->name .' - '. $student->class->name ?></legend>
    <table style="text-align: center"  cellpadding="0" cellspacing="0" border="0" class="table-records table_a smpl_tbl">
        <thead>
            <tr>
               <th><div class="td_wrapp">Subject</div></th>
               <th><div class="td_wrapp">1st Term Result</div></th>
               <th><div class="td_wrapp">2st Term Result</div></th>
               <th><div class="td_wrapp">3st Term Result</div></th>
               <th><div class="td_wrapp">Automatically Calculated Average</div></th>
               <th><div class="td_wrapp">Automatically Calculated Rank in Class</div></th>
            </tr> 
        </thead>
        <tbody>
            <?php $sbjcts    = array() ?>
            <?php $sum_perc = 0 ?>
            <?php $count_rcrds = 0 ?>
            <?php $count_perc = 0 ?>
            <?php foreach ($subjects_records as $subject): ?>
            <?php $sbjcts[] = $subject->id ?>
            <?php if(!empty($subject->parent_subject) && !(isset($subject_parent) && $subject->parent_subject == $subject_parent)): ?>
                <?php $subject_parent = $subject->parent_subject ?>
                <tr>
                    <td style="background-color: gainsboro"><?php echo $subject->parent_subject ?></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                    <td class="total"></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td><?php echo $subject->subject ?></td>
                <?php $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all(); ?>
                <?php if(count($records) > 0): ?>
                    <?php $count_rcrds++ ?>
                    <?php $rcrds = array() ?>
                    <?php foreach($records as $record): ?>
                        <?php $rcrds[$record->order] = $record ?>
                    <?php endforeach; ?>
                    <?php $type = Helper_Main::getRatingType($records[0]) ?>
                    <?php for($i = 1; $i <= 3; $i++): ?>
                        <?php if(!empty($rcrds[$i])): ?>
                            <td>
                                <div id="actions">
                                    <?php echo Helper_Main::getRatingFromRecord($rcrds[$i]) ?>
                                    <? if($role != 'student'):?>
                                        <button name="delete" value="<?php echo $student->student_id ?>&<?php echo $year ?>" data-toggle="modal" href="#deleteRecordModal" 
                                                class="action-button academic_delete_button">
                                            <input type="hidden" id="record_id" value="<?php echo $rcrds[$i]->id ?>">
                                            <a  href="#" title="Delete">
                                                <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png">
                                            </a>
                                        </button>
                                    <? endif?>
                                </div>
                            </td>
                        <?php else: ?>
                            <td>-</td>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php $avg_rank = Model_Record_Academic::getAvgRank($student->student_id, $subject->id, $period, $type) ?>
                    <?php if($type == 'percentage'): ?>
                        <?php $count_perc++ ?>
                        <?php $sum_perc += $avg_rank ?>
                    <?php endif; ?>
                    <td><?php echo $avg_rank ?></td>
                    <td><?php echo Model_Record_Academic::getStudentRank($student->student_id, $subject->id, $period, $type) ?></td>
                <?php else: ?>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td class="total"></td>
                <td class="total"></td>
                <td class="total"></td>
                <td>TOTAL</td>
                <td>
                <?php if($count_rcrds > 0): ?>
                    <?php echo Model_Record_Academic::getTotal($student->student_id, $year, $class, $period, $count_perc == 0 ? 0 : round($sum_perc / $count_perc, 1), $user, $current_class) ?>
                <?php endif; ?>
                </td>
                <td><?php echo Model_Record_Academic::getTotalStudentRank($student->student_id, $sbjcts, $subjects_records, $period) ?></td>
            </tr>
        </tbody>
    </table>
</fieldset>