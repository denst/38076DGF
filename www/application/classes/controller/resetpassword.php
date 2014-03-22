<?php defined('SYSPATH') or die('No direct script access.');

class Controller_ResetPassword extends Controller_Layout {
    
    public function action_index() 
    {
        if(Valid::not_empty($_POST))
        {
            if(isset($_POST['captcha']) AND Captcha::valid($_POST['captcha'])) 
            {
                $resetpassword_model = Model::factory('resetpassword');
                if(($user = $resetpassword_model->check_email($_POST['email'])))
                {
                    $temp_link = Helper_Password::generate_password(50);
                    Model::factory('resetpassword')->write_temp_link($user, $_POST['email'], $temp_link);
                    if(Model::factory('email')->reset_password($user, $_POST['email'], $temp_link))
                    {
                        Helper_Message::add('success', 'Message has been sent successfully');
                        $this->request->redirect('session');
                    }
                    else
                        Helper_Message::add('error', 'Message was not sent');
                }
                else
                {
                   $data['error'] = $resetpassword_model->get_errors();
                   $data['email'] = $_POST['email'];
                }
            }
            else
            {
                $data['email'] = $_POST['email'];
                $data['error'] = 'Invalid captcha';
            }
        }
            
        $data['captcha'] = Captcha::instance();
        $data['content'] = View::factory('session/resetpassword', $data);
        $data['login_form'] = View::factory('session/index', $data);
        $this->setTitle('Reset Password')
            ->view('session/index', $data)
            ->render();
    }
    
    public function action_newpassword()
    {
        $link = $this->request->param('id');
        if($link != '')
        {
            $resetpassword_model = Model::factory('resetpassword');
            if($resetpassword_model->check_link($link))
            {
                $data['user_id'] = $resetpassword_model->get_user_id();
                $data['content'] = View::factory('session/newpassword', $data);
                $data['login_form'] = View::factory('session/index', $data);
                $this->setTitle('New Password')
                    ->view('session/index', $data)
                    ->render();
                return;
            }
            else
            {
                Helper_Message::add('error', $resetpassword_model->get_errors());
                $this->request->redirect('session');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_setnewpassword()
    {
        if(Valid::not_empty($_POST))
        {
            if($_POST['password'] === $_POST['confirm_password'] AND $_POST['password'] != '')
            {
                if(Model::factory('auth_user')->set_new_password($_POST))
                {
                    Helper_Message::add('success', 'The password was successfully changed');
                    $this->request->redirect('session');
                }
            }
            else
            {
                $data['error'] = 'The password and confirm password are different.';
                $data['user_id'] = $_POST['user_id'];
                $data['content'] = View::factory('session/newpassword', $data);
                $data['login_form'] = View::factory('session/index', $data);
                $this->setTitle('New Password')
                    ->view('session/index', $data)
                    ->render();
                return;
            }
        }
        else
            throw new HTTP_Exception_404;
    }
}
