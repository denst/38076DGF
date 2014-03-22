<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Users extends Controller_Sadmin_App {
    
    private $user_role;
    protected $data  = array();

    public function before()
    {
        parent::before();
    }
    
    protected function set_user_role($user_role)
    {
        $this->user_role = $user_role;
    }
    
    protected function set_user_sidebar()
    {
        $this->data['sidebar'] = 
            View::factory('layouts/sidebars/sadmin/'.$this->user_role.'s');
    }
    
    /*
     * Show slider students
     */
    public function action_slider()
    {
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'slider');
        $this->setTitle('Slider '.Text::ucfirst($this->user_role).'s')
            ->view($this->user_role.'s/slider', $data)
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
        $this->setTitle('Tab '.Text::ucfirst($this->user_role).'s')
            ->set_template_content(array("fullscreen" => true))
            ->view($this->user_role.'s/table', $data)
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
            $this->setTitle('View '.Text::ucfirst($this->user_role))
                ->view($this->user_role.'s/view', $data)
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
            $action = 'create_'.$this->user_role;
            if(Model::factory($this->user_role)->$action($_POST))
                $this->request->redirect('sadmin/'.$this->user_role.'s/tab');
        }
        $data = $this->data;
        $this->data['sidebar']->set('sidebar_index', 'create');
        $this->setTitle('Create '.Text::ucfirst($this->user_role))
            ->view($this->user_role.'s/create_edit', $data)
            ->render();
    }

    /*
     * Edit student
     */
    public function action_edit()
    {
        if($_POST)
        {
            $action = 'edit_'.$this->user_role;
            if(Model::factory($this->user_role)->$action($_POST))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/'.$this->user_role.'s/tab');
            }
        }
        
        if(($data = $this->check_user($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['edit'] = true;
            $this->setTitle('Edit '.Text::ucfirst($this->user_role))
                    ->view($this->user_role.'s/create_edit', $data)
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
            $action = 'delete_'.$this->user_role;
            if(Model::factory($this->user_role)->$action($_POST[$this->user_role.'_id']))
            {
                Helper_Message::add('success', Text::ucfirst($this->user_role).' deleted successfully');
                $this->request->redirect('sadmin/'.$this->user_role.'s/tab');
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
            $action = 'approve_'.$this->user_role;
            if(Model::factory($this->user_role)->$action($data['user']->id))
            {
                Helper_Message::add('success', Text::ucfirst($this->user_role).' approved successfully');
                return $this->request->redirect('sadmin/'.$this->user_role.'s/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Check user 
     */
    public function check_user($param)
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