<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_AchievementRecords extends Controller_Sadmin_App {

    private $data  = array();
    
    public function before()
    {
        parent::before();
        $this->data['user']     = $this->logget_user;
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/achievement');
    }
  /*
     * Show list achievement student records
     */
    public function action_list()
    {
        if(($data = $this->check_student($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['end_year'] = Model::factory('academicyear')->get_end_year();
            $data['year']     = isset($data['year']) ? $data['year'] : $data['end_year'];
            $data['records']  = Model::factory('record_achievement')
                    ->get_student_achievement($data['year'], $data['student']);
            $data['table']     = View::factory('achievementrecords/students/table', $data);
            $data['sidebar']
                    ->set('id', $data['student']->student_id)
                    ->set('sidebar_index', 'list');
            $this->setTitle('Achievement Records')
                    ->view('achievementrecords/students/list', $data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    /*
     * Create new achievement student record
     */
    public function action_create()
    {
        if (Valid::not_empty($_POST)) {
            if(($data['year_id'] = Model::factory('record_achievement')
                    ->create_achievement($_POST)))
            {
                Helper_Message::add('success', 'Records was ​​addeed successfully');
                $this->request->redirect('sadmin/achievementrecords/list/' . 
                        $_POST['student_id'].'&'.$data['year_id']);
            }
                
        }
        if(($data = $this->check_student($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['sidebar']
                    ->set('id', $data['student']->student_id)
                    ->set('sidebar_index', 'create');
            $this->setTitle('New Achievement Records')
                ->view('achievementrecords/students/create_edit', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    /*
     * Edit achievement student record
     */
    public function action_edit()
    {
        if(isset($_POST['edit']))
        {
            if(Model::factory('record_achievement')
                    ->edit_achievement($_POST))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/achievementrecords/list/'.
                    $_POST['student_id'] . '&   ' . $_POST['year_id']);
            }
        }
        if(($data = $this->check_student($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            $data['edit']    = true;
            $data['sidebar']
                ->set('id', $data['student']->student_id)
                ->set('sidebar_index', 'list');
            $this->setTitle('Edit Records')
                ->view('achievementrecords/students/create_edit', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete achievement student record
     */
    public function action_delete()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('record_achievement')->delete_achievement($_POST['record_id']))
            {
                Helper_Message::add('success', 'Records was ​​deleted successfully');
                $this->request
                ->redirect('sadmin/achievementrecords/list/'.$_POST['student_id']. '&' . $_POST['year']);
            }
        }
        throw new HTTP_Exception_404;
    }
    
    private function check_student($param)
    {
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($post['student_id'], $post['year']) = $exp;
                    break;
                case 3:
                    list($post['student_id'], $post['year'], $post['record_id']) = $exp;
                    break;
            }
        }
        else
            $post['student_id'] = $param;
        
        if(Valid::numeric($post['student_id']))
        {
            $data['student']  = Model::factory('student')->get_student_by_id($post['student_id']);
            if(Valid::not_empty($data['student']))
            {
                if(isset($post['year']))
                    $data['year'] = $post['year'];
                if(isset($post['record_id']))
                    $data['record']  = Model::factory('record_achievement')
                        ->get_student_achievement_by_id($post['record_id']);
                return $data;
            }
        }
        return false;
    }
}