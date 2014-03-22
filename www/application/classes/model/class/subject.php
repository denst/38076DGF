<?php

class Model_Class_Subject extends ORM {
    protected $_table_name  = 'dg_sbjcts_clsss';
    protected $_primary_key = 'id';
    
    protected $_has_many  = array(
        'subjects' => array('model' => 'subject', 'foreign_key' => 'id')
    );
    
    public function get_subjects_by_class_id($class_id)
    {
        $subjects = ORM::factory('class_subject')
                ->select('dg_sbjcts.name', 'dg_sbjcts.pid')
                ->join('dg_sbjcts')
                ->on('dg_sbjcts.id', '=', 'class_subject.subject_id')
                ->where('class_id', '=', $class_id)
                ->order_by('dg_sbjcts.pid')
                ->order_by('subject_id', 'ASC')
                ->find_all();
        return $subjects;
    }
    
    public function get_subject_by_id($subject_id)
    {
        $subject = ORM::factory('class_subject')
                ->select('dg_sbjcts.name', 'dg_sbjcts.pid')
                ->join('dg_sbjcts')
                ->on('dg_sbjcts.id', '=', 'class_subject.subject_id')
                ->where('class_subject.id', '=', $subject_id)
                ->find();
        return $subject;
    }
    
    public function get_subjects_by_teacher($data)
    {
        $subjects = DB::select(
                array('dg_sbjcts.name', 'subject_name'), 
                array('dg_sbjcts_clsss.class_id', 'class_id'),
                array('dg_tmpl_clsss.name', 'class_name'),
                array('dg_lvls.name', 'level_name'),
                array('dg_tmpl_clsss.teacher_id', 'teacher_id')
        )
        ->from('dg_sbjcts_clsss')
        ->join('dg_sbjcts')->on('dg_sbjcts.id', '=', 'dg_sbjcts_clsss.subject_id')
        ->join('dg_tmpl_clsss')->on('dg_tmpl_clsss.id', '=', 'dg_sbjcts_clsss.class_id')
        ->join('dg_lvls')->on('dg_lvls.id', '=', 'dg_tmpl_clsss.level_id')
        ->where('dg_sbjcts_clsss.teacher_id', '=', $data['teacher']->teacher_id)
        ->as_object()
        ->execute();
        return $subjects;
    }
    
    public function get_subjects_class_by_teacher_id($data)
    {
        $subjects_class =  DB::select('sc.subject_id', 'sc.class_id',
                array('class.teacher_id', 'home_room_teacher'))
            ->from(array('dg_sbjcts_clsss', 'sc'))
            ->join(array('dg_tmpl_clsss', 'class'))
                ->on('class.id', '=', 'sc.class_id')
            ->where('sc.teacher_id', '=', $data['teacher']->teacher_id)
            ->as_object()
            ->execute();
        return $subjects_class;
    }

    public function delete_subject($data)
    {
        $subject_class = ORM::factory('class_subject')
                ->where('subject_id', '=', $data['subject_id'])
                ->and_where('class_id', '=', $data['class_id'])
                ->find();
        if($subject_class->loaded())
        {
            $subject_class->delete();
            return true;
        }
        return false;
    }
    
    public function change_subjects($post)
    {
        try
        {
            for ($i = 0; $i < count($post['subjects']); $i++)
            {
                $subject = ORM::factory('class_subject', $post['subjects'][$i]);
                if($subject->loaded())
                {
                    $subject->scheme = $post['schemes'][$i];
                    $subject->teacher_id = $post['teachers'][$i];
                    $subject->save();
                }
            }
            return true;
        }
        catch (ORM_Validation_Exception $e)
        {
            return false;
        }
    }
//    
//    public function get_subject_teachers()
//    {
//        $teachers =  DB::select('sc.teacher_id')
//            ->distinct(true)
//            ->from(array('dg_sbjcts_clsss', 'sc'))
//            ->where('sc.teacher_id', '!=', 0)
//            ->as_object()
//            ->execute();
//        if(count($teachers) > 0)
//            return $teachers;
//        else
//            false;
//    }
    
    public function get_teacher_by_subject($subject_id)
    {
        $teacher = DB::select('teacher.name',
            'teacher.fathername', 'teacher.grfathername')
            ->from(array('dg_sbjcts_clsss', 'sc'))
            ->join(array('dg_tchrs', 'teacher'))->on('teacher.teacher_id', '=', 'sc.teacher_id')
            ->where('sc.subject_id', '=', $subject_id)
            ->execute()
            ->as_array();
        return $teacher[0];
    }
    
    public function get_subjects_by_subject_name_class_id($student, $subject)
    {
        $subjects = ORM::factory('class_subject')
            ->join('dg_sbjcts')
            ->on('class_subject.subject_id', '=', 'dg_sbjcts.id')
            ->where('dg_sbjcts.name', '=', $subject->subject)
            ->where('class_subject.class_id', '=', $student->class->id)
            ->find();
        return $subjects;
    }
}