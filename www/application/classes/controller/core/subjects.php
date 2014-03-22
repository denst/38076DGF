<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Subjects extends Controller_Core_App {
    
    public function before()
    {
        parent::before();
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/settings')
                ->set('sidebar_index', 'subjects');
    }
    
    /*
     * Show list subjects
     */
    public function action_index()
    {
        $this->data['subjects'] = ORM::factory('subject')->where('pid', '=', 0)->find_all();
        $this->setTitle('Subjects')
                ->view('subjects/subjects', $this->data)
                ->render();
    }
    
    /*
     * Create new subject
     */
    public function action_create()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('subject')->create_subject($_POST))
                $this->request->redirect($this->data['role'].'/subjects');

        }
        $this->setTitle('New Subject')
            ->view('subjects/create', $this->data)
            ->render();
    }

    /*
     * Edit subject
     */
    public function action_edit()
    {
        if ($this->request->post()) 
        {
            if(Model::factory('subject')
                    ->edit_subject($_POST))
            {
                Helper_Message::add('success', 'Subject ​​changed successfully');
                $this->request->redirect($this->data['role'].'/subjects');
            }
                
        }
        if(($this->data = $this->check_subject($this->request->param('id'))))
        {
            $this->setTitle('Edit Subject')
                ->view('subjects/edit', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Delete subject 
     */
    public function action_delete() 
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('subject')->delete_subject($_POST))
            {
                Helper_Message::add('success', 'Subject ​​deleted successfully');
                $this->request->redirect($this->data['role'].'/subjects');
            }
        }
    }
    
    public function action_changesubjects() 
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('class_subject')->change_subjects($_POST))
                Helper_Message::add('success', 'Subjects ​​changed successfully');
            $this->request->redirect($this->request->referrer());
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function check_subject($param)
    {
        $post['subject_id'] = $param;
        if(Valid::numeric($post['subject_id']))
        {
            $this->data['subject'] = Model::factory('subject')
                    ->get_subject_by_id($post['subject_id']);
            return $this->data;
        }
        return false;
    }
}