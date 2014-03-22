<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Academic extends Controller_Student_App {
    
    public function action_index() 
    {
        Helper_Output::factory()
                ->link_js('js/laguadmin/dashboard');
        $this->setTitle('Main')
                ->set_template_content(array("fullscreen" => true))
                ->view('main/index')
                ->render();
    }
}