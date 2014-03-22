<?php defined('SYSPATH') or die('No direct script access.');

class Error extends Controller {
    
    public static function handle(Exception $e)
    {
        switch (get_class($e))
        {
            case 'HTTP_Exception_404':
                $response = new Response;
                $response->status(404);
                Helper_Output::factory()
                    ->link_css('/css/style')
                    ->link_css('/laguadmin/css/style');
                $view = View::factory('layouts/main')
                        ->set('title', '404');
                $view->content = View::factory('errors/404');
                echo $response->body($view);
                return TRUE;
                break;
            default:
                return Kohana_Exception::handler($e);
                break;
        }
    }
}