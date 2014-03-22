<?php

class Model_Record_Academic extends ORM {
    protected $_table_name  = 'dg_acdmrcrds';
    
    private $errors = array();
    
    static public function getAvgRank($student_id, $subject, $period, $type)
    {
        $type = $type . '_ev';
        $query = DB::query(Database::SELECT, "
                                    SELECT AVG(`$type`) AS `avg_score` 
                                    FROM `dg_acdmrcrds` 
                                    WHERE `student_id` = $student_id 
                                    AND `subject` = $subject
                                    AND `period` = $period
                                    GROUP BY `student_id`
                                ");
        $res = $query->as_object()->execute()->current()->avg_score;
        
        switch ($type):
            case 'percentage_ev':
                $avg_score = round($res, 1) . '%';
                break;
            case 'letter_ev':
                switch (round($res)):
                    case '5': 
                        $avg_score = 'A';
                        break;
                    case '4': 
                        $avg_score = 'B';
                        break;
                    case '3': 
                        $avg_score = 'C';
                        break;
                    case '2': 
                        $avg_score = 'D';
                        break;
                    case '1': 
                        $avg_score = 'E';
                        break;
                    case '0': 
                        $avg_score = 'F';
                        break;
                endswitch;
                break;
            case 'comment_ev':
                switch (round($res)):
                    case '4': 
                        $avg_score = 'Excellent';
                        break;
                    case '3': 
                        $avg_score = 'Very Good';
                        break;
                    case '2': 
                        $avg_score = 'Good';
                        break;
                    case '1': 
                        $avg_score = 'Satisfactory';
                        break;
                    case '0': 
                        $avg_score = 'Poor';
                        break;
                endswitch;
                break;
        endswitch;
        return $avg_score;
    }

    static public function getStudentRank($student_id, $subject, $period, $type)
    {
        $type = $type . '_ev';
        $students = ORM::factory('record_academic')->where('subject', '=', $subject)->where('period', '=', $period)->group_by('student_id')->find_all();
        $query = DB::query(Database::SELECT, "SELECT `student_id`, AVG(`$type`) AS `avg_score` 
                                        FROM `dg_acdmrcrds` 
                                        WHERE `subject` = $subject
                                        AND `period` = $period
                                        GROUP BY `student_id` 
                                        HAVING `avg_score` > (
                                            SELECT AVG(`$type`) 
                                            FROM `dg_acdmrcrds` 
                                            WHERE `student_id` = $student_id 
                                            AND `subject` = $subject
                                            AND `period` = $period
                                            GROUP BY `student_id`
                                        )");

        $rank      = count($query->as_object()->execute()) + 1;
        return $rank . '/' . count($students);
    }
    
    static public function existRecordByPeriodOrder($student_id, $subject, $period, $order)
    {
        $record = ORM::factory('record_academic')->where('period', '=', $period)->where('subject', '=', $subject)->where('student_id', '=', $student_id)->where('order', '=', $order)->find();
        return !empty($record->id) ? FALSE : TRUE;
    }
    
    static public function getTotalStudentRank($student_id, $subjects_ids, $subjects, $period)
    {
        $students = ORM::factory('record_academic')->where('period', '=', $period)->where('subject', 'IN', $subjects_ids)->group_by('student_id')->find_all();
        $all_total    = array();
        foreach($students as $student){
            $sum = 0;
            foreach ($subjects as $subject){
                $records = ORM::factory('record_academic')->where('student_id', '=', $student->student_id)->where('subject', '=', $subject->id)->where('period', '=', $period)->find_all();
                if(count($records) > 0){
                    $sum += self::getStudentRank($student->student_id, $subject->id, $period, Helper_Main::getRatingType($records[0]));
                }
            }
            $all_total[$student->student_id] = $sum;
        }
        asort($all_total);
        $i = 1;
        foreach ($all_total as $key => $value) {
            if(!empty($prev_value) && $value == $prev_value){
                $all_total[$key] = $current;
            }else{
                $all_total[$key] = $i;
                $current = $i;
            }
            $prev_value = $value;
            $i++;
        }
        return !empty($all_total[$student_id]) ? $all_total[$student_id] . '/' . count($all_total) : '-';
    }

    static public function getTotal($student_id, $year_id, $class, $period, $total_perc, $user, $current_class)
    {
        $record_total = ORM::factory('record_total')->where('year_id', '=', $year_id)->where('class', '=', $class)->where('student_id', '=', $student_id)->where('period', '=', $period)->find();
        if(!empty($record_total->id)){
            $total = Helper_Main::getRatingFromRecord($record_total);
            $link = $student_id . '&' . $year_id . '&' . urlencode($class) . '&' . $period . '&' . $record_total->id;
        }else{
            $link = $student_id . '&' . $year_id . '&' . urlencode($class) . '&' . $period;
            $total = $total_perc != 0 ? $total_perc .'%' : '-';
        }
        
        if((Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin'))
            return $total.' <a href="'.URL::base().'sadmin/academicrecords/changetotal/'.$link.'">override total</a>';
        else
            return $total;
    }
    
    public function create_academic($post, $data)
    {
        try 
        {
            if(isset($post['percentage_ev']) AND !$this->check_percentage($post['percentage_ev']))
                return false;
            $post['date']       = time();
            $post['subject']    = $data['subject_id'];
            $post['student_id'] = $data['student']->student_id;
            $post['period']     = $data['period']->value;
            ORM::factory('record_academic')
                ->values($post, 
                    array('order', 'period', 'subject', 'date', 
                        'year_id', 'class', 'student_id', 'percentage_ev', 
                        'letter_ev', 'comment_ev'))
                ->create();
            $value = $data;
            $value['period'] = $data['period']->value;
            $value['subject_id'] = $post['subject_id'];
            $value['order'] = $post['order'];
            if(Model::factory('debtors_academic')->check_debtor_record($value))
                Model::factory('debtors_academic')->delete_debtor_record($value);
            return true;
        }
        catch (Exception $exc) 
        {
//            echo $exc->getTraceAsString();
            return false;
        }
    }
    
    public function delete_academic($data)
    {
        try 
        {
            $record = ORM::factory('record_academic', $data['record_id']);
            $record->delete();
            return true;
        }
        catch (Exception $exc) 
        {
            echo $exc->getTraceAsString();
            return false;
        }
    }
    
    public function delete_academic_by_subject($subject_id)
    {
        try 
        {
            $record = ORM::factory('record_academic')
                ->where('subject', '=', $subject_id)
                ->find();
            if($record->loaded())
                $record->delete();
            return true;
        }
        catch (Exception $exc) 
        {
            return false;
        }
    }
    
    public function change_total($post, $data)
    {
        switch ($post['scheme']) 
        {
            case 0:
                if(isset($post['percentage_ev']) 
                        AND !$this->check_percentage($post['percentage_ev']))
                    return false;
                $post['comment_ev'] = NULL;
                break;
            case 1:
                $post['percentage_ev']  = NULL;
                $post['comment_ev']     = NULL; 
                break;
            default:
                $post['percentage_ev'] = NULL;
                $post['letter_ev']     = NULL;
                break;
        }

        if(isset($data['id']) AND Valid::not_empty($data['id']))
            ORM::factory('record_total', $data['id'])
                ->values($post, 
                        array('letter_ev', 'comment_ev', 'percentage_ev'))
                ->update();
        else
        {
            $post['student_id'] = $data['student_id'];
            $post['year_id']    = $data['year'];
            $post['class']      = $data['class'];
            $post['period']     = $data['period'];
            ORM::factory('record_total')
                ->values($post, array('student_id', 'year_id', 'class', '
                    period', 'letter_ev', 'comment_ev', 'percentage_ev'))
                ->create();
        }
        return true;
    }

    public function get_errors()
    {
        return $this->errors;
    }
    
    public function check_academic_record_exist($data)
    {
        $subject_class = Model::factory('year_subject')
                ->check_year_subject_exist($data);
        if($subject_class)
        {
            $academic_records = ORM::factory('record_academic')
                ->where('subject', '=', $subject_class->id)
                ->where('period', '=', $data['period'])
                ->where('order', '=', $data['order'])
                ->where('student_id', '=', $data['student']->student_id)
                ->find();
            if($academic_records->loaded())
                return true;
            else
                return false;
        }
        else
            return false;
    }
    
    public function get_subject_records($student, $subject, $period)
    {
         $records = ORM::factory('record_academic')
            ->where('student_id', '=', $student->student_id)
            ->where('subject', '=', $subject->id)
            ->where('period', '=', $period)
            ->find_all();
//    var_dump($records);
//    exit();
         return $records;
    }

    private function check_percentage($percentage)
    {
        if(isset($percentage))
        {
            switch ($percentage) 
            {
                case '':
                    $this->errors = 'Enter the percentage of';
                    return false;
                    break;
                case (!is_numeric($percentage)):
                    $this->errors = 'The percentage must be a number';
                    return false;
                    break;
            }
        }
        return true;
    }
}