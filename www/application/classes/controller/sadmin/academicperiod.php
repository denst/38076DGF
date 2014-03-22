<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_AcademicPeriod extends Controller_Sadmin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['academicperiod']->set_breadcrumb_current('Academic Period');
        $this->objects['academicperiod']->set_breadcrumb_parent('settings');
        $this->objects['academicperiod']->set_breadcrumb();
    }
    
    public function action_index()
    {
        $this->objects['academicperiod']->action_index();
    }
}