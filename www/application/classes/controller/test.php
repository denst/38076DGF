<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Test extends Controller {
    
    public function action_index()
    {
        echo 'in test';
        $result = file_get_contents('http://kinoafisha.ua/kinoafisha/');
        echo $result;
    }
}
