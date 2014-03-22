<?php
defined('SYSPATH') or die('No direct access allowed.');

class Helper_Times {
    
    public static function parsing_time($date)
    {
        $pars_date = date_parse($date);
        $time = mktime(0, 0, 0, $pars_date['month'], $pars_date['day'], $pars_date['year']);
        return $time;
    }
    
    public static function convert_date($time)
    {
        return date("m/d/Y", $time);
    }
}