<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Admins extends Controller_Core_Users {
    
    public function before()
    {
        parent::before();
        $this->set_user_role('admin');
        $this->set_user_sidebar();
        $this->data['admins'] = Model::factory('admin')->get_admins();
    }
    
    /*
     * Show Tab students
     */
    public function action_tab()
    {
        $this->data['sidebar']->set('sidebar_index', 'tab');
        $this->setTitle('Tab admins')
            ->view('admins/table', $this->data)
            ->render();
    }

    /*
     * View current student
     */
    public function action_view()
    {
        parent::action_view();
    }
    
    public function action_create() 
    {
        parent::action_create();
    }

    public function action_edit() 
    {
        parent::action_edit();
    }
}