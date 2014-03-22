<?php

class Model_Level extends ORM {

    protected $_table_name  = 'dg_lvls';
    protected $_has_many = array(
        'template_classes' => array('model' => 'class_template',   'foreign_key' => 'level_id'),
        'students'       => array('model' => 'student', 'foreign_key' => 'academic_year'),
    );
    
    public function rules()
    {
            return array(
                    'name' => array(
                            array('not_empty'),
                            array(array($this, 'unique'), array('name', ':value'))
                    ),
                    'annual' => array(
                        array('numeric')
                    ),
                    'early_repayment' => array(
                        array('numeric')
                    ),
            );
    }
    
    public static function get_min_max_student_year()
    {
        return DB::select(array('MAX("end_year")', 'max_year'),array('MIN("end_year")', 'min_year'))
                   ->from('dg_stdnts')
                   ->as_object()->execute()->as_array()
                   ;
    }
    
    public function get_levels()
    {
        return ORM::factory('level')->order_by('order')->find_all();
    }

    public function get_level_list()
    {
        $level_list = array("pre-school","kindergarten","preparatory","1","2","3","4","5","6","7","8","9","10","11","12");
        return $level_list;
    }
    
    public function get_level_by_id($id)
    {
        $level = ORM::factory('level', $id);
        if($level->loaded())
            return $level;
        else
            return false;
    }

    public function create_level($post)
    {
        try
        {
            $post['order'] = ORM::factory('level')->count_all() + 1;
            $level = ORM::factory('level')->values($post,
                    array('name', 'order'))
                    ->create();
            if(isset($post['classes']))
            {
                foreach ($post['classes'] as $value) {
                    $class           = ORM::factory('class_template');
                    $class->name     = $value;
                    $class->level_id = $level->id;
                    $class->year_id = $post['year'];
                    $class->save();
                }
            }
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function edit_level($post)
    {
        try 
        {
            $level = $this->get_level_by_id($post['level_id']);
            $levels = ORM::factory('level')->where('id', '!=', $level->id)->find_all();
            if(count($levels) > 0){
                foreach($levels as $lvl){
                    if($post['order'] >= $lvl->order && $level->order < $lvl->order){
                        $lvl->order = $lvl->order + 1;
                        $lvl->save();
                    }
                }
            }
            $level->values($post, array('name', 'order', 'annual', 'early_repayment'))->update();
            if(isset($post['classes'])){
                foreach ($post['classes'] as $value){
                    $class           = ORM::factory('class_template');
                    $class->name     = $value;
                    $class->level_id = $level->id;
                    $class->year_id  = $post['year'];
                    try{
                        $class->save();
                    }
                    catch (Kohana_Database_Exception $e){}
                }
            }
            if(isset($post['old_classes'])){
                foreach ($post['old_classes'] as $key => $value) {
                    $class  = ORM::factory('class_template', $key);
                    $class->name = $value;
                    $class->save();
                }
            }
            if(isset($post['delete_classes'])){
                foreach ($post['delete_classes'] as $key => $value) {
                    $class  = ORM::factory('class_template', $key);
                    Helper_User::deleteUsersFromClass($class);
                    $class->delete();
                }
            }
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function delete_level($post)
    {
        try 
        {
            $level = Model::factory('level')->get_level_by_id($post['level_id']);
            $classes = $level->template_classes->find_all();
            if(count($classes) > 0){
                foreach ($classes as $class){
                    Helper_User::deleteUsersFromClass($class);
                }
            }
            if($level->id){
                $level->delete();
            }
            return true;
        }
        catch (Exception $exc) 
        {
            echo $exc->getTraceAsString();
            return false;
        }
    }
    
    public function auto_assigned($post)
    {
        $students_ids    = explode(',', $post['students']);

        $level = Model::factory('level')->get_level_by_id($post['level_id']);
        $students_mens   = ORM::factory('student')
                ->where('sex', '=', '0')
                ->and_where('student_id', 'IN', $students_ids)
                ->find_all();
        $students_womens = ORM::factory('student')
                ->where('sex', '=', '1')
                ->and_where('student_id', 'IN', $students_ids)
                ->find_all();
        $classes = $level->template_classes
                ->where('year_id', '=', $post['year'])
                ->find_all()->as_array();
        Helper_User::autoAssignedClass($students_mens, $students_womens, $classes);
        return true;
    }
    
    public function get_count_unassigned_students($data)
    {
        $unassigned_students = array();
        foreach ($this->get_levels() as $level) 
        {
            $unassigned_students[$level->id] = $level->students
                ->join('dg_usrs')->on('dg_usrs.id', '=', 'student.student_id')
                ->where('dg_usrs.status', '=', 1)
                ->where('end_year', '=', $data['year'])
                ->where('class_id', '=', NULL)->count_all();
        }
        return $unassigned_students;
    }
    
    public function get_unassigned_students($data)
    {
        $unassigned_students = $data['level']->students
            ->join('dg_usrs')->on('dg_usrs.id', '=', 'student.student_id')
            ->where('dg_usrs.status', '=', 1)
            ->where('end_year', '=', $data['year'])
            ->where('class_id', '=', NULL)->find_all();
        return $unassigned_students;
    }
}