<?php

class Model_Period_Dates extends ORM {
    protected $_table_name  = 'dg_academic_dates';
    
    private $errors = array();
    
    private function post_validation($post)
    {
        for ($i = 0; $i < count($post['period_dates'][$post['period']]); $i++) 
        {
            $validate = Validation::factory();
            if(! Valid::date($post['period_dates'][$post['period']][$i]))
            {
                $this->errors = $validate->errors('products');
            }
//            $post['period_dates'][$post['period']][$i]
        }
//        $validate
//            ->rule('name', 'not_empty')
//            ->rule('name', array($this, 'name_unique'),  array(':value', $product_id))
//            ->rule('price', 'not_empty')
//            ->rule('price', 'numeric')
//            ->rule('weight', 'not_empty')
//            ->rule('weight', 'numeric')
//            ->rule('quantity', 'numeric')
//            ->rule('shipping_cost', 'numeric');
        if(! $validate->check())
        {
            $this->errors = $validate->errors('products');
            return false;
        }
        else
            return true;
    }
    
    public function set_pariod_dates($post)
    {
//        if($this->post_validation($post))
//        {
            $number = 1;
            DB::delete('dg_academic_dates')->execute();
            for ($i = 0; $i < count($post['period_dates'][$post['period']]); $i++) 
            {
                $query = DB::insert('dg_academic_dates', 
                    array('period_id', 'order', 'from', 'to'))
                        ->values(
                            array($post['period'], $number, 
                                Helper_Times::parsing_time(
                                        $post['period_dates'][$post['period']][$i]),
                                Helper_Times::parsing_time(
                                        $post['period_dates'][$post['period']][++$i])
                            )
                        )->execute();
                $number++;
            }
            return true;
//        }
//        else
//            return false;
    }
    
    public function get_period_dates($data)
    {
        
        $period_dates = ORM::factory('period_dates')
                ->where('period_id', '=', $data['period']->value)
                ->find_all()->as_array();
        return $period_dates;
    }
    
    public function get_errors()
    {
        return $this->errors;
    }
}