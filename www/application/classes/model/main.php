<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Main extends ORM {
    
    /*
     * Get users by id
     */
    public function get_user_by_id($id)
    {
        if(is_numeric($id))
        {
            $user =  ORM::factory('user', $id);
            if($user->loaded())
                return $user;
        }
        else
            return false;
    }
    
    public function approve_user($id)
    {
        $user = ORM::factory('user', $id);
        if($user->loaded())
        {
            $user->status = 1;
            $user->save();
            return $user;
        }
        else
            return false;
    }
}
