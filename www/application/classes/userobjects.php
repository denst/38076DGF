<?php defined('SYSPATH') or die('No direct script access.');

class UserObjects {
    
    private static $requst;
    private static $response;
    private $controllers = array();
    
    public static function factory($request, $response)
    {
        self::$requst = $request;
        self::$response = $response;
        return new UserObjects();
    }
    
    public function get_object($name)
    {
        $this->controllers[$name] = $name; 
        $class_name = 'Controller_Core_'.Text::ucfirst($name);
        $this->controllers[$name] = new $class_name(self::$requst, self::$response);
        $this->controllers[$name]->before();
        return $this->controllers[$name];
    }
}
