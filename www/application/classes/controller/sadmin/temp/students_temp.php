<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Students extends Controller_Sadmin_App {
    
    private $data  = array();
    
    public function before()
    {
        parent::before();
        $this->data['levels']   = Model::factory('level')->get_levels();
        $this->data['user'] = $this->logget_user;
        $this->data['students'] = Model::factory('student')->get_students();
//        $this->data['breadcrumb'] = View::factory('layouts/breadcrumb');
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/students');
    }
    
    /*
     * Show slider students
     */
    public function action_slider()
    {
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'slider');
        $this->setTitle('Students')
            ->view('students/slider', $data)
            ->render();
    }
    
    /*
     * Show Tab students
     */
    public function action_tab()
    {
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'tab');
        unset($data['sidebar']);
        $this->setTitle('Students')
            ->set_template_content(array("fullscreen" => true))
            ->view('students/table', $data)
            ->render();
    }
    
    /*
     * View current student
     */
    public function action_view()
    {
        if(($data = $this->check_user($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $this->setTitle('Students')
                ->view('students/view', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Create new student 
     */
    public function action_create()
    {
        if (Valid::not_empty($_POST)) 
        {
            if(Model::factory('student')->create_student($_POST))
                $this->request->redirect('sadmin/students/tab');
        }
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'create');
        Helper_Output::factory()
            ->link_js('/js/user/students')
            ->link_js('/js/ajaximage/ajaximage');
        $this->setTitle('Create Student')
            ->view('students/create_edit', $data)
            ->render();
    }

    /*
     * Edit student
     */
    public function action_edit()
    {
        if($this->request->post())
        {
            if(Model::factory('student')->edit_student($this->request->post()))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/students');
            }
        }
        
        if(($data = $this->check_user($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['edit'] = true;
            Helper_Output::factory()
                ->link_js('/js/laguadmin/users_edit')
                ->link_js('/js/user/students');
            $this->setTitle('Edit student')
                    ->view('students/create_edit', $data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete student 
     */
    public function action_delete()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('student')->delete_student($_POST['student_id']))
            {
                Helper_Message::add('success', 'Student deleted successfully');
                $this->request->redirect('sadmin/students/tab');
            }
        }
        throw new HTTP_Exception_404;
    }
    
    /*
     * Approve student 
     */
    public function action_approve()
    {
        if(($data = $this->check_user($this->request->param('id'))))
        {
            if(Model::factory('student')->approve_student($data['user']->id))
            {
                Helper_Message::add('success', 'User approved successfully');
                return $this->request->redirect('sadmin/students');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Check user 
     */
    private function check_user($param)
    {
        if(Valid::numeric($param))
        {
            if(($data['user'] = Model::factory('auth_user')->get_user_by_id($param)))
            {
                $data['user_data'] = Helper_Main::unserializeData(
                        Helper_User::getUserData($data['user'])->as_array());
                return $data;
            }
        }
        return false;
    }
}