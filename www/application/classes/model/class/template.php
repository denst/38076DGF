<?php

class Model_Class_Template extends ORM {
    
    protected $_table_name  = 'dg_tmpl_clsss';
    
    protected $_has_many    = array(
        'students' => array('model' => 'student', 'foreign_key' => 'class_id')
    );
    
    protected $_belongs_to  = array(
        'level'  => array('model' => 'level', 'foreign_key' => 'level_id'),
        'teacher'  => array('model' => 'teacher', 'foreign_key' => 'teacher_id')
    );
    
    public function get_all_classes($class_template, $year_id)
    {
        $all_classes = $class_template
                ->where('year_id', '=', $year_id)
                ->find_all();
        return $all_classes;
    }
    
    public function get_class_by_id($class_id)
    {
        $class = ORM::factory('class_template', $class_id);
        if($class->loaded())
            return $class;
        else
            return false;
    }
    
    public function delete_student($post)
    {
        $student = ORM::factory('student', $post['student_id']);
        if($student->loaded())
        {
            $student->class_id = NULL;
            $student->save();
            return true;
        }
        return false;
    }
    
    public function get_home_room_teacher_by_class_id($class_id)
    {
        $teacher = DB::select('teacher.name',
            'teacher.fathername', 'teacher.grfathername')
                ->from(array('dg_tmpl_clsss', 'class'))
                ->join(array('dg_tchrs', 'teacher'))->on('teacher.teacher_id', '=', 'class.teacher_id')
                ->where('class.id', '=', $class_id)
                ->execute()
                ->as_array();
        return $teacher[0];
    }
    
    public function get_home_room_teachers()
    {
        $teachers = ORM::factory('class_template')
                ->select(array('class_template.id', 'class_id'))
            ->where('teacher_id', '!=', 0)
            ->find_all();
        if(count($teachers) > 0)
            return $teachers;
        else
            return false;
    }
}