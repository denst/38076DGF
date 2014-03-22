<?php

class Model_Debtors_Financial extends Model_Debtors_Debtor {
    
    protected $_table_name  = 'dg_debtors_financial';
    
    private $debtors_count = 0;
    
    public function check_users()
    {
        $period = $this->get_current_period();
        if($period)
        {
            $data['period'] = $period['current']->id;
            $students = Model::factory('student')->get_students();
            foreach ($students as $student) 
            {
                for ($i = 1; $i <= $period['order']; $i++) 
                {
                    $data['order'] = $i;
                    $data['student'] = $student;
                    $data['year'] = $student->end_year;
                    if(! Model::factory('record_financial')
                        ->check_financial_record_exist($data, 1))
                    {
                        $data['student_id'] = $data['student']->student_id;
                        if(! Model::factory('record_financial')
                            ->check_financial_record_exist($data, 0))
                            Model::factory('record_financial')->set_debtors_record($data);
                        if(! $this->check_debtor_record($data))
                            $this->set_financial_debtors($data);
                    }
                }
            }
        }
    }
    
    public function get_debtors_by_class_id($class_id)
    {
        $debtors = DB::select(
                array('dg_stdnts.student_id', 'student_id'),
                array('dg_stdnts.name', 'name'),
                array('dg_stdnts.fathername', 'fathername'),
                array('dg_stdnts.grfathername', 'grandfathername')
            )->distinct(TRUE)
             ->from('dg_debtors_financial')
             ->join('dg_stdnts')
             ->on('dg_stdnts.student_id', '=', 'dg_debtors_financial.student_id')
             ->where('dg_debtors_financial.class_id', '=', $class_id)
             ->execute();
        return $debtors;
    }
    
    public function get_debtors_classes_by_year($year_id)
    {
        $classes = DB::select(
                array('dg_tmpl_clsss.id', 'class_id'),
                array('dg_lvls.name', 'level'),
                array('dg_tmpl_clsss.name', 'class_name')
            )
            ->distinct(true)
            ->from('dg_debtors_financial')
            ->join('dg_tmpl_clsss')->on('dg_tmpl_clsss.id', '=', 'dg_debtors_financial.class_id')
            ->join('dg_lvls')->on('dg_lvls.id', '=', 'dg_tmpl_clsss.level_id')
            ->where('dg_tmpl_clsss.year_id', '=', $year_id)
            ->order_by('dg_tmpl_clsss.level_id', 'ASC')
            ->order_by('class_name', 'ASC')
            ->execute();
        return $classes;
    }

    public function get_debtors_classes()
    {
        $result = array();
        $current_year = Model::factory('academicyear')->get_end_year();
        $classes = $this->get_debtors_classes_by_year($current_year);
        foreach ($classes as $class) 
        {
            $debtors = $this->get_debtors_by_class_id($class['class_id']);
            $this->debtors_count += count($debtors);
            $result_debtors = array();
            foreach ($debtors as $debtor) 
            {
                $debtor['orders'] = $this->get_debtor_orders($debtor['student_id']);
                $result_debtors[] = $debtor;
            }
            $class['debtors'] = $result_debtors;
            $result[] = $class;
        }
        return $result;
    }
    
    public function get_debtors_count()
    {
        return $this->debtors_count;
    }
    
    public function check_debtor_record($data)
    {
        $record = ORM::factory('debtors_financial')
            ->where('student_id', '=', $data['student_id'])
            ->where('order', '=', $data['order'])
            ->where('period', '=', $data['period'])
            ->where('year_id', '=', $data['year'])
            ->find();
        if(Valid::not_empty($record->student_id))
            return $record;
        else
            return false;
    }
    
    public function delete_debtor_record($data)
    {
        if(($record = $this->check_debtor_record($data)))
        {
            $record->delete();
        }
    }

    private function get_debtor_orders($student_id)
    {
        $orders = DB::select(
                array('dg_debtors_financial.order', 'current_order'),
                array('dg_academic_periods.name', 'period')
            )
            ->from('dg_debtors_financial')
            ->join('dg_academic_periods')->on('dg_academic_periods.id', '=', 'dg_debtors_financial.period')
            ->where('dg_debtors_financial.student_id', '=', $student_id)
            ->execute();
        return $orders;
    }

    private function set_financial_debtors($data)
    {
        try 
        {
            ORM::factory('debtors_financial')
                ->set('student_id', $data['student']->student_id)
                ->set('period', $data['period'])
                ->set('order', $data['order'])
                ->set('year_id', $data['year'])
                ->set('class_id', $data['student']->class_id)
                ->create();
            return true;
        }
        catch (ORM_Validation_Exception $exc) 
        {
            echo $exc->errors();
            return false;
        }
    }
}