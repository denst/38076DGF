<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Achievementteachers extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['achievementteachers']
            ->set_breadcrumb_current('Achievement Records', 
                $this->request->param('id'));
        $this->objects['achievementteachers']->set_breadcrumb();
    }

        public function action_list()
    {
        $this->objects['achievementteachers']->set_sidebar_path('layouts/sidebars/teacher/profile');
        $this->objects['achievementteachers']->set_sidebar_index('achievementteachers');
        $this->objects['achievementteachers']->safe_id();
        $this->objects['achievementteachers']->action_list();
    }
}