<?php defined('SYSPATH') or die('No direct script access.');

class My_LoggedUserController extends My_UserController
{
    protected $user_data;   
    
    public function before()
    {
        parent::before();
        $this->logget_user = Auth::instance()->get_user();
        if(empty($this->logget_user->id))
            $this->request->redirect('');
        $this->user_data = Helper_User::getUserData($this->logget_user);
    }
}
