<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_AchievementStudents extends Controller_Student_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['achievementstudents']->set_breadcrumb_parent(
                'profile', $this->request->param('id'));
        $this->objects['achievementstudents']->set_breadcrumb_current('Achievement Records', 
            $this->request->param('id'));
        $this->objects['achievementstudents']->set_breadcrumb();
    }
    
    public function action_list() 
    {
        $this->objects['achievementstudents']->set_sidebar_path('layouts/sidebars/student/records');
        $this->objects['achievementstudents']->set_sidebar_index('achievementstudents');
        $this->objects['achievementstudents']->action_list();
    }
}
  