<?php

class Model_Scholarship extends ORM {

    protected $_primary_key = 'id';


    protected $_table_name  = 'dg_schlrshps';
    
    public function get_scholarship_record($data)
    {
        $record = ORM::factory('scholarship')
            ->where('year_id', '=', $data['year'])
            ->where('student_id', '=', $data['student'])
        ->find();
        if(count($record) > 0)
            return $record;
        else
            return false;
    }
    
    public function set_scholarship($data)
    {
        $scholarship = $this->get_scholarship_record($data);
        if($scholarship)
        {
            $scholarship->year_id    = $data['year'];
            $scholarship->student_id = $data['student'];
            $scholarship->percent = $data['schoralship'];
            $scholarship->save();            
        }
        else
        {
            $scholarship = ORM::factory('scholarship')
                ->set('year_id', $data['year'])
                ->set('student_id', $data['student'])
                ->set('percent', $data['schoralship'])
                ->create();
        }
    }
    
    public function delete_scholarship($data)
    {
        $scholarship = $this->get_scholarship_record($data);
        if($scholarship)
        {
            $scholarship->delete();           
        }
    }
}