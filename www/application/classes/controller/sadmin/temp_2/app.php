<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_App extends Controller_Layout {
    
    protected $user_data;   
    
    public function before()
    {
        parent::before();
        $this->logget_user = Auth::instance()->get_user();
        if(empty($this->logget_user->id) OR 
                $this->role = Helper_User::getUserRole($this->logget_user) != 'sadmin')
            $this->request->redirect('');
        $this->user_data = Helper_User::getUserData($this->logget_user);
        $this->set_layout_data(
            array(
                'user' => $this->logget_user,
                'user_info' => $this->user_data,
                'top_menu' => View::factory('layouts/partials/top_menu')
                    ->set('role', $this->role),
                'main_menu' => View::factory('layouts/main_menu/sadmin')
            )
        );
    }
}