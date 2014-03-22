<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_AcademicRecords extends Controller_Core_App {

    public function before()
    {
        parent::before();
        $this->set_template_content(array("fullscreen" => true));
    }
    
    public function action_list()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->set_academic_records();
            $this->data['table'] = $this->set_table();
            $this->setTitle('Academic Records')
                    ->view('academicrecords/list', $this->data)
                    ->render();
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_create()
    {
        list($post['student_id'], $post['subject_id']) = explode('&', 
                $this->request->param('id'));
        $this->data['student'] = Model::factory('student')->get_student_by_id($post['student_id']);
        $this->data['subject'] = Model::factory('class_subject')
                ->get_subject_by_id($post['subject_id']);
        $this->data['period'] = Helper_Main::
                getObjectPeriod(Model::factory('setting')->get_value('academic_period'));
        $this->data['subject_id'] = Model::factory('year_subject')->get_subjects_year($this->data);
        if (Valid::not_empty($_POST)) 
        {
            $model_academic = Model::factory('record_academic');
            if($model_academic->create_academic($_POST, $this->data))
            {
                Helper_Message::add('success', 'Records was ​​created successfully');
                $this->request->redirect($this->data['role'].'/academicrecords/list/'.
                    $this->data['student']->student_id);
            }
            else
                Helper_Message::add('errors', $model_academic->get_errors());
                $this->data['error'] = true;
        }
        $this->setTitle('New Academic Records')
            ->view('academicrecords/create_edit', $this->data)
            ->render();
    }
    
    public function action_delete()
    {
        if(Valid::not_empty($_POST))
        {
            if(($this->data = $this->check_student($_POST['delete_academic'])))
            {
                if(Model::factory('record_academic')->delete_academic($this->data))
                {
                    Helper_Message::add('success', 'Records was ​​deleted successfully');
                    $this->request->redirect($this->data['role'].'/academicrecords/list/'.
                            $this->data['student']->student_id .'&'.$this->data['year']);
                }
            }
        }
        throw new HTTP_Exception_404;
    }
    
    public function action_changetotal()
    {
        $link = $this->request->param('id');
        if(($this->data = $this->check_student($link)))
        {
            $this->data['link'] = $link;
            if(Valid::not_empty($_POST))
            {
                if(Model::factory('record_academic')->change_total($_POST, $this->data))
                {
                    Helper_Message::add('success', 'Change total was ​​successfully');
                    $this->request->redirect($this->data['role'].'/academicrecords/list/' . $this->data['student_id']);
                }
            }
            $this->setTitle('Change Total Records')
                ->view('academicrecords/change_total_record', $this->data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_pdfdownload()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->set_academic_records();
            $this->set_pdf_report('D');
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_pdfview()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->set_academic_records();
            $this->set_pdf_report('I');
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_transcriptdownload()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->set_academic_records();
            $this->set_pdf_report('D', true);
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_transcriptview()
    {
        if(($this->data = $this->check_student($this->request->param('id'))))
        {
            $this->set_academic_records();

            $this->set_pdf_report('I', true);
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function set_pdf_report($dest, $transcript = false)
    {
        if($transcript)
        {
            $mpdf = Kohana_MPDF::factory('pdf/transcript', $this->data);
            $mpdf->set_orientation('P');
            $mpdf->set_css(APPPATH.'assets/css/pdf/transcript.css');
//            $this->response->body(View::factory('pdf/transcript', $this->data));
            $mpdf->render();
            $mpdf->output('mpdf.pdf', $dest);                
        }
        elseif($this->data['student']->class->level->id == 1)
        {
            $mpdf = Kohana_MPDF::factory('pdf/preschool_report', $this->data);
            $mpdf->set_orientation('L');
            $mpdf->set_css(APPPATH.'assets/css/pdf/preschool.css');
//            $this->response->body(View::factory('pdf/preschool_report', $this->data));
            $mpdf->render();
            $mpdf->output('mpdf.pdf', $dest);
        }
        else
        {
            $mpdf = Kohana_MPDF::factory('pdf/perort_card', $this->data);
            $mpdf->set_orientation('L');
            $mpdf->set_css(APPPATH.'assets/css/pdf/perort_card.css');
//            $this->response->body(View::factory('pdf/perort_card', $this->data));
            $mpdf->render();
            $mpdf->output('mpdf.pdf', $dest);
        }
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
                case 3:
                    list($this->data['student_id'], $this->data['year'], $this->data['record_id']) = $exp;
                    break;
                case 4:
                    list($this->data['student_id'], $this->data['year'], $this->data['class'], $this->data['period']) = $exp;
                    break;
                case 5:
                    list($this->data['student_id'], $this->data['year'], $this->data['class'], $this->data['period'], $this->data['record_id']) = $exp;
                    break;
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
    
    private function set_table()
    {
        switch ($this->data['period'])
        {
            case 1:
                $veiw = View::factory('academicrecords/tables/semesters', $this->data);
                break;
            case 2:
                $veiw = View::factory('academicrecords/tables/terms', $this->data);
                break;
            case 3:
                $veiw = View::factory('academicrecords/tables/quarters', $this->data);
                break;
            case 4:
                $veiw = View::factory('academicrecords/tables/customs8', $this->data);
                break;
            case 5:
                $veiw = View::factory('academicrecords/tables/customs16', $this->data);
                break;
        }
        return $veiw;
    }
    
    private function set_academic_records()
    {
        $this->data['end_year'] = Model::factory('academicyear')->get_end_year();
        $this->data['year']     = isset($this->data['year']) ? $this->data['year'] : $this->data['end_year'];
        $this->data['current_class'] = $this->data['student']->class_id;    

        if(is_null($this->data['current_class']) || 
                $this->data['year'] != $this->data['student']->end_year)
        {
            $this->data['subjects_records'] = Model::factory('year_subject')->get_subject_records($this->data);
            $this->data['class'] = count($this->data['subjects_records']) > 0 ? 
                    $this->data['subjects_records'][0]->class : '';
            $this->data['table_class'] = View::factory('academicrecords/tables/class', $this->data);
        }
        else
        {
            $this->data['subjects_records'] = Model::factory('year_subject')
//                    ->get_subject_records_by_classname($this->data);
                    ->get_subject_records($this->data);
            $this->data['subjects'] = Model::factory('class_subject')
                    ->get_subjects_by_class_id($this->data['student']->class->id);
            $this->data['class'] = $this->data['student']->class->level->name . $this->data['student']->class->name;
            $this->data['table_class'] = View::factory('academicrecords/tables/class', $this->data);
        }
        $this->data['grade_id'] = $this->data['subjects_records'][0]->class;
        $this->data['grade'] = Model::factory('class')
            ->get_class_name($this->data['grade_id']);
        $this->data['total_subjects_records'] = $this->set_total_subjects_records();
        $user = Model::factory('auth_user')->get_user_by_id($this->data['student']->student_id);
        $this->data['student_data'] = Helper_Main::unserializeData(
            Helper_User::getUserData($user));
        $this->data['student_data']['age'] = 
                Helper_User::get_user_age($this->data['student_data']['dob']['ec']);
        $this->data['student_data']['academic_year'] = 
            ORM::factory('academicyear', $this->data['student']->start_year)->name.'/'.
            ORM::factory('academicyear', $this->data['student']->end_year + 1)->name;
        $this->data['period']  = Model::factory('setting')->get_value('academic_period');
        $this->data['home_room_teacher']  = Model::factory('class_template')
                ->get_home_room_teacher_by_class_id($this->data['student']->class_id);

    }
    
    private function set_total_subjects_records()
    {
//            $i = $this->data['student']->end_year;
        $year_count = 0;
        $total_subjects_records = array();
        for ($i = $this->data['student']->start_year; $i <= $this->data['student']->end_year; $i++) 
        {
            $data['year'] = $i;
            $data['student'] = $this->data['student'];
            $result['subjects'] = Model::factory('year_subject')->get_subject_records($data);
            $result['grade'] = Model::factory('class')
                    ->get_class_name($result['subjects'][0]->class);
            $result['academic_year'] = 'academic_year';
            $year = Model::factory('academicyear')
                ->get_academic_year_by_id($i)->name;
            $result['year'] = $year.'/'.($year + 1);
            $total_subjects_records[] = $result;
            $year_count++;
        }
        $this->data['year_count'] = $year_count;
        return $total_subjects_records;
    }
}