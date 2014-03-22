<div id="level-sidebar">
    <? //$sidebar_index?>
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/responsibilities/current/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'responsibilities')? 'class="micro-active"': ''?>>
                <span>Current Responsibilities</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/achievementteachers/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'achievementteachers')? 'class="micro-active"': ''?>>
                <span>Achievement Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/disciplinaryteachers/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'disciplinaryteachers')? 'class="micro-active"': ''?>>
                <span>Disciplinary Records</span>
            </h4>
        </a>
    </div>
</div>