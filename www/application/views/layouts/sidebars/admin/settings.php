<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>admin/levels/list">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'grade_levels')? 'class="micro-active"': ''?>>
                <span>Grade Levels</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/subjects">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'subjects')? 'class="micro-active"': ''?>>
                <span>Subjects</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/academicperiod">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'academic-period')? 'class="micro-active"': ''?>>
                <span>Academic Period</span>
            </h4>
        </a>
    </div>
</div>