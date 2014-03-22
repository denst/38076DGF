<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Users extends Controller_Core_App {
    
    protected $user_role;
    
    protected function set_user_role($user_role)
    {
        $this->user_role = $user_role;
    }
    
    protected function set_user_sidebar()
    {
        $this->data['sidebar'] = 
            View::factory('layouts/sidebars/'.$this->data['role'].'/'.$this->user_role.'s', $this->data);
    }
    
    /*
     * Show slider students
     */
    public function action_slider()
    {
        if(isset($this->data['students']))
            $this->data['students'] = Model::factory ('student')
                ->get_approved_students();
        $this->data['sidebar']->set('sidebar_index', 'slider');
        $this->setTitle('Slider '.Text::ucfirst($this->user_role).'s')
            ->view($this->user_role.'s/slider', $this->data)
            ->render();
    }
    
    /*
     * Show Tab students
     */
    public function action_tab()
    {
        $this->data['sidebar']->set('sidebar_index', 'tab');
        unset($this->data['sidebar']);
        if(isset($this->data['custom_view']))
            $view = $this->data['custom_view'];
        else
            $view = $this->user_role.'s/table';
        $this->setTitle('Tab '.Text::ucfirst($this->user_role).'s')
            ->set_template_content(array("fullscreen" => true))
            ->view($view, $this->data)
            ->render();
    }
    
    public function action_dropout()
    {
        $this->data['sidebar']->set('sidebar_index', 'dropout');
        unset($this->data['sidebar']);
        $this->setTitle('Tab '.Text::ucfirst($this->user_role).'s')
            ->set_template_content(array("fullscreen" => true))
            ->view($this->user_role.'s/dropout', $this->data)
            ->render();
    }
    
    public function action_changedropout()
    {
//        if(($this->data = $this->check_user($this->request->param('id'))))
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('student')
                    ->set_dropout_student($_POST))
            {
                Helper_Message::add('success', 'student has been successful changed dropouts');
                    $this->request->redirect($this->data['role'].'/'.$this->user_role.'s/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Show currnet class of the teacher
     */
    public function action_currentclass()
    {
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->data['sidebar']->set('sidebar_index', 'tab');
            $class = Model::factory('class')->get_class_by_teacher_id($this->data['user']->id);
            $this->data['students'] = Model::factory('student')
                    ->get_students_of_class($class);
            $this->data['class_name'] = Model::factory('class')
                    ->get_class_name($class);
            $this->data['class_id'] = $class->id;
            unset($this->data['sidebar']);
            $this->setTitle('Tab '.Text::ucfirst($this->user_role).'s')
                ->set_template_content(array("fullscreen" => true))
                ->view($this->user_role.'s/current_class', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * View current student
     */
    public function action_view()
    {
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->setTitle('View '.Text::ucfirst($this->user_role))
                ->view($this->user_role.'s/view', $this->data)
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
            $model = Model::factory($this->user_role);
            if($model->$action($_POST))
                $this->request->redirect($this->data['role'].'/'.$this->user_role.'s/tab');
            else 
            {
                $errors = $model->get_errors();
                if(Valid::not_empty($errors))
                {
                    foreach ($model->get_errors() as $key => $value) {
                        if($value == 'dropout_student')
                            $this->data['dropout_student'] = true;
                        else
                            Helper_Message::add('error', $value);
                    }
                    $this->data['errors'] = $errors;
                }
                $this->data['user_data'] = $_POST;
            }
        }
        $this->data['sidebar']->set('sidebar_index', 'create');
        $this->setTitle('Create '.Text::ucfirst($this->user_role))
            ->view($this->user_role.'s/create_edit', $this->data)
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
                $this->request->redirect($this->data['role'].'/'.$this->user_role.'s/tab');
            }
        }
        
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->data['edit'] = true;
            $this->setTitle('Edit '.Text::ucfirst($this->user_role))
                    ->view($this->user_role.'s/create_edit', $this->data)
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
                $this->request->redirect($this->data['role'].'/'.$this->user_role.'s/tab');
            }
        }
        throw new HTTP_Exception_404;
    }
    
    /*
     * Approve student 
     */
    public function action_approve()
    {
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $action = 'approve_'.$this->user_role;
            if(Model::factory($this->user_role)->$action($this->data['user']->id))
            {
                Helper_Message::add('success', Text::ucfirst($this->user_role).' approved successfully');
                return $this->request->redirect($this->data['role'].'/'.$this->user_role.'s/tab');
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
            if(($this->data['user'] = Model::factory('auth_user')->get_user_by_id($param)))
            {
                if(isset($this->data['safe_id']) AND $this->check_safe_id($this->data['user']->id))
                    return false;
                $this->data['user_data'] = Helper_Main::unserializeData(
                        Helper_User::getUserData($this->data['user']));
                return $this->data;
            }
        }
        return false;
    }
}