<? foreach ($debtor['classes'] as $class):?>
                        <fieldset>
                            <legend>
                                <?=$class['level'].' - '.$class['class_name']?>
                            </legend>
                            <table id="table_financial_debtors" 
                                   style="text-align: center;" 
                                   cellpadding="0" 
                                   cellspacing="0" 
                                   border="0" class="table_a smpl_tbl">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <td style="width: 130px">Student</td>
                                        <td>Subject</td>
                                        <td style="width: 60px;">Period</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? $i = 1;?>
                                    <? foreach ($class['students'] as $student):?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><a href="<?=URL::base()?>sadmin/financialrecords/list/<?=$student['student_id']?>">
                                            <?=$student['name'].' '.$student['fathername'].' '.
                                                $student['grandfathername']?>
                                            </a>
                                        </td>
                                        <td>
                                            <? foreach ($student['subjects'] as $subject):?>
                                                <div><?=$subject['name']?>></div>
                                            <? endforeach;?>
                                        </td>
                                        <td>
                                            <? foreach ($student['orders'] as $order):?>
                                                <div><?=$order['current_order'].' '.$order['period']?></div>
                                            <? endforeach;?>
                                        </td>
                                    </tr>
                                    <? $i++;?>
                                    <? endforeach;?>
                                </tbody>
                            </table>
                        </fieldset>
                    <? endforeach;?>