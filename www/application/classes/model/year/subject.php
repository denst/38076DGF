<?php

class Model_Year_Subject extends ORM {
    protected $_table_name  = 'dg_yrs_sbjcts_clsss';
    
    public function create_subject_year($data)
    {
        try 
        {
            $subject =  Model::factory('subject')->get_subject_by_id($data['subject']->pid);
            $subject_year = ORM::factory('year_subject')
                ->set('year_id', $data['student']->end_year)
                ->set('class', $data['student']->class->id)
                ->set('subject', $data['subject']->subject_id)
                ->set('parent_subject', 
                    $data['subject']->pid == 0 ? NULL : $subject->name)
                ->save();
             return $subject_year;
        }
        catch (Exception $exc) 
        {
            echo $exc->getTraceAsString();
            return false;
        }

    }

    public function get_subject_records($data)
    {
        $records = ORM::factory('year_subject')
                ->select(array('dg_sbjcts.name', 'subject_name'))
                ->join('dg_acdmrcrds')
                ->on('dg_acdmrcrds.subject', '=', 'year_subject.id')
                ->join('dg_sbjcts')
                ->on('dg_sbjcts.id', '=', 'year_subject.subject')
                ->where('year_subject.year_id', '=', $data['year'])
                ->where('dg_acdmrcrds.student_id', '=', $data['student']->student_id)
                ->order_by('year_subject.parent_subject')
                ->group_by('dg_acdmrcrds.subject')
                ->find_all();
        return $records;
    }
    
//    public function get_subject_records_by_classname($data)
//    {
//        $records = DB::select(
//                array('dg_sbjcts.name', 'subject_name'),
//                array('dg_sbjcts.id', 'subject_id'),
//                array('dg_yrs_sbjcts_clsss.id', 'id'),
//                array('dg_sbjcts.name', 'subject'),
//                array('dg_yrs_sbjcts_clsss.parent_subject', 'parent_subject')
//             )
//            ->from('dg_yrs_sbjcts_clsss')
//            ->join('dg_sbjcts')->on('dg_sbjcts.id', '=', 'dg_yrs_sbjcts_clsss.subject')
//            ->where('dg_yrs_sbjcts_clsss.class', '=', $data['student']->class->id)
//            ->where('year_id', '=', $data['year'])
//            ->order_by('parent_subject')
//            ->as_object()
//            ->execute();
//        return $records;
//    }
    
    public function get_subjects_year($data)
    {
        $records = ORM::factory('year_subject')
            ->where('subject', '=', $data['subject']->subject_id)
            ->where('class', '=', $data['student']->class->id)
            ->where('year_id', '=', $data['student']->end_year)
            ->find();
        if(empty($records->id))
            return $this->create_subject_year($data);
        else
            return $records;
    }
    
    public function delete_subject_year($data)
    {
        try 
        {
            $subject_year = ORM::factory('year_subject')
                ->where('subject', '=', $data['subject_id'])
                ->where('class', '=', $data['class_id'])
                ->find();
            if($subject_year->loaded())
            {
                Model::factory('record_academic')
                    ->delete_academic_by_subject($subject_year->id);
                $subject_year->delete();
            }
            return true;
        }
        catch (ORM_Validation_Exception $exc) 
        {
//            exit($exc->errors());
            return false;
        }
    }
    
    public function check_year_subject_exist($data)
    {
        $subject_class = ORM::factory('year_subject')
            ->where('year_id', '=', $data['year'])
            ->where('subject', '=', $data['subject_id'])
            ->where('class', '=', $data['class_id'])
            ->find();
        if($subject_class->loaded())
            return $subject_class;
        else
            return false;
    }
}