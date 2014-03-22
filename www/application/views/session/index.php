<div id="register-block">
<? $action = Request::initial()->action();?>
    <div class="login_wrapper <?=$action?>">
        <div class="loginBox">
            <div class="heading cf">
                <ul class="login_tabs fr cf">
                    <li><a <?=($action == 'index')? 'class="current"': ''?> 
                        href="/">Login</a></li>
                    <li><a <?=($action == 'registerstudent')? 'class="current"': ''?> 
                        href="<?=URL::base()?>student-registration">Register Student</a></li>
                    <li><a <?=($action == 'registerteacher')? 'class="current"': ''?> 
                        href="<?=URL::base()?>teacher-registration">Register Teacher</a></li>
                    <li><a <?=($action == 'registeradmin')? 'class="current"': ''?> 
                        href="<?=URL::base()?>admin-registration">Register Administrator</a></li>
                    <li style="display:none"><a href="#password">Forgoten password</a></li>
                </ul>
            </div>
                <div class="content">
                    <div class="login_panes formEl_a">
                        <div>
                            <? if(isset($content))
                                echo $content?>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<? if(isset($set_footer)):?>
<div id="footer">
    <div class="wrapper">
           <div class="cf ftr_content">
                 <a href="javascript:void(0)" class="toTop">Back to top</a>
           </div>
    </div>
 </div>
<? endif;?>