<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Financialrecords extends Controller_Core_App {

    public function before()
    {
        parent::before();
        $this->set_template_content(array("fullscreen" => true));
    }
    
    /*
     * Show list financial records
     */
    public function action_list()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->data['year'] = isset($this->data['year']) ? $this->data['year'] : 
                $this->data['student']->end_year;
            $period = Model::factory('setting')->get_value('academic_period');
            $this->data['period']  = $period;
            $this->calc_financial_records();
            
            $this->data['table'] = $this->set_table();
            $this->setTitle('Financial Records')
                ->view('financialrecords/recordsList', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function calc_financial_records()
    {
        $academic_period = Helper_Main::getObjectPeriod($this->data['period']);
        
        if($this->data['year']  == $this->data['student']->end_year)
            $level = $this->data['student']->level;
        else
        {
            $record_data = $this->data;
            $record_data['order'] = 1;
            $record = Model::factory('record_financial')->get_financial_record($record_data);
            $level = Model::factory ('level')->get_level_by_id($record->level_id);
            $this->data['class_id'] = $record->class_id;
            $this->data['class_name'] = Model::factory('class')->get_class_name($record->class_id);
        }
            
        if(($scholarship = Model::factory('scholarship')
            ->get_scholarship_record($this->data)))
        {
            $this->data['scholarship'] = $scholarship->percent;
            $scholarship_amount = ($level->annual * $scholarship->percent) / 100;
            $with_scholarship_annual = $level->annual - $scholarship_amount;
            $period_annual = round($with_scholarship_annual / $academic_period->count, 2);
            $early_repayment = ($with_scholarship_annual * $level->early_repayment) / 100;
            $this->data['early_repayment'] = $with_scholarship_annual - $early_repayment;
            $period_early_repayment = round($this->data['early_repayment'] / $academic_period->count, 2);
        }
        else 
        {
            $period_annual = round($level->annual / $academic_period->count, 2);
            $early_repayment = ($level->annual * $level->early_repayment) / 100;
            $this->data['early_repayment'] = $level->annual - $early_repayment;
            $period_early_repayment = round($this->data['early_repayment'] / $academic_period->count, 2);
        }
        
        $this->data['accounting']     = 1;
        $this->data['not_paid_count'] = Model::factory('record_financial')->get_financial_count($this->data, 0);
        $this->data['paid_count']     = Model::factory('record_financial')->get_financial_count($this->data, 1);
        
        $this->data['level_annual'] = $period_annual;
        $this->data['full_level_annual'] = $level->annual;
        $this->data['period_count'] = $academic_period->count;
        $this->data['percent_early_repayment'] = $level->early_repayment;
        $this->data['annual_period']  = $this->data['paid_count'] == 0 ? 
            $period_annual : 
            (Model::factory('record_financial')->get_financial_early($this->data, 1) == 0)?
                $period_annual : $period_early_repayment;
    }

    private function set_table()
    {
        $veiw;
        switch ($this->data['period'])
        {
            case 1:
                $veiw = View::factory('financialrecords/tables/semesters', $this->data);
                break;
            case 2:
                $veiw = View::factory('financialrecords/tables/terms', $this->data);
                break;
            case 3:
                $veiw = View::factory('financialrecords/tables/quarters', $this->data);
                break;
            case 4:
                $veiw = View::factory('financialrecords/tables/custom8', $this->data);
                break;
            case 5:
                $veiw = View::factory('financialrecords/tables/customs16', $this->data);
                break;
        }
        return $veiw;
    }

    /*
     * Paid/not paid for financial recor++d
     */
    public function action_payment()
    {
        if(Valid::not_empty($_POST))
        {
            $_POST['student'] = Model::factory('student')->get_student_by_id($_POST['student_id']);
            if(Model::factory('record_financial')->payment($_POST))
            {
                Helper_Message::add('success', 'Records was ​​created successfully');
                $this->request->redirect($this->data['role'].'/financialrecords/list/'.
                    $_POST['student_id'].'&'.$_POST['year']);
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    /*
     * Finish paid for year
     */
    public function action_finishpayment()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('record_financial')->finish_payment($_POST))
            {
                Helper_Message::add('success', 'Finished payment successfully');
                $this->request->redirect($this->data['role'].'/financialrecords/list/'.
                    $_POST['student'].'&'.$_POST['year']);
            }
        }
        else
            throw new HTTP_Exception_404;

    }

    private function check_student($param)
    {
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($this->data['student_id'], $this->data['year']) = $exp;
                    break;
//                case 5:
//                    list($this->data['student_id'], $this->data['period'], $this->data['order'], 
//                        $this->data['year'], $this->data['paid']) = $exp;
//                    break;
//                case 6:
//                    list($this->data['student_id'], $this->data['period'], $this->data['order'], 
//                        $this->data['year'], $this->data['paid'], $this->data['scholarship']) = $exp;
//                    break;
            }
        }
        else
            $this->data['student_id'] = $param;
        
        if(Valid::numeric($this->data['student_id']))
        {
            $this->data['student']  = Model::factory('student')->get_student_by_id($this->data['student_id']);
            if(Valid::not_empty($this->data['student']))
            {
                if(isset($this->data['safe_id']) AND $this->check_safe_id($this->data['student']->student_id))
                    return false;
                return $this->data;
            }
        }
        return false;
    }
}