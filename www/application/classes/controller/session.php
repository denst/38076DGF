<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends Controller_Layout {

    public function action_index()
    {
        if (Auth::instance()->logged_in())
            $this->users_redirect(Auth::instance()->get_user());
        $data = array();
        if ($this->request->post()) 
        {
            if (Helper_User::loginUser($this->request->post('username'), $this->request->post('password')) === FALSE)
                $data['error'] = 'Wrong combination login/password or user not activate';
            else

                $this->users_redirect(Auth::instance()->get_user());
        }
        
        $data['content'] = View::factory('session/login', $data);
        $data['login_form'] = View::factory('session/index', $data);
        $this->setTitle('Login')
            ->view('session/index', $data)
            ->render();
    }
        
    private function users_redirect($user)
    {
        $role = Helper_User::getUserRole($user);
        switch ($role) {
            case 'sadmin':
                $this->request->redirect('sadmin/dashboard');
                break;
            case 'admin':
                $this->request->redirect('admin/dashboard');
                break;
            case 'teacher':
                $this->request->redirect('teacher/dashboard');
                break;
            case 'student':
                $this->request->redirect('student/dashboard');
                break;
            default :
                $this->request->redirect('main');
        }
    }

    public function action_registerstudent()
    {
        $data = array();
        if ($this->request->post()) {
            $model_student = Model::factory('student');
            if($model_student->create_student($this->request->post(), true))
                $this->request->redirect('session/thankyou');
            else
            {
                $errors = $model_student->get_errors();
                if(Valid::not_empty($errors))
                {
                    foreach ($model_student->get_errors() as $key => $value) {
                        Helper_Message::add('error', $value);
                    }
                    $this->data['errors'] = $errors;
                }
                $this->data['user_data'] = $_POST;
            }
        }
        $data['levels'] = Model::factory('level')->get_levels();
        $data['register'] = true;
        $data['set_footer'] = true;
        $data['content'] = View::factory('students/create_edit', $data);
        $data['login_form'] = View::factory('session/index', $data);
        $this->setTitle('Create students')
            ->view('session/index', $data)
            ->render();
    }
    
    public function action_registerteacher()
    {
        $data = array();
        if ($this->request->post()) {
            if(Model::factory('teacher')->create_teacher($this->request->post(), true))
                $this->request->redirect('session/thankyou');
        }
        
        $data['register'] = true;
        $data['set_footer'] = true;
        $data['content'] = View::factory('teachers/create_edit', $data);
        $data['login_form'] = View::factory('session/index', $data);
        
        $this->setTitle('Create teacher')
            ->view('session/index', $data)
            ->render();
    }
    
    public function action_registeradmin()
    {
        $data = array();
        if ($this->request->post()) {
            if(Model::factory('admin')->create_admin($this->request->post(), true))
                $this->request->redirect('session/thankyou');
        }
        
        $data['register'] = true;
        $data['set_footer'] = true;
        $data['content'] = View::factory('admins/create_edit', $data);
        $data['login_form'] = View::factory('session/index', $data);
        
        $this->setTitle('Create admin')
            ->view('session/index', $data)
            ->render();
    }

    public function action_thankyou()
    {
        if(Valid::not_empty(Session::instance()->get('dropout_student')))
        {
            $this->setTitle('Thankyou')
                ->view('session/thankyou', array('text' => Session::instance()->get_once('dropout_student')))
                ->render();            
        }
        else
        {
            $this->setTitle('Thankyou')
                ->view('session/thankyou', array('text' => 'Thanks for registration. You are login: <strong>' . Session::instance()->get_once('login') . '</strong>. Expect to administrator approval.'))
                ->render();
        }
    }

    public function action_logout()
    {
        Auth::instance()->logout();
        return $this->request->redirect('');
    }
    
    public function action_resetpassword()
    {
        $data = array();
        if (Valid::not_empty($_POST)) 
        {
            $resetpassword_model = Model::factory('resetpassword');
            if($resetpassword_model->check_email($_POST['email']))
            {
                $temp_link = Helper_Password::generate_password(50);
                Model::factory('resetpassword')->write_temp_link($_POST['email'], $temp_link);
                if(Model::factory('email')->reset_password($_POST['email'], $temp_link))
                {
                    Helper_Message::add('success', 'Message has been sent successfully');
                    $this->request->redirect('session');
                }
            }
            else
            {
               $data['error'] = $resetpassword_model->get_errors();
               $data['email'] = $_POST['email'];
            }
        }
        
        $data['content'] = View::factory('session/resetpassword', $data);
        $data['login_form'] = View::factory('session/index', $data);
        $this->setTitle('Login')
            ->view('session/index', $data)
            ->render();
    }
    
    public function action_newpassword()
    {
        $data = array();
        if (Valid::not_empty($_POST)) 
        {

        }
        
        $data['content'] = View::factory('session/newpassword', $data);
        $data['login_form'] = View::factory('session/index', $data);
        $this->setTitle('Login')
            ->view('session/index', $data)
            ->render();
    }
}