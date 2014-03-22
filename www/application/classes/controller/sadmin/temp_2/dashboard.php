<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Dashboard extends Controller_Sadmin_App {

    /*
     * Main page
     */
    public function action_index()
    {
        Helper_Output::factory()
                ->link_js('js/laguadmin/dashboard');
        $this->setTitle('Dashboard')
                ->set_template_content(array("fullscreen" => true))
                ->view('main/index')
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
        $data = array();
        if($this->request->post()){
            try {
                $user = ORM::factory('user', $this->logget_user->id)->update_user($this->request->post(), array('password', 'change_password'));
                $this->request->redirect('');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $this->setTitle('Change password')
                ->view('main/changePassword', $data)
                ->render();
    }
    
        
    /*
     * Academic Period
     */
    public function action_academic_period()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $data['period'] = ORM::factory('setting', 'academic_period');
        if($this->request->post()){
            $data['period']->value = $this->request->post('value');
            $data['period']->save();
        }
           $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'grade_levels')
                ->render();
        Helper_Output::factory()
            ->link_css('laguadmin/lib/datatables/css/table_jui')
            ->link_js('js/level/index')
            ->link_js('js/class/templates')
            ->link_js('js/laguadmin/students');
        $this->setTitle('Academic Period')
                ->set_template_content(array("fullscreen" => false))
                ->view('main/academicPeriod', $data)
                ->render();
    }
}