<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>teacher/profile">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'profile')? 'class="micro-active"': ''?>>
                <span>Profile</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>teacher/achievementteacherrecords/list">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'achievement')? 'class="micro-active"': ''?>>
                <span>Academin records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>teacher/disciplinaryteacherrecords/list">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'disciplinary')? 'class="micro-active"': ''?>>
                <span>Disciplinary records</span>
            </h4>
        </a>
    </div>
</div>