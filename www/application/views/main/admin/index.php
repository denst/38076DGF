<div class="cf">
    <div class="dp50 sortable">
        <div class="box_c">
            <h3 class="box_c_heading cf">
                <span class="fl">User info</span>
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr square_x_11 wRemove" />
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle" />
            </h3>
            <div class="box_c_content cf">
                <img src="<?=URL::base()?>laguadmin/images/user_noPhoto46.gif" alt="" class="fl sepV_b"/>
                <p class="sepH_a">You are loged in as: <a href="#"><strong><?=$role?></strong></a></p>
                <p class="small">Last login: <?=date("m.d.y", $user->last_login)?></p>
                <p class="small">Total numbers of logins: <?=$user->logins?></p>
            </div>
        </div>
        
        <div class="box_c">
            <h3 class="box_c_heading cf">
                <span class="fl">Summary</span>
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr square_x_11 wRemove" />
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle" />
            </h3>
            <div class="box_c_content cf">
                <ul class="summary_list">
                    <? if(isset($count_students)):?>
                        <li><span><?=$count_students?></span> students</li>
                    <? endif?>
                    <? if(isset($count_teachers)):?>
                        <li><span><?=$count_teachers?></span> teachers</li>
                    <? endif?>
                    <? if(isset($count_admins)):?>
                        <li><span><?=$count_admins?></span> admins</li>
                    <? endif?>
                </ul>
            </div>
        </div>
        
    </div>

    <div class="dp50 sortable">
        
        <? if(isset($financial_debtors)){
            echo $financial_debtors;
        }?>
        
        <? if(isset($academic_debtors)){
            echo $academic_debtors;
        }?>
        
    </div>
</div>

<div class="cf">
    <div class="sortable dp100"></div>
</div>
