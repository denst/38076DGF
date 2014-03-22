<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Students extends My_LoggedUserController {
    
    /*
     * Show all students
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') {
            return $this->request->redirect('');
        }
        $data['students'] = ORM::factory('user')
                ->select('dg_stdnts.name', 'fathername', 'grfathername', 
                        array('dg_lvls.name', 'level_name'))
                ->join('dg_stdnts')
                ->on('user.id', '=', 'dg_stdnts.student_id')
                ->join('dg_lvls')
                ->on('dg_stdnts.academic_year', '=', 'dg_lvls.id')
                ->order_by('dg_lvls.order')->find_all();
        $data['user']  = $this->logget_user;
        $data['level_list']  = Model::factory('level')->get_level_list();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['slider'] = View::factory('students/slider')
                ->set('students', $data['students'])
                ->render();
        $data['table'] = View::factory('students/table')
                ->set('students', $data['students'])
                ->set('user', $data['user'])
                ->render();
        $data['create_student'] = View::factory('students/create')
                ->render();
//        
//        $data['sidebar'] = View::factory('students/sidebar')
//                ->set('sidebar_index', 'registration')
//                ->render();
        Helper_Output::factory()
//                ->link_css('bootstrap');
                ->link_css('laguadmin/lib/datatables/css/table_jui')
                ->link_js('js/laguadmin/students');
        $this->setTitle('Students')
                ->view('students/list', $data)
                ->render();
    }

    /*
     * Create new student 
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') {
            return $this->request->redirect('');
        }
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
                $user->status   = 1;
                $user->save();
                $_POST['student_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                $year = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
                $_POST['start_year'] = $_POST['end_year'] = $year;
                ORM::factory('student')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('student_id', 'academic_year', 'dob', 'sex', 'address', 'father', 'mother', 'quardian', 'tels_em', 'languages', 'health', 'siblings', 'name', 'fathername', 'grfathername', 'image', 'start_year', 'end_year'))->create();
                $this->request->redirect('students/list');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/students');
        $this->setTitle('New Student')
            ->view('students/newStudent', $data)
            ->render();
    }

    /*
     * Edit student
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') {
            return $this->request->redirect('');
        }
        if($this->request->post()){
            if(Helper_User::getUserRole($this->logget_user) == 'teacher') {
                return $this->request->redirect('');
            }
            $student = ORM::factory('student')->where('student_id', '=', $this->request->param('id'))->find();
            if(!empty($_FILES['image']['name'])){
                $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                @unlink(Kohana::$config->load('config')->get('image_dir') . $student->image);
            }
            $student->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('academic_year', 'dob', 'sex', 'address', 'father', 'mother', 'quardian', 'tels_em', 'languages', 'health', 'siblings', 'name', 'fathername', 'grfathername', 'image'))->update();
            $data['success'] = 'Student successful edit';
        }
        $data['levels']   = ORM::factory('level')->order_by('order')->find_all();
        $data['teacher']   = Helper_User::getUserRole($this->logget_user) == 'teacher' ? TRUE : FALSE;
        $data['user']      = ORM::factory('user', $this->request->param('id'));
        if(empty($data['user']->id)) $this->request->redirect('');
        $data['user_data'] = Helper_Main::unserializeData(Helper_User::getUserData($data['user'])->as_array());
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        Helper_Output::factory()
                ->link_js('/js/user/index')
                ->link_js('/js/user/students')
                ->link_js('/js/laguadmin/students_edit')
                ->link_css('/laguadmin/lib/jquery-ui/css/smoothness/jquery-ui-1.8.15.custom');
        $this->setTitle('Edit student')
                ->view('students/edit', $data)
                ->render();
    }
}