<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>student/achievementstudents/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'achievementstudents')? 'class="micro-active"': ''?>>
                <span>Achievement Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>student/academicrecords/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'academic')? 'class="micro-active"': ''?>>
                <span>Academic Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>student/disciplinarystudents/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'disciplinarystudents')? 'class="micro-active"': ''?>>
                <span>Disciplinary Records</span>
            </h4>
        </a>
    </div>
</div>