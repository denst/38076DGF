<?php

class Model_Record_Disciplinary extends ORM {

    protected $_table_name  = 'dg_dscplnrrcrds';
    
    public function rules()
    {
            return array(
                    'record' => array(
                            array('not_empty')),
                    'action' => array(
                            array('not_empty')                        
                    )
            );
    }
    
    public function get_student_disciplinary_by_id($id)
    {
        $disciplinary = ORM::factory('record_disciplinary', $id);
        return $disciplinary;
    }

    public function get_student_disciplinary($year_id, $student)
    {
        $disciplinary = ORM::factory('record_disciplinary')
                ->where('year_id', '=', $year_id)
                ->where('student_id', '=', $student->student_id)->find_all();
        return $disciplinary;
    }
    
    public function create_disciplinary($post)
    {
        try
        {
            $post['date'] = !empty($_POST['date']) ? strtotime($post['date']) : time();
            $post['year_id']    = ORM::factory('academicyear')
                    ->where('name', '=', Helper_Main::getCurrentYear())
                    ->find()->id;
            ORM::factory('record_disciplinary')
                    ->values($post, 
                            array('record', 'notes', 'action', 
                                'date', 'year_id', 'student_id'))
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
            $post['date']       = !empty($post['date']) ?
                strtotime($post['date']) : time();
            $data['record']  = $this->
                    get_student_disciplinary_by_id($post['record_id']);
            $data['record']->values($post, 
                    array('record', 'notes', 'action', 'date', 
                        'year_id', 'student_id'))
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
        $record = ORM::factory('record_disciplinary', $id);
        if($record->loaded())
        {
            $record->delete();
            return true;
        }
        else
            return false;
    }
}