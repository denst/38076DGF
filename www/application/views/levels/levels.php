<div id="tab-1">
    <div id="level-block">
        <?php if(count($levels) > 0): ?>
        <?php if(!empty($years->max_year)): ?>
            <div id="class_years">
                <form name="form_year" id="form_year" action="<?php echo URL::base() ?><?=$role?>/levels/list">
                    <div class="formEl_b">
                        <div class="sepH_b">
                            <span>Years of study:</span>
                            <select name="year" id="b_select" class="year">
                                <?php for($i = 2; $i <= $years->max_year; $i++): ?>
                                    <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
        <table class="table table-classes">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>F</th>
                        <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <th style="width: 20%">Actions</th>
                        <? endif;?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($levels as $level): ?>
                    <tr>
                        <th class="name"><?php echo $level->name ?></th>
                        <? $class_numbers = array('A', 'B', 'C', 'D', 'E', 'F');
                        foreach ($class_numbers as $class_number):
                            $class = Helper_Main::getClass($level, $class_number, $year);
                            $students_in_class = Model::factory('student')
                                    ->get_students_of_class($class)->count();?>
                            <th>
                                <?=($class)? 
                                    '<a href="'.URL::base().$role.'/classes/view/'.$class.'">'
                                       .$level->name.' - '.$class_number.
                                      ' <span class="students_count">'.$students_in_class.'</span>'.'</a>' :
                                   '-' ?>
                            </th>
                        <?endforeach;?>
                        <? if($role == 'sadmin' OR $role == 'admin'):?>
                        <th>
                            <div id="actions">
                                <a href="<?php echo URL::base() ?><?=$role?>/levels/edit/<?php echo $level->id ?>&<?php echo $year ?>" class="sepV_a" title="Edit">
                                    <button class="action-button">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/pencil_gray.png" alt="" />
                                    </button>
                                </a>

                                <button name="delete" value="<?=$level->id?>" data-toggle="modal" href="#deleteLevelModal" 
                                    class="action-button level_delete_button">
                                    <a href="" title="Delete">
                                        <img src="<?=URL::base()?>laguadmin/images/icons/trashcan_gray.png" alt="" />
                                    </a> 
                                </button>
                                <? $set_unassigned_students = ($unassigned_students[$level->id] > 0)? true: false;?>
                                <a <?=($set_unassigned_students)? 'class="count_el"': ''?> 
                                    href="<?php echo URL::base() ?><?=$role?>/levels/unassignedstudents/<?php echo $level->id ?>&<?php echo $year ?>">
                                    <?=($set_unassigned_students)? $unassigned_students[$level->id]: 'Unassigned students'; ?>
                                </a>
                            </div>
                        </th>
                        <? endif;?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
        </table>
        <?php else: ?>
            <p>The levels are not found</p>
        <?php endif; ?>
    </div>
</div>
<br/>
<? if($role == 'sadmin' OR $role == 'admin'):?>
    <a href="<?=URL::base()?><?=$role?>/levels/create/<?=$year?>">
        <button type="submit" class="btn btn_dL sepH_b">Create Level</button>
    </a>
<? endif?>
<div style="display: none;" class="modal hide" id="deleteLevelModal">
    <div class="tac">
        <form action="<?=URL::base()?><?=$role?>/levels/delete" method="post">
            <input id="delete_level_id" type="hidden" name="level_id" value="" />
            <p class="sepH_b">Are you sure you want to delete level?</p>
            <button type="submit" id="clear_yes" class="btn btn_d sepV_a">Yes</button>
            <button id="clear_no" class="btn btn_a" data-dismiss="modal">No</button >
        </form>
    </div>
</div>