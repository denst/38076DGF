<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Class extends ORM {
    
    protected $_table_name  = 'dg_tmpl_clsss';
    
    protected $_has_one    = array(
        'teacher' => array('model' => 'teacher', 'foreign_key' => 'teacher_id')
    );
    
    protected $_has_many    = array(
        'students' => array('model' => 'student', 'foreign_key' => 'class_id')
    );

    protected $_belongs_to  = array(
        'tclass'  => array('model' => 'class_template', 'foreign_key' => 'tclass_id')
    );
    
    public function add_subjects($post)
    {
        try
        {
            foreach ($post['subjects'] as $subject) 
            {
                $class_subject = ORM::factory('class_subject');
                $class_subject->class_id   = $post['class'];
                $class_subject->subject_id = $subject;
                $class_subject->save();
                $class                     = ORM::factory('class_template', $class_subject->class_id);
                $sbj_year                  = ORM::factory('year_subject');
                $sbj_year->year_id         = $class->year_id;
                $subject                   = ORM::factory('subject', $class_subject->subject_id);
                $sbj_year->subject         = $subject->id;
                $sbj_year->parent_subject  = $subject->pid == 0 ? NULL : ORM::factory('subject', $subject->pid)->name;
                $sbj_year->class           = $class->id;
                $sbj_year->save();
            }
            return true;
        }
        catch (Kohana_Database_Exception $e) 
        {
            return false;
        }
    }
    
    public function move_student($post)
    {
        $student = ORM::factory('student', $post['student']);
        if($student->student_id)
        {
            $student->class_id = $post['class'];
            $student->save();
            return true;
        }
        else
            return false;
    }
    
    public function change_teacher($post)
    {
        $class = ORM::factory('class_template', $post['class']);
        if($class->loaded())
        {
            $class->teacher_id = $post['teacher'];
            $class->save();
            return true;
        }
        else
            return false;
    }
    
    public function get_class_by_id($id)
    {
        if(is_numeric($id))
        {
            $class =  ORM::factory('class', $id);
            if($class->loaded())
                return $class;
        }
        else
            return false;
    }
    
    public function get_class_by_teacher_id($id)
    {
        if(is_numeric($id))
        {
            $class =  ORM::factory('class')->where('teacher_id', '=', $id)->find();
            if($class->loaded())
                return $class;
        }
        else
            return false;
    }
    
    public function get_class_name($class)
    {
        if(is_object($class))
            $class_id = $class->id;
        else
            $class_id = $class;
        if($class_id)
        {
            $class_name = DB::select(
                    array('dg_lvls.name', 'level'),
                    array('class.name', 'class')
                )
                ->from(array('dg_tmpl_clsss', 'class'))
                ->join('dg_lvls')->on('dg_lvls.id', '=', 'class.level_id')
                ->where('class.id', '=', $class_id)
                ->execute()
                ->as_array();
            if(Valid::not_empty($class_name))
                return $class_name[0]['level'].' - '.$class_name[0]['class'];
            else
                return $class_name;
        }
        else
            return false;
    }
//    
//    public function get_classes_by_year($year)
//    {
//        $classes = DB::select(
//                array('class.id', 'class_id'),
//                array('dg_lvls.name', 'level'),
//                array('class.name', 'class_name')
//            )
//            ->from(array('dg_tmpl_clsss', 'class'))
//            ->join('dg_lvls')->on('dg_lvls.id', '=', 'class.level_id')
//            ->where('class.year_id', '=', $year)
//            ->order_by('class.level_id', 'ASC')
//            ->order_by('class_name', 'ASC')
//            ->execute();
//        var_dump($classes);
//        exit();
//        if(Valid::not_empty($classes))
//            return $classes;
//        else
//            return false;
//    }
}