<div id="tab-1">
    <div id="students_slider" class="slidernav">
            <div class="slider-content">
                <ul>
                    <?php $level = '';
                          $close_level = false;  
                    ?>
                    <?php foreach ($students as $student): ?>
                        <? $student_level = strtolower($student->level_name); ?>
                        <?php if($level != $student_level): ?>
                            <? if($close_level):?>
                                </ul></li>
                            <? endif?>
                            <?php $level = $student_level;
                                  $close_level = true;
                            ?>
                                <li id="<?=$level?>"><a name="<?=$level?>" class="title"><?=$level?></a>
                                    <ul>
                        <?php endif; ?>
                        <li><a href="<?=URL::base()?>teacher/students/view/<?=$student->id?>">
                            <img class="sepV_b" alt="" src="<?=URL::base()?>laguadmin/images/user_noPhoto26.gif">
                            <span><? echo $student->fathername ?> <?php echo $student->name?> <?php echo $student->grfathername?></span>
                            </a>
                        </li>
                    <? endforeach;?>
                </ul>
            </div>
    </div>
</div>