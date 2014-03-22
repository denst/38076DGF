<div class="box_c">
    <h3 class="box_c_heading cf">
        <span class="fl">Financial Debtors</span>
        <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr square_x_11 wRemove" />
        <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle" />
    </h3>
    <div class="box_c_content cf">
        <ul class="summary_list">
            <li class="deb-style">
                <div id="count_fin_debtors">
                    <span class="<?=($financial_debtors_count == 0)? '': 'count_el'?> toggle_fin_debtors">
                        <?=$financial_debtors_count?>
                    </span> students
                    <img src="http://dandiigo.loc/laguadmin/images/blank.gif" alt="" class="toggle_fin_debtors fr switch_arrows_a wToogle">
                </div>
            </li>
            <div id="financial_debtors" class="formEl_a" style="display: none;">
                <? $id = 1;?>
                <? foreach ($financial_debtors_classes as $class):?>
                    <fieldset>
                        <legend>
                            <?=$class['level'].' - '.$class['class_name']?>
                            <div id="financial_<?=$id?>" class="toggle_financial_class">
                                <img src="http://dandiigo.loc/laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle">
                            </div>
                        </legend>
                        <table id="class_financial_<?=$id?>"
                               style="text-align: center;" 
                               cellpadding="0" 
                               cellspacing="0" 
                               border="0" class="table_a smpl_tbl">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Name</td>
                                    <td style="width: 60px;">Period</td>
                                </tr>
                            </thead>
                            <tbody>
                                <? $i = 1;?>
                                <? foreach ($class['debtors'] as $debtor):?>
                                <tr>
                                    <td><?=$i?></td>
                                    <td><a href="<?=URL::base()?>sadmin/financialrecords/list/<?=$debtor['student_id']?>">
                                        <?=$debtor['name'].' '.$debtor['fathername'].' '.
                                            $debtor['grandfathername']?>
                                        </a>
                                    </td>
                                    <td>
                                        <? foreach ($debtor['orders'] as $order):?>
                                            <div><?=$order['current_order'].' '.$order['period']?></div>
                                        <? endforeach;?>
                                    </td>
                                </tr>
                                <? $i++;?>
                                <? endforeach;?>
                            </tbody>
                        </table>
                    </fieldset>
                    <? $id++?>
                <? endforeach;?>
            </div>
        </ul>
    </div>
</div>