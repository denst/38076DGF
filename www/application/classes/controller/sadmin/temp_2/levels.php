<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Levels extends Controller_Sadmin_App {

    private $data  = array();
    
    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/laguadmin/settings');
        $this->data['user']   = $this->logget_user;
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/settings')
                ->set('sidebar_index', 'grade_levels');
    }
  /*
     * Show list achievement student records
     */
    public function action_list()
    {
        $data = $this->data;
        $years = Model_Level::get_min_max_student_year();
        $data['years']  = $years[0];

        if($this->request->param('id'))
            $data['year']   = $this->request->param('id');
        else
        {
            if(Valid::not_empty($data['years']->min_year))
                $data['year'] = $data['years']->min_year;
            else
                $data['year'] = Model::factory('academicyear')->get_end_year();
        }
        $data['admin']   = true;
        $data['levels'] = Model::factory('level')->get_levels();
        Helper_Output::factory()
            ->link_js('js/level/index')
            ->link_js('js/class/templates') ;
        $this->setTitle('Grade Levels')
                ->view('levels/levels', $data)
                ->render();
    }

     /*
     * Create new level
     */
    public function action_create()
    {
        if (Valid::not_empty($_POST)) 
        {
            if(Model::factory('level')->create_level($_POST))
                $this->request->redirect('sadmin/levels/list');
        }
        $data = $this->data;
        $data['sidebar']->set('sidebar_index', 'create_levels');
        $data['year'] = $this->request->param('id');
        Helper_Output::factory()
            ->link_js('js/level/index')
            ->link_js('js/class/templates') ;
        $this->setTitle('Create Level')
            ->view('levels/create', $data)
            ->render();
    }

    /*
     * Edit level
     */
    public function action_edit()
    {
        if (Valid::not_empty($_POST)) 
        {
            if(Model::factory('level')->edit_level($_POST))
            {
                Helper_Message::add('success', 'Level ​​changed successfully');
                $this->request->redirect('sadmin/levels/list/'.$_POST['year']);
            }
        }
        if(($data = $this->check_level($this->request->param('id'))))
        {
            $data['classes'] = $data['level']->template_classes
                    ->where('year_id', '=', $data['year'])->order_by('name')->find_all();
            Helper_Output::factory()
                    ->link_js('js/class/templates')
                    ->link_js('js/laguadmin/students');
            $this->setTitle('Edit Level')
                ->view('levels/edit', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
   
    /*
     * Delete level
     */
    public function action_delete()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('level')->delete_level($_POST))
            {
                Helper_Message::add('success', 'Level ​​deleted successfully');
                $this->request->redirect('sadmin/levels/list');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Unassigned students
     */
    public function action_unassignedstudents()
    {
        if(($data = $this->check_level($this->request->param('id'))))
        {
            $data['all_class'] = $data['level']->template_classes
                    ->where('year_id', '=', $data['year'])->find_all();
            $data['students']  = $data['level']->students
                    ->where('end_year', '=', $data['year'])
                    ->where('class_id', '=', NULL)->find_all();
            Helper_Output::factory()
                    ->link_js('/js/user/index');
            $this->setTitle('Unassigned students')
                ->view('levels/unassignedstudents', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
   
    /*
     * Unassigned students
     */
    public function action_autoassigned()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('level')->auto_assigned($_POST))
                Helper_Message::add('success', 'Autoassigned students successfully');
            $this->request->redirect('sadmin/levels/list');
        }
        else
            throw new HTTP_Exception_404;
    }    

    public function action_promotingdetaining()
    {
        list($post['type'], $post['student_id']) = explode('&', $this->request->param('id'));
        $student  = Model::factory('student')->get_student_by_id($post['student_id']);
        if($student)
        {
            if(Model::factory('student')->promoting_detaining($student, $post['type']))
            {
                Helper_Message::add('success', 'Student ​​detaining successfully');
            }
            $this->request->redirect($this->request->referrer());
        }
        else
            throw new HTTP_Exception_404;
    }

    
    private function check_level($param)
    {
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($post['level_id'], $post['year']) = $exp;
                    break;
                case 3:
                    list($post['student_id'], $post['year'], $post['record_id']) = $exp;
                    break;
            }
        }
        else
            $post['level_id'] = $param;
        if(Valid::numeric($post['level_id']))
        {
            $data = $this->data;
            $data['level'] = Model::factory('level')->get_level_by_id($post['level_id']);
            $data['year'] = $post['year'];
            return $data;
        }
        return false;
    }
}