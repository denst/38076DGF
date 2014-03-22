<div id="tab-1">
    <div id="contact_slider" class="slidernav">
            <div class="slider-content">
                <ul>
                    <?php $level = '';
                          $close_level = false;  
                    ?>
                    <?php foreach ($teachers as $teacher): ?>
                        <? $teacher_level = strtolower($teacher->name[0]); ?>
                        <?php if($level != $teacher_level): ?>
                            <? if($close_level):?>
                                </ul></li>
                            <? endif?>
                            <?php $level = $teacher_level;
                                  $close_level = true;
                            ?>
                                <li id="<?=$level?>"><a name="<?=$level?>" class="title"><?=$level?></a>
                                    <ul>
                        <?php endif; ?>
                        <li><a href="<?=URL::base()?><?=$role?>/teachers/view/<?=$teacher->id?>">
                            <img class="sepV_b" alt="" src="<?=(Valid::not_empty($teacher->image))?
                                URL::base().'files/users/'.$teacher->teacher_id.'/26x26/'.$teacher->image: 
                                '/laguadmin/images/user_noPhoto26.gif'?>" />
                            <span><? echo $teacher->name ?> <?php echo $teacher->fathername?> <?php echo $teacher->grfathername?></span>
                            </a>
                        </li>
                    <? endforeach;?>
                </ul>
                                    
            </div>
    </div>
</div>