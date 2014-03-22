<?php

class Model_Admin extends ORM {
    protected $_table_name  = 'dg_admns';
    protected $_primary_key = 'admin_id';
    
    protected $_belongs_to  = array(
        'user'  => array('model' => 'auth_user', 'foreign_key' => 'teacher_id'),        
    );
    
    public function get_admins()
    {
        $admins = ORM::factory('user')
                ->select('dg_admns.name', 'dg_admns.fathername', 
                        'dg_admns.grfathername')
                ->join('dg_admns')->on('user.id', '=', 'dg_admns.admin_id')
                ->order_by('status')->find_all();
        return $admins;
    }
    
    public function create_admin($post, $is_register = false)
    {
        try 
        {
            $post = Arr::map('strip_tags', $post);
            $post['username'] = mt_rand(100, 900) . 'admin';
            $user = ORM::factory('user')
                ->create_user($post, array('username', 'password', 'email'));
            $user->add('roles', 
                ORM::factory('Role')->where('name', '=', $post['role'])->find());
            $user->username = date('my', strtotime($post['dob'])) . 
                    Helper_Main::roundString($user->id);
            if($is_register)
                Session::instance()->set('login', $user->username);
            else
                $user->status   = 1;
            $user->save();
            if($is_register)
                $post['status']  = 0;
            else
                $post['status']  = 1;
            $post['admin_id'] = $user->id;
            $admin = ORM::factory('admin')
                ->values(Helper_Main::serializeData(Helper_Main::clean($post)),
                array('admin_id', 'fathername', 'grfathername', 
                    'dob', 'sex', 'home_address', 
                    'lpw', 'job', 'contact_name', 
                    'address', 'telephone', 
                    'emergency', 'languages', 
                    'health', 'name', 'image'))
                    ->create();
            
            $image = Helper_Folders::set_image($user, $post, 'admins');
            if($image)
                $admin->set('image', $image)->update();
            Helper_Folders::clean_user_folders();
            
            return true;
        }
        catch (ORM_Validation_Exception $e) 
        {
            $data['errors'] = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function edit_admin($post)
    {
        try
        {
            $post = Arr::map('strip_tags', $post);
            $admin = 
                    ORM::factory('admin')->where('admin_id', '=', $post['admin_id'])->find();
            $admin->values(Helper_Main::serializeData(Helper_Main::clean($post)), 
                array('fathername', 'grfathername', 'dob', 'sex', 
                    'home_address', 'lpw', 'job', 'contact_name', 
                    'address', 'telephone', 'emergency', 'languages', 
                    'health', 'name', 'image'))
                ->update();
            $user = ORM::factory('user', $post['admin_id']);
            $user->remove('roles');
            $user->add('roles', ORM::factory('Role')
                ->where('name', '=', $post['role'])
                ->find());
            $values = array();
            if(Valid::not_empty($post['password']))
            {
                $extra_validation = Model_User::get_password_validation($post);
                $values[] = 'password';
                $user->values($post, $values)->update($extra_validation);
            }
            $user->values($post, array('email'))->update();
            $image = Helper_Folders::set_image($admin->user, $post, 'admins');
            if($image)
                $admin->set('image', $image)->update();
            Helper_Folders::clean_user_folders();
            
            return true;
        }
        catch(ORM_Validation_Exception $e)
        {
            return false;
        }
    }
    
    public function delete_admin($user_id)
    {
        return Model::factory('auth_user')->delete_user($user_id);
    }
    
    public function approve_admin($user_id)
    {
        $user = ORM::factory('user', $user_id);
        $user->status = 1;
        $user->save();
        return true;
    }
}