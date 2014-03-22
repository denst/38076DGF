<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>admin/teachers/slider">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'slider')? 'class="micro-active"': ''?>>
                <span>Slider Teachers</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/teachers/tab">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'tab')? 'class="micro-active"': ''?>>
                <span>Tab Teachers</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/teachers/create">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'create')? 'class="micro-active"': ''?>>
                <span>Create Teacher</span>
            </h4>
        </a>
    </div>
</div>