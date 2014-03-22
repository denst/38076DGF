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
                        <li><a href="<?=URL::base()?><?=$role?>/students/view/<?=$student->id?>">
                            <img class="sepV_b" alt="" src="<?=(Valid::not_empty($student->image))?
                                URL::base().'files/users/'.$student->student_id.'/26x26/'.$student->image: 
                                '/laguadmin/images/user_noPhoto26.gif'?>" />
                             <span> <?php echo $student->name?>  <? echo $student->fathername ?> <?php echo $student->grfathername?></span>
                            </a>
                        </li>
                    <? endforeach;?>
                </ul>
            </div>
    </div>
</div>