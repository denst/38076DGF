<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Records extends Controller_Core_App {

    private $user_role;
    private $text_user_id;
    private $user_model;
    private $user_record;
    
    protected function set_user_role($user_role, $user_record)
    {
        $this->user_role = $user_role;
        $this->user_record = $user_record;
        $this->text_user_id = $user_role.'_id';
        switch ($user_role) {
            case 'teacher':
                $this->user_model = 'record_teacher_'.$this->user_record;
                break;
            case 'student':
                $this->user_model = 'record_'.$this->user_record;
                break;
        }
    }
    
    protected function set_user_sidebar()
    {
//        var_dump($this->data);
        $this->data['sidebar'] = 
            View::factory('layouts/sidebars/sadmin/'.$this->user_record.'/'.$this->user_role, $this->data);
    }
    
    /*
     * Show list achievement user records
     */
    public function action_list()
    {
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->data['end_year'] = Model::factory('academicyear')->get_end_year();
            $this->data['year']     = isset($this->data['year']) ? $this->data['year'] : $this->data['end_year'];
            $action = 'get_'.$this->user_role.'_'.$this->user_record;
            $this->data['records']  = Model::factory($this->user_model)
                    ->$action($this->data['year'], $this->data[$this->user_role]);
            $this->data['table']     = View::factory($this->user_record.'records/'.$this->user_role.'/table', $this->data);
//            $this->data['sidebar']
//                ->set('sidebar_index', 'list');
            $this->setTitle(Text::ucfirst($this->user_record).' Records')
                    ->view($this->user_record.'records/'.$this->user_role.'/list', $this->data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    /*
     * Create new achievement user record
     */
    public function action_create()
    {
        if (Valid::not_empty($_POST)) 
        {
            $action = 'create_'.$this->user_record;
            if(($this->data['year_id'] = Model::factory($this->user_model)
                    ->$action($_POST)))
            {
                Helper_Message::add('success', 'Records was ​​addeed successfully');
                $this->request->redirect($this->data['role'].'/'.$this->user_record.$this->user_role.'s/list/' . 
                        $_POST[$this->text_user_id].'&'.$this->data['year_id']);
            }
                
        }
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $user_id = $this->text_user_id;
            $this->data['sidebar']
//                    ->set('id', $this->data[$this->user_role]->$user_id)
                    ->set('sidebar_index', 'create');
            $this->setTitle('New '.Text::ucfirst($this->user_record).' Records')
                ->view($this->user_record.'records/'.$this->user_role.'/create_edit', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    /*
     * Edit achievement user record
     */
    public function action_edit()
    {
        if(Valid::not_empty($_POST))
        {
            $action = 'edit_'.$this->user_record;
            if(Model::factory($this->user_model)
                ->$action($_POST))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect($this->data['role'].'/'.  $this->user_record.$this->user_role.'s/list/'.
                    $_POST[$this->text_user_id] . '&   ' . $_POST['year_id']);
            }
        }
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->data['edit']    = true;
            $user_id  = $this->text_user_id;
            $this->data['sidebar']
//                ->set('id', $this->data[$this->user_role]->$user_id)
                ->set('sidebar_index', 'list');
            $this->setTitle('Edit Records')
                ->view($this->user_record.'records/'.$this->user_role.'/create_edit', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete achievement user record
     */
    public function action_delete()
    {
        if(Valid::not_empty($_POST))
        {
            $action = 'delete_'.$this->user_record;
            list($post[$this->text_user_id], $post['year'], $post['record_id']) = 
                    explode('&', $_POST['delete_'.$this->user_record]);
            if(Model::factory($this->user_model)->$action($post['record_id']))
            {
                Helper_Message::add('success', 'Records was ​​deleted successfully');
                $this->request
                ->redirect($this->data['role'].'/'.$this->user_record.$this->user_role.'s/list/'.$post[$this->text_user_id]. '&' . $post['year']);
            }
        }
        throw new HTTP_Exception_404;
    }
    
    private function check_user($param)
    {
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($post[$this->text_user_id], $post['year']) = $exp;
                    break;
                case 3:
                    list($post[$this->text_user_id], $post['year'], $post['record_id']) = $exp;
                    break;
            }
        }
        else
            $post[$this->text_user_id] = $param;
        
        
        if(Valid::numeric($post[$this->text_user_id]))
        {
            $action_1 = 'get_'.$this->user_role.'_by_id';
            $this->data[$this->user_role]  = Model::factory($this->user_role)
                    ->$action_1($post[$this->text_user_id]);
            if(Valid::not_empty($this->data[$this->user_role]))
            {
                $user_id = $this->text_user_id;
                if(isset($this->data['safe_id']) AND $this->check_safe_id($this->data[$this->user_role]->$user_id))
                    return false;
                if(isset($post['year']))
                    $this->data['year'] = $post['year'];
                $action_2 = 'get_'.$this->user_role.'_'.$this->user_record.'_by_id';
                if(isset($post['record_id']))
                    $this->data['record']  = Model::factory($this->user_model)
                        ->$action_2($post['record_id']);
                $this->data['sidebar']
                    ->set('id', $this->data[$this->user_role]->$user_id);
                return $this->data;
            }
        }
        return false;
    }
}