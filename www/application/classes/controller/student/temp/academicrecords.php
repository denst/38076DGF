<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_AcademicRecords extends Controller_Student_App {

    private $data  = array();
    
    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/laguadmin/records')
            ->link_js('js/record/total');
        $this->data['user']     = $this->logget_user;
        $this->data['student_role'] = $this->student_role;
        $this->set_template_content(array("fullscreen" => true));
    }
    
    /*
     * Show list Academic student records
     */
    public function action_list()
    {
        if(($data = $this->check_student($this->request->param('id'))))
        {
            $data['year']    = isset($data['year']) ? $data['year'] : 
                $data['student']->end_year;
            $data['current_class'] = $data['student']->class_id;    
            
            if(is_null($data['current_class']) || 
                    $data['year'] != $data['student']->end_year)
            {
                $data['subjects_records'] = Model::factory('year_subject')->get_subject_records($data);
                $data['class'] = count($data['subjects_records']) > 0 ? 
                        $data['subjects_records'][0]->class : '';
            }
            else
            {
                $data['subjects_records'] = Model::factory('year_subject')
                        ->get_subject_records_by_classname($data);
                $data['subjects'] = Model::factory('class_subject')
                        ->get_subjects_by_class_id($data['student']->class->id);
                $data['class'] = $data['student']->class->level->name . $data['student']->class->name;
                $data['table_class'] = View::factory('academicrecords/tables/class', $data);
            }
            $data['period']  = Model::factory('setting')->get_value('academic_year');
            
            $data['table'] = $this->set_table($data);
            $this->setTitle('Academic Records')
                    ->view('academicrecords/list', $data)
                    ->render();
        }
//        else
//            throw new HTTP_Exception_404;
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
                case 3:
                    list($data['student_id'], $data['year'], $data['record_id']) = $exp;
                    break;
                case 4:
                    list($data['student_id'], $data['year'], $data['class'], $data['period']) = $exp;
                    break;
                case 5:
                    list($data['student_id'], $data['year'], $data['class'], $data['period'], $data['record_id']) = $exp;
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
    
    private function set_table($data)
    {
        switch ($data['period'])
        {
            case 0:
                $veiw = View::factory('academicrecords/tables/semesters', $data);
                break;
            case 1:
                $veiw = View::factory('academicrecords/tables/terms', $data);
                break;
            case 2:
                $veiw = View::factory('academicrecords/tables/quarters', $data);
                break;
            case 3:
                $veiw = View::factory('academicrecords/tables/custom8', $data);
                break;
            case 4:
                $veiw = View::factory('academicrecords/tables/customs16', $data);
                break;
        }
        return $veiw;
    }
}