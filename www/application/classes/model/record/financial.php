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
    
    public function get_financial_count($data, $paid)
    {
        $record = ORM::factory('record_financial')
            ->where('student_id', '=', $data['student'])
            ->where('period', '=', $data['period'])
            ->where('paid', '=', $paid)
            ->where('year_id', '=', $data['year'])
            ->count_all();
        return $record;
    }
    
    public function get_financial_early($data, $paid)
    {
        $record = ORM::factory('record_financial')
            ->where('student_id', '=', $data['student'])
            ->where('period', '=', $data['period'])
            ->where('paid', '=', $paid)
            ->where('year_id', '=', $data['year'])
            ->find()->early;
        return $record;
    }
    
    public function get_financial_record($data)
    {
        $record = ORM::factory('record_financial')
            ->where('student_id', '=', $data['student'])
            ->where('period', '=', $data['period'])
            ->where('order', '=', $data['order'])
            ->where('year_id', '=', $data['year'])
            ->find();
        return $record;
    }
    
    public function check_financial_record_exist($data, $paid)
    {
        $record = ORM::factory('record_financial')
            ->where('year_id', '=', $data['year'])
            ->and_where('level_id', '=', $data['student']->academic_year)
            ->and_where('period', '=', $data['period'])
            ->and_where('order', '=', $data['order'])
            ->and_where('student_id', '=', $data['student']->student_id)
            ->and_where('paid', '=', $paid)
            ->find();
        if($record->loaded())
            return true;
        else
            return false;
    }
    
    public function set_debtors_record($data)
    {
        try 
        {
            ORM::factory('record_financial')
                ->set('year_id', $data['year'])
                ->set('level_id', $data['student']->academic_year)
                ->set('student_id', $data['student']->student_id)
                ->set('class_id', $data['student']->class_id)
                ->set('period', $data['period'])
                ->set('order', $data['order'])
                ->set('paid', 0)
                ->set('annual', 0)
                ->set('early', 0)
                ->set('payment', 0)
                ->create();
            return true;
        }
        catch (ORM_Validation_Exception $ex) 
        {
            echo $ex->errors;
            return false;
        }
    }

    public function payment($data)
    {
        try 
        {
            $record = $this->get_financial_record($data);
            if(empty($record->id)) 
            {
                $record->student_id = $data['student_id'];
                $record->year_id    = $data['year'];
                $record->period     = $data['period'];
                $record->order      = $data['order'];
                $record->level_id   = $data['student']->level->id;
            }
            $record->early   = 0;
            $record->paid = $data['paid'];
            $record->annual = 1;
            $record->class_id  = $data['student']->class_id;
            if($data['paid'] == 0)
                $data['amount_payment'] = 0;
            $record->payment = $data['amount_payment'];
            $record->save();
            if(isset($data['schoralship']) AND $data['schoralship'] != 0)
                Model::factory('scholarship')->set_scholarship($data);
            else
                Model::factory('scholarship')->delete_scholarship($data);
            if($data['paid'] == 1)
                Model::factory('debtors_financial')->delete_debtor_record($data);
            return true;
        } 
        catch (Exception $exc) 
        {
            echo $exc->getTraceAsString();
            return false;
        }

    }
    
    public function finish_payment($post)
    {
        try 
        {
            for($period = 1; $period <= 5; $period++)
            {
                $period_obj = Helper_Main::getObjectPeriod($period);
                $student = ORM::factory('student', $post['student']);
                for($order = 1; $order <= $period_obj->count; $order++)
                {
                    $data['student'] = $post['student'];
                    $data['student_id'] = $post['student'];
                    $data['period'] = $period;
                    $data['order'] = $order;
                    $data['year'] = $post['year'];
                    $record = $this->get_financial_record($data);
                    if(empty($record->id))
                    {
                        $record->student_id = $post['student'];
                        $record->year_id    = $post['year'];
                        $record->period     = $period;
                        $record->order      = $order;
                        $record->level_id   = $student->level->id;
                        $record->class_id_id   = $student->class_id;
                    }
                    $record->paid   = 1;
                    $record->early  = 1;
                    $record->payment  = round($post['early_repaymen'] / $period_obj->count, 2);
                    $record->save();
                    Model::factory('debtors_financial')->delete_debtor_record($data);
                }
            }
            if(isset($post['scholarship']) AND $post['scholarship'] != 0)
            {
                Model::factory('scholarship')->set_scholarship($post);
            }
            return true;
            
        }
        catch (Exception $exc) 
        {
            return false;
        }

    }
}