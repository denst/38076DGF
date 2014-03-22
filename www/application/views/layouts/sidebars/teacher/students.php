<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>teacher/students/slider">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'slider')? 'class="micro-active"': ''?>>
                <span>Slider Students</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>teacher/students/tab">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'tab')? 'class="micro-active"': ''?>>
                <span>Tab Students</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>teacher/students/currentclass/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'students')? 'class="micro-active"': ''?>>
                <span>Current Class Students</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>teacher/levels/list">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'levels')? 'class="micro-active"': ''?>>
                <span>Grade Levels</span>
            </h4>
        </a>
    </div>
</div>