<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_DisciplinaryStudents extends Controller_Student_App {
        
    public function before() 
    {
        parent::before();
        $this->objects['disciplinarystudents']->set_breadcrumb_parent(
                'profile', $this->request->param('id'));
        $this->objects['disciplinarystudents']->set_breadcrumb_current('Disciplinary Records', 
            $this->request->param('id'));
        $this->objects['disciplinarystudents']->set_breadcrumb();
    }
    
    public function action_list() 
    {
        $this->objects['disciplinarystudents']->set_sidebar_path('layouts/sidebars/student/records');
        $this->objects['disciplinarystudents']->set_sidebar_index('disciplinarystudents');
        $this->objects['disciplinarystudents']->action_list();
    }
}
  