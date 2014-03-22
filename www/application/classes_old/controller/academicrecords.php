<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Academicrecords extends My_LoggedUserController {

    /*
     * Show list academic records
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' && $this->logget_user->students->find()->student_id != $this->request->param('student')) return $this->request->redirect('');
        $data['student'] = ORM::factory('student', $this->request->param('student'));
        $data['year']    = $this->request->param('year') ? $this->request->param('year') : $data['student']->end_year;
        $data['current_class'] = $data['student']->class_id;
        if(is_null($data['student']->class_id) || ($this->request->param('year') && $this->request->param('year') != $data['student']->end_year)){
            $data['subjects_records'] = ORM::factory('year_subject')->join('dg_acdmrcrds')->on('dg_acdmrcrds.subject', '=', 'year_subject.id')->where('year_subject.year_id', '=', $data['year'])->where('dg_acdmrcrds.student_id', '=', $data['student']->student_id)->order_by('year_subject.parent_subject')->group_by('dg_acdmrcrds.subject')->find_all();
            $data['class']            = count($data['subjects_records']) > 0 ? $data['subjects_records'][0]->class : '';
        }else{
            $data['subjects_records'] = ORM::factory('year_subject')->where('class', '=', $data['student']->class->level->name . $data['student']->class->name)->where('year_id', '=', $data['year'])->order_by('parent_subject')->find_all();
            $data['subjects']         = ORM::factory('class_subject')->select('dg_sbjcts.name', 'dg_sbjcts.pid')->join('dg_sbjcts')->on('dg_sbjcts.id', '=', 'class_subject.subject_id')->where('class_id', '=', $data['student']->class->id)->order_by('dg_sbjcts.pid')->find_all();
            $data['class']            = $data['student']->class->level->name . $data['student']->class->name;
        }
        $data['period']  = ORM::factory('setting', 'academic_year')->find()->value;
        $data['user']    = $this->logget_user;
        Helper_Output::factory()->link_css('bootstrap')->link_js('record/index');
        $this->setTitle('Academic Records')
                ->view('academicrecords/recordsList', $data)
                ->render();
    }

    /*
     * Create new academic record
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['student']        = ORM::factory('student', $this->request->param('student'));
        $data['subject']        = ORM::factory('class_subject')->select('dg_sbjcts.name', 'dg_sbjcts.pid')->join('dg_sbjcts')->on('dg_sbjcts.id', '=', 'class_subject.subject_id')->where('class_subject.id', '=', $this->request->param('subject'))->find();
        $subj_year              = ORM::factory('year_subject')->where('subject', '=', $data['subject']->name)->where('class', '=', $data['student']->class->level->name . $data['student']->class->name)->where('year_id', '=', $data['student']->end_year)->find();
        if(empty($subj_year->id)) {
            $subj_year->year_id        = $data['student']->end_year;
            $subj_year->class          = $data['student']->class->level->name . $data['student']->class->name;
            $subj_year->subject        = $data['subject']->name;
            $subj_year->parent_subject = $data['subject']->pid == 0 ? NULL : ORM::factory('subject', $data['subject']->pid)->name;
            $subj_year->save();
        }
        $data['subject_id']     = $subj_year->id;
        $data['period']         = Helper_Main::getObjectPeriod(ORM::factory('setting', 'academic_year')->find()->value);
        if ($this->request->post()) {
            if(isset($_POST['percentage_ev']) && ($_POST['percentage_ev'] == '' || !is_numeric($_POST['percentage_ev']))){
                if($_POST['percentage_ev'] == '') {
                    $data['errors'] = array('Enter the percentage of');
                } elseif(!is_numeric($_POST['percentage_ev'])) {
                    $data['errors'] = array('The percentage must be a number');
                }
            }else{
                $_POST['date']       = time();
                $_POST['subject']    = $data['subject_id'];
                $_POST['student_id'] = $data['student']->student_id;
                $_POST['period']     = $data['period']->value;
                ORM::factory('record_academic')->values($_POST, array('order', 'period', 'subject', 'date', 'year_id', 'class', 'student_id', 'percentage_ev', 'letter_ev', 'comment_ev'))->create();
                $this->request->redirect('academic-records/list/' . $data['student']->student_id);                
            }
        }
        Helper_Output::factory()->link_js('record/academic');
        $this->setTitle('New Records')
            ->view('academicrecords/newRecord', $data)
            ->render();
    }
    
    /*
     * Create change total academic record
     */
    public function action_change_total()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['student_id'] = $this->request->param('student_id');
        $data['year_id']    = $this->request->param('year_id');
        $data['class']      = urldecode($this->request->param('class'));
        $data['period']     = $this->request->param('period');
        $data['link']       = $data['student_id'] . '/' . $data['year_id'] . '/' . $this->request->param('class') . '/' . $data['period'] . ($this->request->param('id') ? '/' . $this->request->param('id') : '');
        $data['id']         = $this->request->param('id');
        if ($this->request->post()){
            if($this->request->post('scheme') == 0){
                $_POST['letter_ev']  = NULL;
                $_POST['comment_ev'] = NULL;
            }elseif ($this->request->post('scheme') == 1){
                $_POST['percentage_ev']  = NULL;
                $_POST['comment_ev']     = NULL;                    
            }else{
                $_POST['percentage_ev'] = NULL;
                $_POST['letter_ev']     = NULL;
            }
            if(isset($_POST['percentage_ev']) && ($_POST['percentage_ev'] == '' || !is_numeric($_POST['percentage_ev']))){
                if($_POST['percentage_ev'] == '') {
                    $data['errors'] = array('Enter the percentage of');
                } elseif(!is_numeric($_POST['percentage_ev'])) {
                    $data['errors'] = array('The percentage must be a number');
                }
            }else{
                if(!empty($data['id'])){
                    ORM::factory('record_total', $data['id'])->values($_POST, array('letter_ev', 'comment_ev', 'percentage_ev'))->update();
                }else{
                    $_POST['student_id'] = $data['student_id'];
                    $_POST['year_id']    = $data['year_id'];
                    $_POST['class']      = $data['class'];
                    $_POST['period']     = $data['period'];
                    ORM::factory('record_total')->values($_POST, array('student_id', 'year_id', 'class', 'period', 'letter_ev', 'comment_ev', 'percentage_ev'))->create();
                }
                $this->request->redirect('academic-records/list/' . $data['student_id']);
            }
        }
        Helper_Output::factory()->link_js('record/total');
        $this->setTitle('Change Total Records')
            ->view('academicrecords/changeTotalRecord', $data)
            ->render();
    }
    
    /*
     * Delete academic record
     */
    public function action_delete()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $record = ORM::factory('record_academic', $this->request->param('id'));
        if ($record->id) {
            $record->delete();
        }
        $this->request->redirect('academic-records/list/' . $this->request->param('student') . '/' . $this->request->param('year'));                
    }
}