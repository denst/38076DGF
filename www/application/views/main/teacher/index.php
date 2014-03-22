<div class="cf">
        <div class="box_c">
            <h3 class="box_c_heading cf">
                <span class="fl">User info</span>
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr square_x_11 wRemove" />
                <img src="<?=URL::base()?>laguadmin/images/blank.gif" alt="" class="fr switch_arrows_a wToogle" />
            </h3>
            <div class="box_c_content cf">
                <a href="<?=URL::base()?><?=$role?>/teachers/view/<?=$id?>">
                    <? $teacher = $user->teachers->find();?>
                    <img id="img-polaroid" class="sepV_b" alt="" src="<?=(Valid::not_empty($teacher->image))?
                        URL::base().'files/users/'.$teacher->teacher_id.'/46x46/'.$teacher->image: 
                        '/laguadmin/images/user_noPhoto26.gif'?>" />
                </a>
                <p class="sepH_a">You are loged in as: <a href="#"><strong><?=$role?></strong></a></p>
                <p class="small">Last login: <?=date("m.d.y", $user->last_login)?></p>
                <p class="small">Total numbers of logins: <?=$user->logins?></p>
            </div>
        </div>
        
</div>

<div class="cf">
    <div class="sortable dp100"></div>
</div>
