<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Session extends My_UserController {

    /*
     * Login page
     */
    public function action_index()
    {
        if (Auth::instance()->logged_in()) {
            return $this->request->redirect('main');
        }
        $data = array();
        if ($this->request->post()) {
            if (Helper_User::loginUser($this->request->post('username'), $this->request->post('password')) === FALSE) {
                $data['error'] = 'Wrong combination login/password or user not activate';
            } else {
                $this->request->redirect('main');
            }
        }
        $data['login_form'] = View::factory('session/index');
        Helper_Output::factory()->link_js('js/laguadmin/login');
        $this->setTitle('Login')
            ->view('session/index', $data)
            ->render();
    }

    public function action_logout()
    {
        Auth::instance()->logout();
        return $this->request->redirect('');
    }

    /*
     * Registration for student
     */
    public function action_student_registration()
    {
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['username']         = mt_rand(100, 900) . 'user';
                $dob                       = $this->request->post('dob');
                $password                  = str_replace('-', '', $dob['gc']);
                $_POST['password']         = $password;
                $_POST['password_confirm'] = $password;
                $_POST['change_password']  = 1;
                $user = ORM::factory('user')->create_user($_POST, array('username', 'password', 'change_password'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'student')->find());
                $user->username = Helper_Main::academicYear($this->request->post('academic_year')) . date('y') . Helper_Main::roundString($user->id);
                $user->save();
                $_POST['student_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                ORM::factory('student')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('student_id', 'academic_year', 'dob', 'sex', 'address', 'father', 'mother', 'quardian', 'tels_em', 'languages', 'health', 'siblings', 'name', 'fathername', 'grfathername', 'image'))->create();
                Session::instance()->set('login', $user->username);
                $this->request->redirect('thankyou');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/students');
        $this->setTitle('Registrate')
            ->view('session/registrateForStudent', $data)
            ->render();
    }
    
    /*
     * Registration for teacher
     */
    public function action_teacher_registration()
    {
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['username'] = mt_rand(100, 900) . 'teacher';
                $user = ORM::factory('user')->create_user($_POST, array('username', 'password'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'teacher')->find());
                $user->username = date('my', strtotime($this->request->post('dob'))) . Helper_Main::roundString($user->id);
                $user->save();
                $_POST['teacher_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                ORM::factory('teacher')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('teacher_id', 'fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'qualification', 'experience', 'name', 'image'))->create();
                Session::instance()->set('login', $user->username);
                $this->request->redirect('thankyou');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/teachers');
        $this->setTitle('Student Registrate')
            ->view('session/registrateForTeacher', $data)
            ->render();
    }
    
    /*
     * Registration for admin
     */
    public function action_admin_registration()
    {
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['username'] = mt_rand(100, 900) . 'admin';
                $user = ORM::factory('user')->create_user($_POST, array('username', 'password'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'admin')->find());
                $user->username = date('my', strtotime($this->request->post('dob'))) . Helper_Main::roundString($user->id);
                $user->save();
                $_POST['admin_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                ORM::factory('admin')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('admin_id', 'fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'name', 'image'))->create();
                Session::instance()->set('login', $user->username);
                $this->request->redirect('thankyou');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/admins');
        $this->setTitle('Registrate')
            ->view('session/registrateForAdmin', $data)
            ->render();
    }

    /*
     * Thank you page
     */
    public function action_thankyou()
    {
        $this->setTitle('Thankyou')
            ->view('session/thankyou', array('text' => 'Thanks for registration. You are login: <strong>' . Session::instance()->get_once('login') . '</strong>. Expect to administrator approval.'))
            ->render();
    }
}