<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>admin/admins/tab">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'tab')? 'class="micro-active"': ''?>>
                <span>Tab Admins</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/admins/create">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'create')? 'class="micro-active"': ''?>>
                <span>Create Admin</span>
            </h4>
        </a>
    </div>
</div>