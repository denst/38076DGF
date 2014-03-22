<? $conttroller = Request::initial()->controller();?>

<ul class="fr cf" id="main_nav">
    <li class="nav_item <?=($conttroller == 'dashboard' OR
                $conttroller == 'teachers'
        )? 'active': ''?> lgutipL" 
        title="Dashboard">
        <a href="<?=URL::base()?>teacher/dashboard" class="main_link">
            <img class="img_holder" id="dashboard_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Dashboard</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'students' OR
                $conttroller == 'levels' OR
                $conttroller == 'classes' OR
                $conttroller == 'academicrecords' OR
                $conttroller == 'achievementstudents' OR
                $conttroller == 'disciplinarystudents' 
        )? 'active': ''?> lgutipL" 
        title="Studenst">
        <a href="<?=URL::base()?>teacher/students/tab" class="main_link">
            <img class="img_holder" id="studenst_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Studenst</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'achievementteachers' OR
                $conttroller == 'disciplinaryteachers' OR
                $conttroller == 'responsibilities'
        )? 'active': ''?> lgutipL" 
        title="Profile">
        <a href="<?=URL::base()?><?=$role?>/responsibilities/current/<?=$id?>" class="main_link">
            <img class="img_holder" id="profile_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Profile</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
</ul>