<?php

class Model_Record_Academic extends ORM {
    protected $_table_name  = 'dg_acdmrcrds';

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
            $link = $student_id . '/' . $year_id . '/' . urlencode($class) . '/' . $period . '/' . $record_total->id;
        }else{
            $link = $student_id . '/' . $year_id . '/' . urlencode($class) . '/' . $period;
            $total = $total_perc != 0 ? $total_perc .'%' : '-';
        }
        
        return $total . (Helper_User::getUserRole($user) == 'sadmin' || Helper_User::getUserRole($user) == 'admin' || (!is_null($current_class) && $user->id == ORM::factory('class_template', $current_class)->teacher_id) ? ' ' . '<a href="' . URL::base() . 'academic-records/change-total/' . $link . '">override total</a>' : '');
    }
}