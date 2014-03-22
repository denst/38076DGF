<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Teachers extends Controller_Sadmin_App {
    
    private $data  = array();
    
    public function before()
    {
        parent::before();
        $this->data['teachers'] = Model::factory('teacher')->get_teachers();
        $this->data['all_subjects'] = Model::factory('subject')->get_all_subjects();
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/teachers');
    }
    
    /*
     * Show slider teachers
     */
    public function action_slider()
    {
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'slider');
        $this->setTitle('Students')
            ->view('teachers/slider', $data)
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
        Helper_Output::factory()
            ->link_css('laguadmin/lib/harvesthq-chosen/chosen')
            ->link_js('js/laguadmin/teachers');
        $this->setTitle('Students')
            ->set_template_content(array("fullscreen" => true))
            ->view('teachers/table', $data)
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
            $this->setTitle('Edit student')
                ->view('teachers/view', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    /*
     * Edit student
     */
    public function action_edit()
    {
        if($this->request->post())
        {
            if(Model::factory('teacher')->edit_teacher($this->request->post()))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/teachers/tab');
            }
        }
        
        if(($data = $this->check_user($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['edit'] = true;
            Helper_Output::factory()
                ->link_js('/js/laguadmin/users_edit');
            $this->setTitle('Edit student')
                ->view('teachers/create_edit', $data)
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
        if ($this->request->post()) 
        {
            if(Model::factory('teacher')->create_teacher($this->request->post()))
                $this->request->redirect('sadmin/teachers/tab');
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete teacher 
     */
    public function action_delete() 
    {
        if(($data = $this->check_user($this->request->param('id'))))
        {
            if(Model::factory('teacher')->delete_teacher($data['user']->id))
            {
                Helper_Message::add('success', 'Teacher deleted successfully');
                $this->request->redirect('sadmin/teachers/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Associate with the Subject
     */
    public function action_associatesubject()
    {
        if($this->request->post())
        {
            if(Model::factory('subject')->associate_subjects($this->request->post()))
            {
                Helper_Message::add('success', 'New subjects associated with teacher');
                $this->request->redirect('sadmin/teachers/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Approve Teacher 
     */
    public function action_approve()
    {
        if(($data = $this->check_user($this->request->param('id'))))
        {
            if(Model::factory('teacher')->approve_teacher($data['user']->id))
            {
                Helper_Message::add('success', 'Teacher approved successfully');
                return $this->request->redirect('sadmin/teachers/tab');
            }
        }
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