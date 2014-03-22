<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="shortcut icon" href="favicon.ico" />

 <!-- <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans" type="text/css" /> -->
    <?php echo Helper_Output::renderCss(); ?>
    <?php echo Helper_Output::renderCustomJs(); ?>
</head>
<body class="bg_c sidebar fixed">
    <?php ProfilerToolbar::render(true); ?>
    <? if(isset($top_menu))
        echo $top_menu;?>

    <div id="header">
        <div class="wrapper cf">
            <div class="logo fl">
                <a href="/"><img src="<?=URL::base()?>img/logo-with-slogan.png" alt="" /></a>
            </div>
            <? if(isset($main_menu))
                echo $main_menu;?>
        </div>
    </div>
    <? if(isset($login_form) AND $login_form){
        if(Helper_Message::count() > 0)
            echo Helper_Message::output();
        echo $login_form;
        $hide_content = true;
    } ?>
    <? if(! isset($hide_content)){?>
    <div id="main">
        <div class="wrapper">
            <div id="main_section" class="cf brdrrad_a">
                <? if(Helper_Message::count() > 0) {
                    echo Helper_Message::output();
                }?>
 
                <? if(isset($breadcrumb)){
                    echo $breadcrumb;
                }?>
                
                <div id="content_wrapper">
                    <div id="<?=(isset($fullscreen) AND $fullscreen == true)? 'fullscreen': 'main_content';?>">
                        <?php echo $content ?>
                    </div>
                </div>
                <? if(isset($sidebar)){
                    echo $sidebar;
                }?>
            </div>
        </div>
    </div>
    <div id="footer">
       <div class="wrapper">
              <div class="cf ftr_content">
                  <p class="fl">Copyright &copy; <?=date('Y')?> dandiigo.com</p>
                    <a href="javascript:void(0)" class="toTop">Back to top</a>
              </div>
       </div>
    </div>
    <? }?>
</body>
<?php echo Helper_Output::renderJs(); ?>
</html>