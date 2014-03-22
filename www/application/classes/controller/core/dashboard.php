<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Dashboard extends Controller_Core_App {

    /*
     * Main page
     */
    public function action_index()
    {
        $this->data['count_students'] = Model::factory('auth_user')
                ->get_count_users('students');
        $this->data['count_teachers'] = Model::factory('auth_user')
                ->get_count_users('teachers');
        $this->data['count_admins'] = Model::factory('auth_user')
                ->get_count_users('admins'); 
        Helper_Output::factory()
                ->link_js('js/laguadmin/dashboard');
        $this->setTitle('Dashboard')
                ->set_template_content(array("fullscreen" => true))
                ->view('main/'.$this->data['role'].'/index', $this->data)
                ->render();
    }
    
    /*
     * Approve admin, teacher, student
     */
    public function action_approve()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $user = ORM::factory('user', $this->request->param('id'));
        $user->status = 1;
        $user->save();
        if($user->roles->find()->name == 'student'){
            $student = $user->students->find();
            $year = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
            $student->start_year = $student->end_year = $year;
            $student->save();
        }
        return $this->request->redirect($this->request->param('type') .'s/list');
    }
    
    /*
     * Change password for user
     */
    public function action_change_password()
    {
        if($this->request->post()){
            try {
                $user = ORM::factory('user', $this->logget_user->id)->update_user($this->request->post(), array('password', 'change_password'));
                $this->request->redirect('');
            }
            catch (ORM_Validation_Exception $e) {
                $this->data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $this->setTitle('Change password')
                ->view('main/changePassword', $this->data)
                ->render();
    }
    
        
    /*
     * Academic Period
     */
    public function action_academic_period()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $this->data['period'] = ORM::factory('setting', 'academic_period');
        if($this->request->post()){
            $this->data['period']->value = $this->request->post('value');
            $this->data['period']->save();
        }
           $this->data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $this->data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $this->data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'grade_levels')
                ->render();
        $this->setTitle('Academic Period')
                ->set_template_content(array("fullscreen" => false))
                ->view('main/academicPeriod', $this->data)
                ->render();
    }
}