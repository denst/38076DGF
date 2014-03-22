<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Financialrecords extends My_LoggedUserController {

    /*
     * Show list financial records
     */
    public function action_list()
    {
        if((Helper_User::getUserRole($this->logget_user) == 'student' && $this->logget_user->students->find()->student_id != $this->request->param('student')) || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $data['student'] = ORM::factory('student', $this->request->param('student'));
        $data['year']    = $this->request->param('year') ? $this->request->param('year') : $data['student']->end_year;
        $data['period']  = ORM::factory('setting', 'academic_year')->find()->value;
        $data['user']    = $this->logget_user;
        if($data['year'] == $data['student']->end_year){
            $data['accounting']     = 1;
            $academic_period        = Helper_Main::getObjectPeriod($data['period']);
            $data['not_paid_count'] = ORM::factory('record_financial')->where('student_id', '=', $this->request->param('student'))->where('period', '=', $data['period'])->where('paid', '=', 0)->where('year_id', '=', $data['year'])->count_all();
            $data['paid_count']     = ORM::factory('record_financial')->where('student_id', '=', $this->request->param('student'))->where('period', '=', $data['period'])->where('paid', '=', 1)->where('year_id', '=', $data['year'])->count_all();
            $period_annual          = round($data['student']->level->annual / $academic_period->count, 2);
            $period_early_repayment = round(($data['student']->level->annual - ($data['student']->level->annual * $data['student']->level->early_repayment / 100)) / $academic_period->count, 2);
            $data['annual_period']  = $data['paid_count'] == 0 ? $period_annual : (ORM::factory('record_financial')->where('student_id', '=', $this->request->param('student'))->where('period', '=', $data['period'])->where('paid', '=', 1)->where('year_id', '=', $data['year'])->find()->early == 0 ? $period_annual : $period_early_repayment);
        }
        $data['scholarship'] = ORM::factory('scholarship')->where('year_id', '=', $data['year'])->where('student_id', '=', $this->request->param('student'))->count_all();
        Helper_Output::factory()->link_css('bootstrap')->link_js('record/index');
        $this->setTitle('Financial Records')
                ->view('financialrecords/recordsList', $data)
                ->render();
    }

    /*
     * Paid/not paid for financial record
     */
    public function action_paid()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $record = ORM::factory('record_financial')->where('student_id', '=', $this->request->param('student'))->where('period', '=', $this->request->param('period'))->where('order', '=', $this->request->param('order'))->where('year_id', '=', $this->request->param('year'))->find();
        if(empty($record->id)) {
            $student = ORM::factory('student', $this->request->param('student'));
            $record->student_id = $this->request->param('student');
            $record->year_id    = $this->request->param('year');
            $record->period     = $this->request->param('period');
            $record->order      = $this->request->param('order');
            $record->level_id   = $student->level->id;
        }
//        $academic_period = Helper_Main::getObjectPeriod($this->request->param('period'));
//        $record->annual  = round($student->level->annual / $academic_period->count, 2);
        $record->early   = 0;
        $record->paid    = $this->request->param('paid');
        $record->save();
        $this->request->redirect('financial-records/list/' . $this->request->param('student') . '/' . $this->request->param('year'));
    }
    
    /*
     * Finish paid for year
     */
    public function action_finish_payment()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        for($period = 0; $period < 5; $period++){
            $period_obj = Helper_Main::getObjectPeriod($period);
            $student = ORM::factory('student', $this->request->post('student'));
//            $annual = round(($student->level->annual - ($student->level->annual * $student->level->early_repayment / 100)) / $period_obj->count, 2);
            for($order = 0; $order < $period_obj->count; $order++){
                $record = ORM::factory('record_financial')->where('student_id', '=', $this->request->post('student'))->where('period', '=', $period)->where('order', '=', $order)->where('year_id', '=', $this->request->post('year'))->find();
                if(empty($record->id)){
                    $record->student_id = $this->request->post('student');
                    $record->year_id    = $this->request->post('year');
                    $record->period     = $period;
                    $record->order      = $order;
                    $record->level_id   = $student->level->id;
                }
                $record->paid   = 1;
                if($this->request->post('scholarship')){
                    $record->early  = 0;
                    $this->request->post('scholarship') == 1 ? $record->save() : $record->delete();
                }else{
                    $record->early  = 1;
                    $record->save();
                }
            }
        }
        if($this->request->post('scholarship')){
            $scholarship = ORM::factory('scholarship')->where('year_id', '=', $this->request->post('year'))->where('student_id', '=', $this->request->post('student'))->find();
            if($this->request->post('scholarship') == 1){
                $scholarship->year_id    = $this->request->post('year');
                $scholarship->student_id = $this->request->post('student');
                $scholarship->save();
            }else{
                $scholarship->delete();
            }
        }
        $this->request->redirect('financial-records/list/' . $this->request->post('student') . '/' . $this->request->post('year'));
    }    
}