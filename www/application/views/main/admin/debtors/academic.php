<div class="box_c">
    <h3 class="box_c_heading cf">
        <span class="fl">Academic Debtors</span>
        <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr square_x_11 wRemove" />
        <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle" />
    </h3>
    <div class="box_c_content cf">
        <ul class="summary_list">
            <li class="deb-style">
                <div id="count_academic_debtors">
                    <span class="<?=($academic_debtors_count == 0)? '': 'count_el'?> toggle_academic_debtors">
                        <?=$academic_debtors_count?>
                    </span> teachers
                    <img src="http://dandiigo.loc/laguadmin/images/blank.gif" alt="" class="toggle_academic_debtors fr switch_arrows_a wToogle">
                </div>
            </li>
            <div id="academic_debtors" class="formEl_a" style="display: none;">
                <? foreach ($debtors as $debtor):?>
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
                <? endforeach;?>
            </div>
        </ul>
    </div>
</div>