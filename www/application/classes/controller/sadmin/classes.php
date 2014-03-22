<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Classes extends Controller_Sadmin_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['classes']->set_breadcrumb_current('Class View', $this->request->param('id'));
        $this->objects['classes']->set_breadcrumb_parent('settings');
        $this->objects['classes']->set_breadcrumb();
    }

    public function action_view()
    {
        $this->objects['classes']->set_breadcrumb_parent('levels');
        $this->objects['classes']->set_breadcrumb();
        $this->objects['classes']->set_fullscreen();
        $this->objects['classes']->action_view();
    }
    
    public function action_addsubjects()
    {
        $this->objects['classes']->action_addsubjects();
    }

    public function action_deletesubject()
    {
        $this->objects['classes']->action_deletesubject();
    }
    
    public function action_deleteallsubjects()
    {
        $this->objects['classes']->action_deleteallsubjects();
    }

    public function action_changeteacher()
    {
        $this->objects['classes']->action_changeteacher();
    }

    public function action_deletestudent()
    {
        $this->objects['classes']->action_deletestudent();
    }

    public function action_movestudent()
    {
        $this->objects['classes']->action_movestudent();
    }
}