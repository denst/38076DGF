<fieldset>
                    <? $id = 1;?>
                    <? foreach ($debtor['classes'] as $class):?>
                        <fieldset>
                            <legend>
                                <div style="text-align: center">
                                    <?=$class['level'].' - '.$class['class_name']?>
                                </div>
                                <div class="home_room_debtor">Home Room Teacher:
                                <?= $debtor['name'].' '.$debtor['fathername'].' '.
                                                        $debtor['grfathername']?>
                                </div>
                                <div id="academic_<?=$id?>" class="toggle_academic_class">
                                    <img src="http://dandiigo.loc/laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle">
                                </div>
                            </legend>
                            <table id="class_academic_<?=$id?>"
                                   style="text-align: center;" 
                                   cellpadding="0" 
                                   cellspacing="0" 
                                   border="0" class="table_a smpl_tbl">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td style="width: 130px">Student</td>
                                        <td>Subject</td>
                                        <td>Teacher</td>
                                        <td style="width: 60px;">Period</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? $i = 1;?>
                                    <? foreach ($class['students'] as $student):?>
                                        <tr>
                                            <td rowspan="<?=count($student['subjects'])?>"><?=$i?></td>
                                            <td rowspan="<?=count($student['subjects'])?>"><a href="<?=URL::base()?>sadmin/academicrecords/list/<?=$student['student_id']?>">
                                                <?=$student['name'].' '.$student['fathername'].' '.
                                                    $student['grandfathername']?>
                                                </a>
                                            </td>
                                            <? for ($i = 0; $i < count($student['subjects']); $i++):?>
                                                <td rowspan="<?=$subject_counter?>">
                                                    <?=$student['subjects'][$i]->subject?>
                                                </td>
                                                <td>
                                                    <?=$student['subjects'][$i]->teacher_name.' '.
                                                        $student['subjects'][$i]->teacher_fathername.''.
                                                        $student['subjects'][$i]->grfathername?>
                                                </td>
                                                <td>
                                                    <?=$student['subjects'][$i]->order.' '.
                                                        $student['subjects'][$i]->period?>
                                                </td>
                                        </tr>
                                        <? endfor;?>
                                    <? endforeach;?>
                                    <? $i++;?>
                                </tbody>
                            </table>
                        </fieldset>
                        <? $id++?>
                    <? endforeach;?>
                </fieldset>