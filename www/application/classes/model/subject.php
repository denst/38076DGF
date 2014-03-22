<?php

class Model_Subject extends ORM {
    
    protected $_table_name  = 'dg_sbjcts';

    protected $_has_many = array(
        'teachers' => array('model' => 'teacher','through' => 'dg_tchrs_sbjcts'),
    );
    
    public function rules()
    {
            return array(
                    'name' => array(
                            array('not_empty'),
                            array(array($this, 'unique'), array('name', ':value'))
                    ),
            );
    }
    
    public function create_subject($post)
    {
        try
        {
            ORM::factory('subject')->values($post, array('name', 'pid'))
                    ->create();
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function edit_subject($post)
    {
        try
        {
            ORM::factory('subject', $post['subject_id'])
                ->values($post, 
                        array('name', 'pid'))
                ->update();
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function delete_subject($post)
    {
        try
        {
            $subject = ORM::factory('subject', $post['subject_id']);
            if($subject->loaded())
            {
                $subject->delete();
                return true;
            }
            else 
                return false;
        }
        catch (ORM_Validation_Exception $e)
        {
            return false;
        }
    }

    public function get_subjects_by_teacher($teacher)
    {
        $subjects = $teacher->teachers->find()->subjects->find_all();
        return $subjects;
    }
    
    public function get_all_subjects_order_by_pid()
    {
        $subjects = ORM::factory('subject')->order_by('pid')->find_all();
        return $subjects;
    }
    
    public function get_all_subjects()
    {
        $all_subjects =  ORM::factory('subject')->find_all();
        return $all_subjects;
    }

    public function get_subject_by_id($subject_id)
    {
        $subject = ORM::factory('subject', $subject_id);
        if($subject->loaded())
            return $subject;
        else 
            return false;
    }

    public function associate_subjects($post)
    {
        try 
        {
            $teacher = ORM::factory('teacher', $post['teacher']);
            foreach ($teacher->subjects->find_all() as $subject) {
                $teacher->remove('subjects', $subject);                
            }
            if(isset($post['subjects']))
            {
                foreach ($post['subjects'] as $subject_id) {
                    $teacher->add('subjects', 
                        ORM::factory('subject', $subject_id));
                }
            }
            return true;
        }
        catch (Kohana_Database_Exception $e) 
        {
            return false;
        }
    }
}