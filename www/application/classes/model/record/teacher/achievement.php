<?php

class Model_Record_Teacher_Achievement extends ORM {

    protected $_table_name  = 'dg_achvmntrcrds_tchrs';
    
    public function rules()
    {
            return array(
                    'achievement' => array(
                            array('not_empty')),
                    'notes' => array(
                            array('not_empty')                        
                    ),
            );
    }
    
    public function get_teacher_achievement_by_id($id)
    {
        $achievement = ORM::factory('record_teacher_achievement', $id);
        return $achievement;
    }

    public function get_teacher_achievement($year_id, $teacher)
    {
        $achievement = ORM::factory('record_teacher_achievement')
                ->where('year_id', '=', $year_id)
                ->where('teacher_id', '=', $teacher->teacher_id)->find_all();
        return $achievement;
    }
    
    public function create_achievement($post)
    {
        try
        {
            $post = Arr::map('strip_tags', $post);
            $post['date']       = !empty($post['date']) ? strtotime($post['date']) : time();
            $post['year_id']    = ORM::factory('academicyear')
                    ->where('name', '=', Helper_Main::getCurrentYear())
                    ->find()->id;
            $post['teacher_id'] = $post['teacher_id'];
            ORM::factory('record_teacher_achievement')->values($post,
                    array('achievement', 'notes', 'date', 'year_id', 
                        'teacher_id'))
                    ->create();
            return $post['year_id'];
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function edit_achievement($post)
    {
        try 
        {
            $post = Arr::map('strip_tags', $post);
            $post['date']       = !empty($post['date']) ?
                strtotime($post['date']) : time();
             $data['record']  = Model::factory('record_teacher_achievement')
                ->get_teacher_achievement_by_id($post['record_id']);
            $data['record']->values($post, 
                    array('achievement', 'notes', 'date', 
                        'year_id', 'teacher_id'))
                    ->update();
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function delete_achievement($id)
    {
        $record = ORM::factory('record_teacher_achievement', $id);
        if($record->loaded())
        {
            $record->delete();
            return true;
        }
        else
            return false;
    }
}