<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_Financialrecords extends Controller_Student_App {

    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/record/index');
        $this->data['user'] = $this->logget_user;
        $this->data['student_role'] = $this->student_role;
        $this->set_template_content(array("fullscreen" => true));
    }
    
    /*
     * Show list financial records
     */
    public function action_list()
    {
        if(($data = $this->check_student($this->request->param('id'))))
        {
            $data['year'] = isset($data['year']) ? $data['year'] : 
                $data['student']->end_year;
            $period = Model::factory('setting')->get_value('academic_year');
            $data['period']  = $period;
            
            if($data['year'] == $data['student']->end_year)
            {
                $data['accounting']     = 1;
                $academic_period        = Helper_Main::getObjectPeriod($data['period']);
                $data['not_paid_count'] = Model::factory('record_financial')->get_financial_count($data, 0);
                $data['paid_count']     = Model::factory('record_financial')->get_financial_count($data, 1);
                $period_annual          = round($data['student']->level->annual / $academic_period->count, 2);
                $period_early_repayment = round(($data['student']->level->annual - ($data['student']->level->annual * $data['student']->level->early_repayment / 100)) / $academic_period->count, 2);
                $data['annual_period']  = $data['paid_count'] == 0 ? 
                    $period_annual : 
                    (Model::factory('record_financial')->get_financial_early($data, 1) == 0)?
                        $period_annual : $period_early_repayment;
            }
            $data['table'] = $this->set_table($data);
            $data['scholarship'] = Model::factory('scholarship')
                ->get_scholarship_count($data);
            
            $this->setTitle('Financial Records')
                ->view('financialrecords/recordsList', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function set_table($data)
    {
        $veiw;
        switch ($data['period'])
        {
            case 0:
                $veiw = View::factory('financialrecords/tables/semesters', $data);
                break;
            case 1:
                $veiw = View::factory('financialrecords/tables/terms', $data);
                break;
            case 2:
                $veiw = View::factory('financialrecords/tables/quarters', $data);
                break;
            case 3:
                $veiw = View::factory('financialrecords/tables/custom8', $data);
                break;
            case 4:
                $veiw = View::factory('financialrecords/tables/customs16', $data);
                break;
        }
        return $veiw;
    }
    
    private function check_student($param)
    {
        $data = $this->data;
        if(strstr($param, '&'))
        {
            $exp = explode('&', $param);
            switch (count($exp)) {
                case 2:
                    list($data['student_id'], $data['year']) = $exp;
                    break;
            }
        }
        else
            $data['student_id'] = $param;
        
        if(Valid::numeric($data['student_id']))
        {
            $data['student']  = Model::factory('student')->get_student_by_id($data['student_id']);
            if(Valid::not_empty($data['student']))
            {
                return $data;
            }
        }
        return false;
    }
}