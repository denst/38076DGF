<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Subjects extends Controller_Admin_App {
    
    public function action_changesubjects()
    {
        $this->objects['subjects']->action_changesubjects();
    }
}