<?php
defined('SYSPATH') or die('No direct access allowed.');

class Helper_Password {
    
    public static function generate_password($length = 8) 
    {
        $password = "";
        $possible = "123456789abcdefghjkmnpqrstuvwxyz123456789";
        for ($i = 0; $i < $length; $i++) 
        {
                // pick a random character from the possible ones
                $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
                $password .= $char;
        }
        return $password;
    }
}