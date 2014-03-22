<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/disciplinarystudents/list/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'list')? 'class="micro-active"': ''?>>
                <span>Disciplinary Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?><?=$role?>/disciplinarystudents/create/<?=$id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'create')? 'class="micro-active"': ''?>>
                <span>Create Disciplinary Record</span>
            </h4>
        </a>
    </div>
</div>