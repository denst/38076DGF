<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Levels extends Controller_Core_App {
    
    /*
     * Show list achievement student records
     */
    public function action_list()
    {
        $years = Model_Level::get_min_max_student_year();
        $this->data['years']  = $years[0];

        if($this->request->param('id'))
            $this->data['year']   = $this->request->param('id');
        else
        {
            if(Valid::not_empty($this->data['years']->min_year))
                $this->data['year'] = $this->data['years']->min_year;
            else
                $this->data['year'] = Model::factory('academicyear')->get_end_year();
        }
        $this->data['admin']   = true;
        $this->data['unassigned_students']   = Model::factory('level')
                ->get_count_unassigned_students($this->data);
        $this->data['levels'] = Model::factory('level')->get_levels();
        $this->setTitle('Grade Levels')
                ->view('levels/levels', $this->data)
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
                $this->request->redirect($this->data['role'].'/levels/list');
        }
//        $this->data['sidebar']->set('sidebar_index', 'create_levels');
        $this->data['year'] = $this->request->param('id');
        $this->setTitle('Create Level')
            ->view('levels/create', $this->data)
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
                $this->request->redirect($this->data['role'].'/levels/list/'.$_POST['year']);
            }
        }
        if(($this->data = $this->check_level($this->request->param('id'))))
        {
            $this->data['classes'] = $this->data['level']->template_classes
                    ->where('year_id', '=', $this->data['year'])->order_by('name')->find_all();
            $this->setTitle('Edit Level')
                ->view('levels/edit', $this->data)
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
                $this->request->redirect($this->data['role'].'/levels/list');
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
        if(($this->data = $this->check_level($this->request->param('id'))))
        {
            $this->data['all_class'] = $this->data['level']->template_classes
                    ->where('year_id', '=', $this->data['year'])->find_all();
            $this->data['students']  = Model::factory('level')
                ->get_unassigned_students($this->data);
//            $this->data['students']  = $this->data['level']->students
//                    ->where('end_year', '=', $this->data['year'])
//                    ->where('class_id', '=', NULL)->find_all();
            $this->setTitle('Unassigned students')
                ->view('levels/unassignedstudents', $this->data)
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
            $this->request->redirect($this->data['role'].'/levels/list');
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
            $this->data['level'] = Model::factory('level')->get_level_by_id($post['level_id']);
            $this->data['year'] = $post['year'];
            return $this->data;
        }
        return false;
    }
}