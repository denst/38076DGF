    <div id="slide_wrapper">
        <div id="slide_panel" class="wrapper">
            <div id="slide_content">
                <span id="slide_close"><img src="<?=URL::base()?>/laguadmin/images/blank.gif" alt="" class="round_x16_b" /></span>

				<div class="cf">
					<div class="dp100 sortable"><p class="s_color tac sepH_a">You can drag widgets from dashboard and drop it here.</p></div>
				</div>

				<div class="row cf">
					<div class="dp75 taj">
                        <h4 class="sepH_b">Lorem ipsum dolor sit amet...</h4>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam enim diam, vulputate vitae pharetra vel, pretium dictum ligula. In mauris eros, aliquam sit amet ullamcorper id, dictum eget ipsum. Nulla non porta arcu. Pellentesque faucibus, erat id interdum accumsan, neque magna ultrices ante, at laoreet lorem sem sit amet risus. Proin quis turpis ac nulla faucibus luctus at ac nisl. Suspendisse adipiscing turpis non risus tempus sit amet rhoncus est luctus. Cras in accumsan nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam enim diam, vulputate vitae pharetra vel, pretium dictum ligula. In mauris eros, aliquam sit amet ullamcorper id, dictum eget ipsum. Nulla non porta arcu. Pellentesque faucibus, erat id interdum accumsan, neque magna ultrices ante, at laoreet lorem sem sit amet risus. Proin quis turpis ac nulla faucibus luctus at ac nisl. Suspendisse adipiscing turpis non risus tempus sit amet rhoncus est luctus. Cras in accumsan nulla.
                    </div>
					<div class="dp25">
                        <div id="chart_k"></div>
                    </div>
				</div>
            </div>
        </div>
    </div>    
    <div id="top_bar">
        <div class="wrapper cf">
            <ul class="fl">
                <li class="sep">Welcome <?=$role?></li>
                <li><a href="<?=URL::base()?>session/logout">Logout</a></li>
            </ul>
            <? if($role == 'sadmin'):?>
                <ul class="new_items fr">
                    <? if(isset($approved_students)):?>
                        <? if($approved_students > 0):?>
                            <li class="sep"><span class="count_el"><?=$approved_students?></span> 
                                <a href="<?=URL::base()?>sadmin/students/tab">new students</a>
                            </li>
                        <? endif?>
                        <? if($approved_teachers > 0):?>
                            <li class="sep"><span class="count_el"><?=$approved_teachers?></span> 
                                <a href="<?=URL::base()?>sadmin/teachers/tab">new teachers</a>
                            </li>
                        <? endif?>
                        <? if($approved_admins > 0):?>
                        <li class="sep"><span class="count_el"><?=$approved_admins?></span> 
                            <a href="<?=URL::base()?>sadmin/admins/tab">new admins</a>
                        </li>
                        <? endif?>
                        <!--<li><span class="count_el">4</span> <a href="#">tasks</a></li>-->
                        <!--<li id="slide_open">sliding panel<img src="<? // echo URL::base()?>images/blank.gif" alt="" class="arrow_down_a" /></li>-->
                </ul>
                <? endif;?>
            <? endif;?>
        </div>
    </div>