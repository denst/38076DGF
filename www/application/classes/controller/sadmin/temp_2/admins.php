<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Admins extends Controller_Sadmin_Users {
    
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
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'tab');
        $this->setTitle('Tab admins')
            ->view('admins/table', $data)
            ->render();
    }

    /*
     * View current student
     */
    public function action_view()
    {
        $this->data['role'] = $this->get_role($this->request->param('id'));
        parent::action_view();
    }
    
    public function action_create() 
    {
        Helper_Output::factory()
            ->link_js('/js/user/admins')
            ->link_js('/js/ajaximage/ajaximage');
        parent::action_create();
    }

        public function action_edit() 
    {
        $this->data['role'] = $this->get_role($this->request->param('id'));
        parent::action_edit();
    }
    
    private function get_role($id)
    {
        if(($data = $this->check_user($id)))
            return $data['user']->roles->find()->name;
        else
            throw new HTTP_Exception_404;        
    }      
}