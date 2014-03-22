<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Layout {
    
    public function action_ajaximage()
    {
        if(Valid::not_empty($_FILES))
        {
            $name = 'photoimg';
            $ajax = Model::factory('ajax');
            if($ajax->check_image($_FILES, $name))
            {
                $txt = Text::random('alpha');
                $ext = strtolower(pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
                echo $ajax->set_profile_image($txt, $ext, $_FILES[$name]);
            }
            else
            {
                echo false;
            }
            exit();
        }   
        else
            throw new HTTP_Exception_404;
    }
}