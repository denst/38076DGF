<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Records extends Controller_Student_App {

    private $user_role;
    private $user_id;
    private $user_model;
    private $user_record;
        
    protected $data  = array();
    
    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/laguadmin/records');
         $this->data['user']     = $this->logget_user;
         $this->data['student_role'] = $this->student_role;
    }
    
    protected function set_user_role($user_role, $user_record)
    {
        $this->user_role = $user_role;
        $this->user_record = $user_record;
        $this->user_id = $user_role.'_id';
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
        $this->data['sidebar'] = 
            View::factory('layouts/sidebars/student/records')
                ->set('student_id', $this->student_id)
                ->set('sidebar_index', $this->user_record);
    }
    
    /*
     * Show list achievement user records
     */
    public function action_list()
    {
        if(($data = $this->check_user($this->request->param('id'))))
        {
            $data['end_year'] = Model::factory('academicyear')->get_end_year();
            $data['year']     = isset($data['year']) ? $data['year'] : $data['end_year'];
            $action = 'get_'.$this->user_role.'_'.$this->user_record;
            $data['records']  = Model::factory($this->user_model)
                    ->$action($data['year'], $data[$this->user_role]);
            $data['table']     = View::factory($this->user_record.'records/'.$this->user_role.'/table', $data);
            $user_id = $this->user_id;
            $this->setTitle(Text::ucfirst($this->user_record).' Records')
                    ->view($this->user_record.'records/'.$this->user_role.'/list', $data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function check_user($param)
    {
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($post[$this->user_id], $post['year']) = $exp;
                    break;
                case 3:
                    list($post[$this->user_id], $post['year'], $post['record_id']) = $exp;
                    break;
            }
        }
        else
            $post[$this->user_id] = $param;
        
        if(Valid::numeric($post[$this->user_id]))
        {
            $action_1 = 'get_'.$this->user_role.'_by_id';
            $data = $this->data;
            $data[$this->user_role]  = Model::factory($this->user_role)
                    ->$action_1($post[$this->user_id]);
            if(Valid::not_empty($data[$this->user_role]))
            {
                if(isset($post['year']))
                    $data['year'] = $post['year'];
                $action_2 = 'get_'.$this->user_role.'_'.$this->user_record.'_by_id';
                if(isset($post['record_id']))
                    $data['record']  = Model::factory($this->user_model)
                        ->$action_2($post['record_id']);
                return $data;
            }
        }
        return false;
    }
}