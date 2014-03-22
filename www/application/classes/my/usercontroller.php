<?php defined('SYSPATH') or die('No direct script access.');

class My_UserController extends My_Layout
{
    public function before()
    {
        parent::before();
        //choose main template
        $this->template = View::factory('layouts/main');
        //include common css js
        Helper_Output::factory()
            ->link_js('js/libs/jquey-1.8.2.min')
            ->link_js('js/libs/jquery-ui-1.9.2.custom.min')
            ->link_js('js/libs/underscore-min')
            ->link_css('css/style')
                
            ->link_css('laguadmin/css/style')
            ->link_js('laguadmin/js/head.load.min')
            ;
    }
}
