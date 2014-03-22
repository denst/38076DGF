<div id="main">
    <div class="wrapper">
        <div id="main_section" class="cf brdrrad_a">
            <div id="content_wrapper">
                <div id="main_content">
                    <?php if(count($levels) > 0): ?>
                    <?php if(!empty($years->max_year)): ?>
                        <form name="form_year" id="form_year" action="<?php echo URL::base() ?>levels/list" style="float: right">
                            <select name="year" id="year">
                                <?php for($i = 2; $i <= $years->max_year; $i++): ?>
                                    <option <?php echo $i == $year ? 'selected' : '' ?> value="<?php echo $i ?>"><?php echo ORM::factory('academicyear', $i)->name ?>/<?php echo ORM::factory('academicyear', $i + 1)->name ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    <?php endif; ?>
                    <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>A</th>
                                    <th>B</th>
                                    <th>C</th>
                                    <th>D</th>
                                    <th>E</th>
                                    <th>F</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($levels as $level): ?>
                                <tr>
                                    <th><?php echo $level->name ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'A', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'A', $year) . '">View</a>' : '-' ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'B', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'B', $year) . '">View</a>' : '-' ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'C', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'C', $year) . '">View</a>' : '-' ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'D', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'D', $year) . '">View</a>' : '-' ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'E', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'E', $year) . '">View</a>' : '-' ?></th>
                                    <th><?php echo Helper_Main::getClass($level, 'F', $year) ? '<a href="' . URL::base() . 'classes/view/' . Helper_Main::getClass($level, 'F', $year) . '">View</a>' : '-' ?></th>
                                    <th>
                                        <a href="<?php echo URL::base() ?>levels/edit/<?php echo $level->id ?>/<?php echo $year ?>">Edit</a>
                                        /
                                        <?php if(Helper_User::getUserRole($user) == 'sadmin'): ?>
                                        <a onclick="if(!confirm('Really delete?')) return false" href="<?php echo URL::base() ?>levels/delete/<?php echo $level->id ?>">Delete</a>
                                        /
                                        <?php endif; ?>
                                        <a href="<?php echo URL::base() ?>levels/unassigned-students/<?php echo $level->id ?>/<?php echo $year ?>">Unassigned students</a>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                    </table>
                    <?php else: ?>
                        <p>The levels are not found</p>
                    <?php endif; ?>
                    <?php if(Helper_User::getUserRole($user) == 'sadmin'): ?>
                        <a href="<?php echo URL::base() ?>levels/new/<?php echo $year ?>">Create level</a>
                    <?php endif;?>
                </div>
            </div>
            
        </div>
    </div>
</div>