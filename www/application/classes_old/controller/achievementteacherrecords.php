<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Achievementteacherrecords extends My_LoggedUserController {

    /*
     * Show list achievement teacher records
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || (Helper_User::getUserRole($this->logget_user) == 'teacher' && $this->logget_user->teachers->find()->teacher_id != $this->request->param('teacher'))) {
            return $this->request->redirect('');
        }
        $data['teacher']  = ORM::factory('teacher', $this->request->param('teacher'));
        $data['end_year'] = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
        $data['year']     = $this->request->param('year') ? $this->request->param('year') : $data['end_year'];
        $data['records']  = ORM::factory('record_teacher_achievement')->where('year_id', '=', $data['year'])->where('teacher_id', '=', $data['teacher']->teacher_id)->find_all();
        $data['user']     = $this->logget_user;
        Helper_Output::factory()->link_css('bootstrap')->link_js('record/index');
        $this->setTitle('Achievement Records')
                ->view('achievementteacherrecords/recordsList', $data)
                ->render();
    }

    /*
     * Create new achievement teacher record
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $data['teacher']        = ORM::factory('teacher', $this->request->param('teacher'));
        if ($this->request->post()) {
            try {
                $_POST['date']       = !empty($_POST['date']) ? strtotime($_POST['date']) : time();
                $_POST['year_id']    = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
                $_POST['teacher_id'] = $data['teacher']->teacher_id;
                ORM::factory('record_teacher_achievement')->values($_POST, array('achievement', 'notes', 'date', 'year_id', 'teacher_id'))->create();
                $this->request->redirect('achievement-teacher-records/list/' . $data['teacher']->teacher_id . '/' . $_POST['year_id']);
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('record/index');
        $this->setTitle('New Records')
            ->view('achievementteacherrecords/newRecord', $data)
            ->render();
    }

    /*
     * Edit achievement teacher record
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $data['teacher'] = ORM::factory('teacher', $this->request->param('teacher'));
        $data['year']    = $this->request->param('year');
        $data['record']  = ORM::factory('record_teacher_achievement', $this->request->param('id'));
        if ($this->request->post()) {
            try {
                $_POST['date']       = !empty($_POST['date']) ? strtotime($_POST['date']) : time();
                $_POST['year_id']    = $this->request->param('year');
                $_POST['teacher_id'] = $data['teacher']->teacher_id;
                if(Helper_User::getUserRole($this->logget_user) != 'sadmin') $_POST['notes'] = '';
                $data['record']->values($_POST, array('achievement', 'notes', 'date', 'year_id', 'student_id'))->update();
                $this->request->redirect('achievement-teacher-records/list/' . $data['teacher']->teacher_id . '/' . $_POST['year_id']);
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['user']    = $this->logget_user;
        Helper_Output::factory()->link_js('record/index');
        $this->setTitle('Edit Records')
            ->view('achievementteacherrecords/editRecord', $data)
            ->render();
    }
    
    /*
     * Delete achievement teacher record
     */
    public function action_delete()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $record = ORM::factory('record_teacher_achievement', $this->request->param('id'));
        if ($record->id) {
            $record->delete();
        }
        $this->request->redirect('achievement-teacher-records/list/' . $this->request->param('teacher') . '/' . $this->request->param('year'));
    }
}