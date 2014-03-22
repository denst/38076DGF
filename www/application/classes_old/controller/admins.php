<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admins extends My_LoggedUserController {

    /*
     * Show all admins and super admins 
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $data['admins'] = ORM::factory('user')->select('dg_admns.name', 'dg_admns.fathername', 'dg_admns.grfathername')->join('dg_admns')->on('user.id', '=', 'dg_admns.admin_id')->order_by('status')->find_all();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        Helper_Output::factory()
//                ->link_css('bootstrap');
                ->link_js('js/laguadmin/students');
        $this->setTitle('Admins')
                ->view('admins/list', $data)
                ->render();
    }

    /*
     * Create new admin or super admin
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['username'] = mt_rand(100, 900) . 'admin';
                $user = ORM::factory('user')->create_user($_POST, array('username', 'password', 'status'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', $this->request->post('role'))->find());
                $user->username = date('my', strtotime($this->request->post('dob'))) . Helper_Main::roundString($user->id);
                $user->save();
                $_POST['admin_id'] = $user->id;
                if(!empty($_FILES['image']['name'])){
                    $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                }
                ORM::factory('admin')->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('admin_id', 'fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'name', 'image'))->create();
                $this->request->redirect('admins/list');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        Helper_Output::factory()->link_js('user/index')->link_js('user/admins');
        $this->setTitle('New Admin')
            ->view('admins/newAdmin', $data)
            ->render();
    }

    /*
     * Edit admin or super admin
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        if($this->request->post()){
            $admin = ORM::factory('admin')->where('admin_id', '=', $this->request->param('id'))->find();
            if(!empty($_FILES['image']['name'])){
                $_POST['image'] = Helper_Image::resize($_FILES['image'], '420', '320');
                @unlink(Kohana::$config->load('config')->get('image_dir') . $admin->image);
            }
            $admin->values(Helper_Main::serializeData(Helper_Main::clean($_POST)), array('fathername', 'grfathername', 'dob', 'sex', 'home_address', 'lpw', 'job', 'contact_name', 'address', 'telephone', 'emergency', 'languages', 'health', 'name', 'image'))->update();
            $user = ORM::factory('user', $this->request->param('id'));
            $user->remove('roles');
            $user->add('roles', ORM::factory('Role')->where('name', '=', $this->request->post('role'))->find());
            $data['success'] = 'Admin successful edit';
        }
        $data['user']      = ORM::factory('user', $this->request->param('id'));
        if(empty($data['user']->id)) $this->request->redirect('');
        $data['role']      = Helper_User::getUserRole($data['user']);
        $data['user_data'] = Helper_Main::unserializeData(Helper_User::getUserData($data['user'])->as_array());
        Helper_Output::factory()->link_js('user/index')->link_js('user/admins');
        $this->setTitle('Edit admin')
                ->view('admins/edit', $data)
                ->render();
    }
}