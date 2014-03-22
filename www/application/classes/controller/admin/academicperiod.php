<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AcademicPeriod extends Controller_Admin_App {
    
    public function action_index()
    {
        $this->objects['academicperiod']->action_index();
    }
}