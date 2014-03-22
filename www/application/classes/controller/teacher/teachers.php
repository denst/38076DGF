<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Teachers extends Controller_Teacher_App {
    
    public function action_view()
    {
        $this->objects['teachers']->set_fullscreen();
        $this->objects['teachers']->action_view();
    }
}