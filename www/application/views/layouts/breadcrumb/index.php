<ul id="breadcrumbs" class="xbreadcrumbs cf">
         <li class="parent">
             <img src="<?=  URL::base()?>laguadmin/images/blank.gif" alt="" class="sepV_a vam home_ico" />
             <a href="<?=URL::base()?>" class="vam">Dandiigo</a>
             <? if(isset($breadcrumb_main_menu))
                    echo $breadcrumb_main_menu;
             ?>
         </li>
         <? if(isset($breadcrumb_parents)){
             foreach ($breadcrumb_parents as $parent) {
                 echo $parent;
             } 
         }?>
         
         <li class="current">
             <? if(isset($breadcrumb_id)):?>
                <a href="<?=URL::base().$role.'/'.$breadcrumb_value['controller'].
                   '/'.$breadcrumb_value['action'].'/'.$breadcrumb_id?>">
             <? else:?>
                <a href="<?=URL::base().$role.'/'.$breadcrumb_value['controller'].
                   '/'.$breadcrumb_value['action']?>">
             <? endif?>
               <?=(isset($breadcrumb_current))? $breadcrumb_current:
                 Text::ucfirst($breadcrumb_value['controller'])?>
             </a>
         </li>
 </ul>