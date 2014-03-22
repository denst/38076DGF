<? $conttroller = Request::initial()->controller();?>
<ul class="fr cf" id="main_nav">
    <li class="nav_item <?=($conttroller == 'dashboard')? 'active': ''?> lgutipL" 
        title="Dashboard">
        <a href="<?=URL::base()?>sadmin/dashboard" class="main_link">
            <img class="img_holder" id="dashboard_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Dashboard</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'students' OR
                $conttroller == 'achievementstudents' OR
                $conttroller == 'disciplinarystudents' OR
                $conttroller == 'academicrecords' OR
                $conttroller == 'financialrecords'
        )? 'active': ''?> lgutipL" 
        title="Studenst">
        <a href="<?=URL::base()?>sadmin/students/tab" class="main_link">
            <img class="img_holder" id="studenst_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Studenst</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'teachers' OR
            $conttroller =='achievementteachers' OR
            $conttroller =='disciplinaryteachers'
        )? 'active': ''?> lgutipL" 
        title="Teachers">
        <a href="<?=URL::base()?>sadmin/teachers/tab" class="main_link">
            <img class="img_holder" id="teachers_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Teachers</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'admins')? 'active': ''?> lgutipL" 
        title="Administration">
        <a href="<?=URL::base()?>sadmin/admins/tab" class="main_link">
            <img class="img_holder" id="administration_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Administration</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
    <li class="nav_item <?=($conttroller == 'levels' OR 
                $conttroller == 'subjects' OR
                $conttroller == 'classes' OR
                $conttroller == 'academicperiod'
            )? 'active': ''?> lgutipL" 
        title="Settings">
        <a href="<?=URL::base()?>sadmin/levels/list" class="main_link">
            <img class="img_holder" id="settings_image" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif"/>
            <span>Settings</span>
        </a><img class="tick tick_a" alt="" src="<?=URL::base()?>laguadmin/images/blank.gif" />
    </li>
</ul>