<?php

class Model_Record_Financial extends ORM {

    protected $_table_name  = 'dg_fnnclrcrds';
    
    public static function getStatusPaid($student_id, $period, $order, $year_id)
    {
        $record = ORM::factory('record_financial')->where('student_id', '=', $student_id)->where('period', '=', $period)->where('order', '=', $order)->where('year_id', '=', $year_id)->find();
        return !empty($record->id) ? ($record->paid == 0 ? 'OUTSTANDING' : 'PAID' ) : '-';
    }
    
    public static function getStatusPaidForYear($student_id, $period, $year_id)
    {
        $records = ORM::factory('record_financial')->where('student_id', '=', $student_id)->where('period', '=', $period)->where('year_id', '=', $year_id)->where('paid', '=', 1)->count_all();
        $period_obj = Helper_Main::getObjectPeriod($period);
        return ($period_obj->count - (int)$records) == 0 ? TRUE : FALSE;
    }    
}