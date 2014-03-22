<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Email {

    public function reset_password($user, $email, $temp_link)
    {
        $link_for_reset_password = URL::base('http').'resetpassword/newpassword/'.$temp_link;
        $role = Helper_User::get_db_user_role($user->id).'s';
        $current_user = $user->$role->find();
        $subject = 'Reset the password for the site '.URL::base('http');
        $message = 
            '<div>Hello '.$current_user->name.' '.$current_user->fathername.' '.
                $current_user->grfathername.', you sent a request for an account reset password on '.URL::base('http').'.</div>'. 
            '<div>Please copy this link <a href="'.$link_for_reset_password.'">'.$link_for_reset_password.'</a> '.
            'to the browser to set a new password.';
        if($this->send($email, $subject, $message))
            return true;
        else
            return false; 
    }

    public function send($to, $subject, $message)
    {
        $config = Kohana::$config->load('email');
        Email::connect($config);
        $from = Model::factory('setting')->get_value('email');
        $message = 
            '<html>'.
                '<head>'.
                    '<title>Support</title>'.
                '</head>'.
                '<body>'.
                    nl2br($message).
                '</body>'.
            '</html>';
        $res = Email::send($to, $from, $subject, $message, $html = true);
        if($res > 0)
            return true;
        else
            return false;
    }
}