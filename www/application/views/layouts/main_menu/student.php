<? $conttroller = Request::initial()->controller();?>
<ul class="fr cf" id="main_nav">
    <li class="nav_item <?=($conttroller == 'dashboard' OR
                $conttroller == 'students'
        )? 'active': ''?> lgutipL" 
        title="Dashboard">
        <a href="<?=URL::base()?>student/dashboard" class="main_link">
            <img class="img_holder" id="dashboard_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Dashboard</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'financialrecords')? 'active': ''?> lgutipL" 
        title="Studenst">
        <a href="<?=URL::base()?>student/financialrecords/list/<?=$id?>" class="main_link">
            <img class="img_holder" id="finance_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Finance</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'profile' OR
                $conttroller == 'achievementstudents' OR 
                $conttroller == 'academicrecords' OR
                $conttroller == 'disciplinarystudents' 
        )? 'active': ''?> lgutipL" 
        title="Profile">
        <a href="<?=URL::base()?>student/achievementstudents/list/<?=$id?>" class="main_link">
            <img class="img_holder" id="profile_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Profile</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
</ul>