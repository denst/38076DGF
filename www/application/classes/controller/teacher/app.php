<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_App extends Controller {
    
    protected $objects = array();
    
    protected $is_set_object = false;

    public function before()
    {
        parent::before();
        $this->logget_user = Auth::instance()->get_user();
        if(empty($this->logget_user->id) OR
                Helper_User::getUserRole($this->logget_user) != 'teacher')
            $this->request->redirect('');
        $controller = $this->request->controller();
        if(! $this->is_set_object)
            $this->set_custome_object($controller);
//        $this->objects[$controller]->safe_id();
    }
    
    public function set_custome_object($object)
    {
        $user_objects = UserObjects::factory($this->request, $this->response);
        if($user_objects)
        {
            $this->objects[$object] = $user_objects->get_object($object);
            $this->objects[$object]->check_approved_users();        
        }
    }
}