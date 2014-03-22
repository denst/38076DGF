<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Disciplinaryrecords extends My_LoggedUserController {

    /*
     * Show list disciplinary records
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' && $this->logget_user->students->find()->student_id != $this->request->param('student')) return $this->request->redirect('');
        $data['student'] = ORM::factory('student', $this->request->param('student'));
        $data['year']    = $this->request->param('year') ? $this->request->param('year') : $data['student']->end_year;
        $data['records'] = ORM::factory('record_disciplinary')->where('year_id', '=', $data['year'])->where('student_id', '=', $data['student']->student_id)->find_all();
        $data['user']    = $this->logget_user;
        Helper_Output::factory()->link_css('bootstrap')->link_js('record/index');
        $this->setTitle('Disciplinary Records')
                ->view('disciplinaryrecords/recordsList', $data)
                ->render();
    }

    /*
     * Create new disciplinary record
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['student']        = ORM::factory('student', $this->request->param('student'));
        if ($this->request->post()) {
            try {
                $_POST['date'] = !empty($_POST['date']) ? strtotime($_POST['date']) : time();
                $_POST['year_id']    = $data['student']->end_year;
                $_POST['student_id'] = $data['student']->student_id;
                if(Helper_User::getUserRole($this->logget_user) != 'sadmin') $_POST['notes']  = '';
                ORM::factory('record_disciplinary')->values($_POST, array('record', 'notes', 'action', 'date', 'year_id', 'student_id'))->create();
                $this->request->redirect('disciplinary-records/list/' . $data['student']->student_id . '/' . $_POST['year_id']);                
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['user'] = $this->logget_user;
        Helper_Output::factory()->link_js('record/index');
        $this->setTitle('New Records')
            ->view('disciplinaryrecords/newRecord', $data)
            ->render();
    }

    
    /*
     * Edit achievement record
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $data['student'] = ORM::factory('student', $this->request->param('student'));
        $data['year']    = $this->request->param('year');
        $data['record']  = ORM::factory('record_disciplinary', $this->request->param('id'));
        if ($this->request->post()) {
            try {
                $_POST['date']       = !empty($_POST['date']) ? strtotime($_POST['date']) : time();
                $_POST['year_id']    = $this->request->param('year');
                $_POST['student_id'] = $data['student']->student_id;
                if(Helper_User::getUserRole($this->logget_user) != 'sadmin') $_POST['notes'] = '';
                $data['record']->values($_POST, array('record', 'notes', 'action', 'date', 'year_id', 'student_id'))->update();
                $this->request->redirect('disciplinary-records/list/' . $data['student']->student_id . '/' . $_POST['year_id']);
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['user']    = $this->logget_user;
        Helper_Output::factory()->link_js('record/index');
        $this->setTitle('Edit Records')
            ->view('disciplinaryrecords/editRecord', $data)
            ->render();
    }

    /*
     * Delete disciplinary record
     */
    public function action_delete()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $record = ORM::factory('record_disciplinary', $this->request->param('id'));
        if ($record->id) {
            $record->delete();
        }
        $this->request->redirect('disciplinary-records/list/' . $this->request->param('student') . '/' . $this->request->param('year'));                
    }
}