<div id="level-sidebar">
    <div class="micro">
        <a href="<?=URL::base()?>admin/academicrecords/list/<?=$student_id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'list')? 'class="micro-active"': ''?>>
                <span>Academic Records</span>
            </h4>
        </a>
    </div>
    <div class="micro">
        <a href="<?=URL::base()?>admin/academicrecords/create/<?=$student_id?>&<?=$subject_id?>">
            <h4 <?=(isset($sidebar_index) AND $sidebar_index == 'create')? 'class="micro-active"': ''?>>
                <span>Create Academic Record</span>
            </h4>
        </a>
    </div>
</div>