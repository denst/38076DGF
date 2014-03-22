<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Classes extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['classes']->set_breadcrumb_parent('students');
        $this->objects['classes']->set_breadcrumb_parent('levels');
        $this->objects['classes']->set_breadcrumb_current('Class View', $this->request->param('id'));
        $this->objects['classes']->set_breadcrumb();
    }
    
    public function action_view()
    {
        $this->objects['classes']->set_sidebar_path('layouts/sidebars/teacher/students');
        $this->objects['classes']->set_sidebar_index('levels');
        $this->objects['classes']->action_view();
    }
}