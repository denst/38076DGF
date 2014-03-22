<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Students extends Controller_Student_App {

    public function action_view() 
    {
        $this->objects['students']->set_fullscreen();
        $this->objects['students']->action_view();
    }
}