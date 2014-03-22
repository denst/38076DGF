<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Responsibilities extends Controller_Teacher_App {
    
    public function before() 
    {
        $this->is_set_object = true;
        $this->set_custome_object('teachers');
        parent::before();
        $this->objects['teachers']
            ->set_breadcrumb_current('Current Responsibilities', 
                $this->request->param('id'));
        $this->objects['teachers']->set_breadcrumb();
    }

    public function action_current()
    {
        $this->objects['teachers']->set_sidebar_path('layouts/sidebars/teacher/profile');
        $this->objects['teachers']->set_sidebar_index('responsibilities');
        $this->objects['teachers']->safe_id();
        $this->objects['teachers']->action_responsibilities();
    }
}