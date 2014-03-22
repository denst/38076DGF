<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Dashboard extends Controller_Student_App {

    public function before() 
    {
        parent::before();
        $this->objects['dashboard']->set_breadcrumb();
    }
    
    public function action_index()
    {
        $this->objects['dashboard']->action_index();
    }
}