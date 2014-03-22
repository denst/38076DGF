<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Subjects extends Controller_Sadmin_App {

    private $data  = array();
    
    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/laguadmin/settings');
        $this->data['user']   = $this->logget_user;
        $this->data['sidebar'] = View::factory('layouts/sidebars/sadmin/settings')
                ->set('sidebar_index', 'subjects');
    }
    
    /*
     * Show list subjects
     */
    public function action_index()
    {
        $data = $this->data;
        $data['subjects'] = ORM::factory('subject')->where('pid', '=', 0)->find_all();
        $this->setTitle('Subjects')
                ->view('subjects/subjects', $data)
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
                $this->request->redirect('sadmin/subjects');

        }
        $data = $this->data;
        $this->setTitle('New Subject')
            ->view('subjects/create', $data)
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
                $this->request->redirect('sadmin/subjects');
            }
                
        }
        if(($data = $this->check_subject($this->request->param('id'))))
        {
            $data = Arr::merge($data, $this->data);
            Helper_Output::factory()
                ->link_js('js/level/index')
                ->link_js('js/class/templates');
            $this->setTitle('Edit Subject')
                ->view('subjects/edit', $data)
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
                $this->request->redirect('sadmin/subjects');
            }
        }
    }


    public function action_changescheme()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('class_subject')->change_scheme($_POST))
                Helper_Message::add('success', 'Scheme ​​changed successfully');
            $this->request->redirect($this->request->referrer());
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_changeteacher()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('class_subject')->change_teacher($_POST))
                Helper_Message::add('success', 'Teacher ​​changed successfully');
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
            $data = $this->data;
            $data['subject'] = Model::factory('subject')
                    ->get_subject_by_id($post['subject_id']);
            return $data;
        }
        return false;
    }
}