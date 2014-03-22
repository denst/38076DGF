<?php

class Model_Record_Teacher_Disciplinary extends ORM {

    protected $_table_name  = 'dg_dscplnrrcrds_tchrs';
    
    public function rules()
    {
            return array(
                    'record' => array(
                            array('not_empty')),
                    'notes'  => array(
                            array('not_empty')),
                    'action' => array(
                            array('not_empty')                        
                    )
            );
    }
    
    public function get_teacher_disciplinary_by_id($id)
    {
        $disciplinary = ORM::factory('record_teacher_disciplinary', $id);
        return $disciplinary;
    }

    public function get_teacher_disciplinary($year_id, $teacher)
    {
        $disciplinary = ORM::factory('record_teacher_disciplinary')
            ->where('year_id', '=', $year_id)
            ->where('teacher_id', '=', $teacher->teacher_id)
            ->find_all();
        return $disciplinary;
    }
    
    public function create_disciplinary($post)
    {
        try
        {
            $post = Arr::map('strip_tags', $post);
            $post['date']       = !empty($post['date']) ? strtotime($post['date']) : time();
            $post['year_id']    = ORM::factory('academicyear')
                    ->where('name', '=', Helper_Main::getCurrentYear())
                    ->find()->id;
            ORM::factory('record_teacher_disciplinary')->values($post,
                    array('record', 'notes', 'action', 'date', 'year_id', 
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
    
    public function edit_disciplinary($post)
    {
        try 
        {
            $post = Arr::map('strip_tags', $post);
            $post['date']       = !empty($post['date']) ?
                strtotime($post['date']) : time();
            $data['record']  = $this
                    ->get_teacher_disciplinary_by_id($post['record_id']);
            $data['record']->values($post, 
                    array('record', 'notes', 'action', 'date', 
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
    
    public function delete_disciplinary($id)
    {
        $record = ORM::factory('record_teacher_disciplinary', $id);
        if($record->loaded())
        {
            $record->delete();
            return true;
        }
        else
            return false;
    }
}