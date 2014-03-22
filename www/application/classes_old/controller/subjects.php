<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Subjects extends My_LoggedUserController {

    /*
     * Show list subjects
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $data['subjects'] = ORM::factory('subject')->where('pid', '=', 0)->find_all();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'subjects')
                ->render();
        $data['subjects'] = View::factory('subjects/subjects')
            ->set('subjects', $data['subjects'])
            ->render();
        $data['create_subject'] = View::factory('subjects/create')
            ->set('subjects', $data['subjects'])
            ->render();
        Helper_Output::factory()
//                ->link_css('bootstrap')
                ->link_css('laguadmin/lib/datatables/css/table_jui')
                ->link_js('js/level/index')
                ->link_js('js/class/templates')
                ->link_js('js/laguadmin/students');
        $this->setTitle('Subjects')
                ->set_template_content(array("fullscreen" => false))
                ->view('subjects/index', $data)
                ->render();
    }
    
    /*
     * Create new subject
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $data = array();
        if ($this->request->post()) {
            try {
                ORM::factory('subject')->values($this->request->post(), array('name', 'pid'))->create();
                $this->request->redirect('subjects/list');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $this->setTitle('New Subject')
            ->view('subjects/newSubject', $data)
            ->render();
    }

    /*
     * Edit subject
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        if ($this->request->post()) {
            try {
                ORM::factory('subject', $this->request->param('id'))->values($this->request->post(), array('name', 'pid'))->update();
                $data['success'] = 'Subject successful edit';
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['subject'] = ORM::factory('subject', $this->request->param('id'));
        if(empty($data['subject']->id)) $this->request->redirect('');
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'subjects')
                ->render();
        Helper_Output::factory()
            ->link_css('laguadmin/lib/datatables/css/table_jui')
            ->link_js('js/level/index')
            ->link_js('js/class/templates')
            ->link_js('js/laguadmin/students');
        $this->setTitle('Edit Subject')
            ->set_template_content(array("fullscreen" => false))
            ->view('subjects/edit', $data)
            ->render();
    }


    public function action_change_scheme()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $subject = ORM::factory('class_subject', $this->request->post('subject'));
        if($subject->id){
            $subject->scheme = $this->request->post('scheme');
            $subject->save();
        }
        $this->request->redirect($this->request->referrer());
    }
    
    public function action_change_teacher()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $subject = ORM::factory('class_subject', $this->request->post('subject'));
        if($subject->id){
            $subject->teacher_id = $this->request->post('teacher');
            $subject->save();
        }
        $this->request->redirect($this->request->referrer());
    }
}