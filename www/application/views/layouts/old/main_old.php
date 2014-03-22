<!DOCTYPE HTML>
<html lang="en-US">
    <head>
    <title><?php echo $title ?></title>
    <meta charset="UTF-8">
    <script type="text/javascript">
    var SYS = {
        baseUrl : '<?php echo URL::base() ?>'
    }
    </script>

    <?php echo Helper_Output::renderCss(); ?>
    </head>
    <body>
        <?php ProfilerToolbar::render(true); ?>
        <?php echo View::factory('layouts/partials/header')->render(); ?>

        <?php echo View::factory('layouts/partials/footer')->render(); ?>
            <p>
                <a href="<?php echo URL::base() ?>">Home</a>
                <?php if(Auth::instance()->logged_in()): ?>
                    <a href="<?php echo URL::base() ?>session/logout">Logout</a>
                <?php endif; ?>
            </p>
        <?php echo $content ?>

        <?php echo Helper_Output::renderJs(); ?>
    </body>
</html>