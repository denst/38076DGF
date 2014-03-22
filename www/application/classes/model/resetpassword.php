<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_ResetPassword extends ORM {
    
    protected $_table_name = 'dg_reset_password';
    
    private $user_id;
    
    private $errors;

    public function write_temp_link($user, $email, $temp_link)
    {
        try 
        {
            $value = ORM::factory('resetpassword')
                ->set('user_id', $user->id)
                ->set('email', $email)
                ->set('temp_link', $temp_link)
                ->set('status', 'send')
                ->set('date', date("Y-m-d H:m:s"))
                ->save();
           return true;
        }
        catch (Exception $exc) 
        {
            return false;
        }
    }
    
    public function get_reset_password($temp_link)
    {
        $item = ORM::factory('resetpassword')
            ->where('temp_link', '=', $temp_link)
            ->find();
        if($item->loaded())
            return $item;
        else
            return false;
    }

    public function check_link($temp_link)
    {
        if(($reset_password = $this->get_reset_password($temp_link)))
        {
            if($reset_password->status == 'used')
            {
                $this->errors = 'This link is already used';
                return false;
            }
            $reset_password_array = $reset_password->as_array();
            $this->user_id = $reset_password_array['user_id'];
            $reset_password->set('status', 'used')->update();
            return true;
        }
        else
        {
            $this->errors = 'This link is incorrect';
            return false;
        }
    }
    
    public function check_email($email)
    {
        switch ($email) {
            case '':
                $this->errors = "email field can't be empty";
                break;
            case ! Valid::email($email):
                $this->errors = 'email format must be correct';
                break;
            case ! ($user = Model::factory('auth_user')->check_email($email)):
                $this->errors = 'sorry, this email does not exist in the system';
                break;
            default:
                $error_clear = true;
        }
        if(isset($error_clear))
            return $user;
        else
            return false;
    }
    
    public function get_user_id()
    {
        return $this->user_id;
    }
    
    public function get_errors()
    {
        return $this->errors;
    }
}
