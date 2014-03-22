<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/achievementstudents/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'list')? 'class="micro-active"': ''?>>
                <span>Achievement Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/achievementstudents/create/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'create')? 'class="micro-active"': ''?>>
                <span>Create Achievement Record</span>
            </h4>
        </a>
    </div>
</div>