<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Admins extends Controller_Sadmin_App {
    
    private $data  = array();
    
    public function before()
    {
        parent::before();
        $this->data['levels']   = Model::factory('level')->get_levels();
    }
    
    /*
     * Show all students
     */
    public function action_index()
    {
        $data = $this->data;
        $data['admins'] = Model::factory('admin')->get_admins();
        $data['user'] = $this->logget_user;
        $data['role'] = $this->role;
        $data['table'] = View::factory('admins/table', $data);
        $data['create_admin'] = View::factory('admins/create_edit', $data);
        $this->setTitle('Admins')
                ->view('admins/index', $data)
                ->render();
    }
    
    /*
     * View current student
     */
    public function action_view()
    {
        $user_id = $this->request->param('id');
        if(Valid::not_empty($user_id))
        {
            $data = $this->data;
            if(($data['user'] = Model::factory('student')->get_student_by_id($user_id)))
            {
                $data['user_data'] = Helper_Main::unserializeData(Helper_User::getUserData($data['user'])->as_array());
                $this->setTitle('Edit student')
                    ->view('admins/view', $data)
                    ->render();
                return;
            }
        }
        throw new HTTP_Exception_404;
    }

    /*
     * Edit student
     */
    public function action_edit()
    {
        if($this->request->post())
        {
            if(Model::factory('admin')->edit_admin($this->request->post()))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/admins');
            }
        }
        
        $user_id = $this->request->param('id');
        if(Valid::not_empty($user_id))
        {
            $data = $this->data;
            if(($data['user'] = Model::factory('auth_user')->get_user_by_id($user_id)))
            {
                $data['user_data'] = Helper_Main::unserializeData(Helper_User::getUserData($data['user'])->as_array());
                $data['role'] = $data['user']->roles->find()->name;
                $data['edit'] = true;
                Helper_Output::factory()
                        ->link_js('/js/laguadmin/users_edit');
                $this->setTitle('Edit Administration')
                        ->view('admins/create_edit', $data)
                        ->render();
                return;
            }
        }
        throw new HTTP_Exception_404;
    }
    
    /*
     * Create new student 
     */
    public function action_create()
    {
        if ($this->request->post()) 
        {
            if(Model::factory('admin')->create_admin($this->request->post()))
                $this->request->redirect('sadmin/admins');
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete student 
     */
    public function action_delete() 
    {
        $user_id = $this->request->param('id');
        if(Valid::not_empty($user_id))
        {
            if(Model::factory('admin')->delete_admin($user_id))
                $this->request->redirect('sadmin/admins');
        }
        throw new HTTP_Exception_404;
    }
    
    public function action_approve()
    {
        $user_id = $this->request->param('id');
        if(Valid::not_empty($user_id) and Valid::numeric($user_id))
        {
            if(Model::factory('admin')->approve_admin($user_id))
            {
                Helper_Message::add('success', 'User ​​approve successfully');
                return $this->request->redirect('sadmin/admins');
            }
        }
        throw new HTTP_Exception_404;
    }
}