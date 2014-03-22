<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Profile extends Controller_Student_App {
    
    public function before()
    {
        parent::before();
        $this->data['student_id'] = $this->student_id;
    }
    
    /*
     * View profile of student
     */
    public function action_index()
    {
        $data = $this->data;
        $data['levels']   = Model::factory('level')->get_levels();
        $data['user_data'] = Helper_Main::unserializeData($this->user_data->as_array());
        $data['sidebar_index'] = 'profile';
        $data['sidebar']   = View::factory('layouts/sidebars/student/records', $data);
        $this->setTitle('Edit student')
            ->view('students/view', $data)
            ->render();
    }
}