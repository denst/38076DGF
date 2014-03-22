<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_DisciplinaryStudents extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['disciplinarystudents']->set_records_breadcrumb('disciplinarystudents', 'students');
    }
    
    public function action_list() 
    {
        $this->objects['disciplinarystudents']->set_sidebar_index('list');
        $this->objects['disciplinarystudents']->action_list();
    }
    
    public function action_create() 
    {
        $this->objects['disciplinarystudents']->action_create();
    }
    
    public function action_edit() 
    {
        $this->objects['disciplinarystudents']->action_edit();
    }
    
    public function action_delete() 
    {
        $this->objects['disciplinarystudents']->action_delete();
    }
}
  