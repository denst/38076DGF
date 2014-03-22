<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Disciplinaryteachers extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['disciplinaryteachers']
            ->set_breadcrumb_current('Disciplinary Records', 
                $this->request->param('id'));
        $this->objects['disciplinaryteachers']->set_breadcrumb();
    }

    public function action_list()
    {
        $this->objects['disciplinaryteachers']->set_sidebar_path('layouts/sidebars/teacher/profile');
        $this->objects['disciplinaryteachers']->set_sidebar_index('disciplinaryteachers');
        $this->objects['disciplinaryteachers']->safe_id();
        $this->objects['disciplinaryteachers']->action_list();
    }
}