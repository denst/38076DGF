<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Students extends Controller_Sadmin_Users {
    
    public function before()
    {
        parent::before();
        $this->set_user_role('student');
        $this->set_user_sidebar();
        $this->data['students'] = Model::factory('student')->get_students();
        $this->data['levels']   = Model::factory('level')->get_levels();
    }
    
    public function action_create() 
    {
        Helper_Output::factory()
            ->link_js('/js/user/students')
            ->link_js('/js/ajaximage/ajaximage');
        parent::action_create();
    }
    
    public function action_edit() {
        Helper_Output::factory()
            ->link_js('/js/laguadmin/users_edit')
            ->link_js('/js/user/students');
        parent::action_edit();
    }
}