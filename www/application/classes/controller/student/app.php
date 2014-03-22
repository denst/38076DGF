<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_App extends Controller_Layout {
    
    protected $objects = array();
    
    public function before()
    {
        parent::before();
        $this->logget_user = Auth::instance()->get_user();
        if(empty($this->logget_user->id) OR
                Helper_User::getUserRole($this->logget_user) != 'student')
            $this->request->redirect('');
        $controller = $this->request->controller();
        $user_objects = UserObjects::factory($this->request, $this->response);
        $this->objects[$controller] = $user_objects->get_object($controller);
        $this->objects[$controller]->safe_id();
    }
}