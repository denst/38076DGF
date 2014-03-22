<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teachers extends My_LoggedUserController {

    /*
     * Show all teachers
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $data['teachers'] = ORM::factory('user')
                ->select('dg_tchrs.name', 'dg_tchrs.fathername', 'dg_tchrs.grfathername')
                ->join('dg_tchrs')
                ->on('user.id', '=', 'dg_tchrs.teacher_id')
                ->order_by('status')->find_all();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        Helper_Output::factory()
//                ->link_css('bootstrap');
                ->link_js('js/laguadmin/students');
        $this->setTitle('Teachers')
                ->view('teachers/list', $data)
                ->render();
    }

    /*
     * Create new teacher
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['username'] = mt_rand(100, 900) . 'teacher';
                $user = ORM::factory('user')->create_user($_POST, array('username', 'password', 'status'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'teacher')->find());
                $user->username = date('my', strtotime($this->request->post('dob'))) . Helper_Main::roundString($user->id);
                $user->save();
                $_POST['teacher_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                $_POST['start_year'] = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
                ORM::factory('teacher')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('teacher_id', 'fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'qualification', 'experience', 'name', 'image', 'start_year'))->create();
                $this->request->redirect('teachers/list');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/teachers');
        $this->setTitle('New Teacher')
            ->view('teachers/newTeacher', $data)
            ->render();
    }

    /*
     * Edit teacher
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') {
            return $this->request->redirect('');
        }
        if($this->request->post()){
            $teacher = ORM::factory('teacher')->where('teacher_id', '=', $this->request->param('id'))->find();
            if(!empty($_FILES['image']['name'])){
                $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                @unlink(Kohana::$config->load('config')->get('image_dir') . $teacher->image);
            }
            $teacher->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'qualification', 'experience', 'name', 'image'))->update();
            $data['success'] = 'Teacher successful edit';
        }
        $data['user']     = ORM::factory('user', $this->request->param('id'));
        if(empty($data['user']->id)) $this->request->redirect('');
        $data['user_data'] = Helper_Main::unserializeData(Helper_User::getUserData($data['user'])->as_array());
        Helper_Output::factory()->link_js('user/index')->link_js('user/teachers');
        $this->setTitle('Edit teacher')
                ->view('teachers/edit', $data)
                ->render();
    }
    
    /*
     * Associate with the Subject
     */
    public function action_associate_subject()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') $this->request->redirect('');
        $teacher = ORM::factory('teacher', $this->request->post('teacher'));
        try {
            $teacher->add('subjects', ORM::factory('subject', $this->request->post('subject')));
        }
        catch (Kohana_Database_Exception $e) {
        }
        $this->request->redirect('teachers/list');
    }
    
    /*
     * Delete associate with the Subject
     */
    public function action_delete_subject()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') $this->request->redirect('');
        $teacher = ORM::factory('teacher', $this->request->param('teacher'));
        try {
            $teacher->remove('subjects', ORM::factory('subject', $this->request->param('subject')));
        }
        catch (Kohana_Database_Exception $e) {
        }
        $this->request->redirect('teachers/list');
    }
}