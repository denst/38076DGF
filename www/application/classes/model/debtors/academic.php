<?php

class Model_Debtors_Academic extends Model_Debtors_Debtor {
    
    protected $_table_name  = 'dg_debtors_academic';
    
    private $debtors_count = 0;
    
    public function check_users()
    {
        $period = $this->get_current_period();
        $data['year'] = Model::factory('academicyear')->get_end_year();
        $data['period'] = $period['current']->id;
        $home_room_teachers = Model::factory('class_template')
            ->get_home_room_teachers();
        if($home_room_teachers)
        {
            foreach ($home_room_teachers as $teacher) 
            {
                $subjects = Model::factory('class_subject')
                        ->get_subjects_by_class_id($teacher->class_id);
                $data['home_room_teacher'] = $teacher->teacher_id;
                $data['class_id'] = $teacher->class_id;
                foreach ($subjects as $subject) 
                {
                    $data['subject_id'] = $subject->subject_id;
                    $this->check_students($data, $period);
                }
            }
        }
    }
    
    public function get_academic_debtors()
    {
        $result = array();
        $current_year = Model::factory('academicyear')->get_end_year();
        $teachers = $this->get_debtor_teachers($current_year);
        $this->debtors_count += count($teachers);
        foreach ($teachers as $teacher) 
        {
            $teacher['class'] = Model::factory('class')
                ->get_class_name($teacher['class_id']);
            $teacher['students'] = $this->get_students_of_class($teacher['class_id']);
            $result_students = array();
            foreach ($teacher['students'] as $student)
            {
                $student['subjects'] = $this->get_subject_of_student($student['student_id']);
                $result_students[] = $student;
            }
            $teacher['students'] = $result_students;
            $result[] = $teacher;
        }
        return $result;
    }
    
    public function get_subject_of_student($student_id)
    {
        $subject = DB::select(
                array('sbj.name', 'subject'),
                'ac.order',
                array('period.name', 'period'),
                array('teacher.name', 'teacher_name'),
                array('teacher.fathername', 'teacher_fathername'),
                array('teacher.grfathername', 'teacher_grfathername')
            )
             ->from(array('dg_debtors_academic', 'ac'))
             ->join(array('dg_sbjcts', 'sbj'), 'LEFT')->on('sbj.id', '=', 'ac.subject_id')
             ->join(array('dg_academic_periods', 'period'), 'LEFT')
                ->on('period.id', '=', 'ac.period')
             ->join(array('dg_tchrs', 'teacher'))->on('teacher.teacher_id', '=', 'ac.teacher_id')
             ->where('ac.student_id', '=', $student_id)
             ->as_object()
             ->execute();
        return $subject;
    }

    public function get_students_of_class($class_id)
    {
        $students = DB::select(
                array('dg_stdnts.student_id', 'student_id'),
                array('dg_stdnts.name', 'name'),
                array('dg_stdnts.fathername', 'fathername'),
                array('dg_stdnts.grfathername', 'grandfathername')
            )->distinct(TRUE)
             ->from('dg_debtors_academic')
             ->join('dg_stdnts')
             ->on('dg_stdnts.student_id', '=', 'dg_debtors_academic.student_id')
             ->where('dg_debtors_academic.class_id', '=', $class_id)
             ->execute();
        return $students;
    }

    public function get_debtor_classes_by_teacher_id($data)
    {
        $classes = DB::select(
                array('dg_tmpl_clsss.id', 'class_id'),
                array('dg_lvls.name', 'level'),
                array('dg_tmpl_clsss.name', 'class_name')
            )
            ->distinct(true)
            ->from('dg_debtors_academic')
            ->join('dg_tmpl_clsss')->on('dg_tmpl_clsss.id', '=', 'dg_debtors_academic.class_id')
            ->join('dg_lvls')->on('dg_lvls.id', '=', 'dg_tmpl_clsss.level_id')
            ->where('dg_debtors_academic.teacher_id', '=', $data['teacher']['teacher_id'])
            ->order_by('dg_tmpl_clsss.level_id', 'ASC')
            ->order_by('class_name', 'ASC')
            ->execute();
        return $classes;
    }

    public function get_debtor_teachers($year)
    {
        $teachers = DB::select(array( 'ac.home_room_teacher_id', 'teacher_id'),
                'ac.class_id', 'teacher.name', 'teacher.fathername', 
                'teacher.grfathername')
            ->distinct(true)
            ->from(array('dg_debtors_academic', 'ac'))
            ->join(array('dg_tchrs', 'teacher'))
            ->on('teacher.teacher_id', '=', 'ac.home_room_teacher_id')
            ->where('ac.year_id', '=', $year)
            ->execute();
        return $teachers;
    }

    private function check_students($data, $period)
    {
        $students = Model::factory('student')
                ->get_students_of_class($data['class_id']);
        foreach ($students as $student) 
        {
            $data['student'] = $student;
            for ($i = 1; $i <= $period['order']; $i++) 
            {
                $data['order'] = $i;
                if(! Model::factory('record_academic')
                    ->check_academic_record_exist($data) AND
                    ! $this->check_debtor_record($data))
                    $this->set_academic_debtors($data);
            }
        }
    }

    private function set_academic_debtors($data)
    {
        try 
        {
            ORM::factory('debtors_academic')
                ->set('teacher_id', $data['teacher']->teacher_id)
                ->set('student_id', $data['student']->student_id)
                ->set('class_id', $data['class_id'])
                ->set('home_room_teacher_id', $data['home_room_teacher'])
                ->set('subject_id', $data['subject_id'])
                ->set('year_id', $data['year'])
                ->set('period', $data['period'])
                ->set('order', $data['order'])
                ->create();
            return true;
        }
        catch (ORM_Validation_Exception $exc) 
        {
            echo $exc->errors();
            return false;
        }
    }
    
    public function check_debtor_record($data)
    {
        $record = ORM::factory('debtors_academic')
            ->where('student_id', '=', $data['student']->student_id)
            ->where('subject_id', '=', $data['subject_id'])
            ->where('period', '=', $data['period'])
            ->where('order', '=', $data['order'])
            ->find();
        if(Valid::not_empty($record->loaded()))
            return true;
        else
            return false;
    }
    
    public function delete_debtor_record($data)
    {
        $record = ORM::factory('debtors_academic')
            ->where('student_id', '=', $data['student']->student_id)
            ->where('subject_id', '=', $data['subject_id'])
            ->where('period', '=', $data['period'])
            ->where('order', '=', $data['order'])
            ->find();
        if($record->loaded())
        {
            $record->delete();
            return true;
        }
        else
            return false;
    }
    
    public function get_count_academic_debtors()
    {
        return $this->debtors_count;
    }
}