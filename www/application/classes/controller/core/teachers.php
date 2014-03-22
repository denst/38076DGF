<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Teachers extends Controller_Core_Users {
    
    public function before()
    {
        parent::before();
        $this->set_user_role('teacher');
        $this->set_user_sidebar();
        $this->data['teachers'] = Model::factory('teacher')->get_teachers_slider();
        $this->data['all_subjects'] = Model::factory('subject')
            ->get_all_subjects_order_by_pid();
    }
    
    public function action_tab() 
    {
        parent::action_tab();
    }
    
    public function action_create() 
    {
        parent::action_create();
    }
    
    /*
     * Associate with the Subject
     */
    public function action_associatesubject()
    {
        if($_POST)
        {
            if(Model::factory('subject')->associate_subjects($_POST))
            {
                Helper_Message::add('success', 'New subjects associated with teacher');
                $this->request->redirect($this->data['role'].'/teachers/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Associate with the Subject
     */
    public function action_responsibilities()
    {
        if(($this->data = $this->check_user($this->request->param('id'))))
        {
            $this->data['teacher'] = $this->data['user']->teachers->find();
            $this->data['subjects'] = Model::factory('class_subject')
                    ->get_subjects_by_teacher($this->data);
            $this->data['table'] = View::factory('teachers/table_responsibilities', $this->data);
            $this->setTitle('Current Responsibilities')
                    ->view($this->user_role.'s/responsibilities', $this->data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
}