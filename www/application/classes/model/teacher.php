<?php

class Model_Teacher extends ORM {
    
    private $errors = array();
    
    protected $_table_name  = 'dg_tchrs';
    
    protected $_primary_key = 'teacher_id';
    
    protected $_belongs_to  = array(
            'user'  => array('model' => 'auth_user', 'foreign_key' => 'teacher_id'),        
        );
    
    protected $_has_many = array(
            'subjects' => array('model' => 'subject', 'through' => 'dg_tchrs_sbjcts'),
       	);
    
    public function rules()
    {
        return array(
            'email' => array(
                array('email'),
                array(array($this, 'check_email'), array(':value')),
            ),
        );
    }
    
    public function check_email($email)
    {
        ProfilerToolbar::add_log('email', $email, true);
        $user = ORM::factory('auth_user')->where('email', '=', $email)->find();
        if($user->loaded())
        {
            ProfilerToolbar::add_log('return false');
            return false;
        }
        else 
        {
            ProfilerToolbar::add_log('return true');
            return true;
        }
    }

    public function create_teacher($post, $is_register = false)
    {
        ProfilerToolbar::add_log('post email', $post['email'], true);
        try 
        {
            $post = Arr::map('strip_tags', $post);
            $post['username'] = mt_rand(100, 900) . 'teacher';
            $user = ORM::factory('user')
                ->create_user($post, array('username', 'password', 'email'));
            $user->add('roles', ORM::factory('Role')->where('name', '=', 'teacher')->find());
            $user->username = date('my', time()) . 
                    Helper_Main::roundString($user->id);
            if($is_register)
                Session::instance()->set('login', $user->username);
            else
                $user->status   = 1;
            $user->save();
            $post['teacher_id'] = $user->id;
            $post['start_year'] = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
            $teacher = ORM::factory('teacher')
                ->values(Helper_Main::serializeData(Helper_Main::clean($post)), 
                    array('teacher_id', 'fathername', 'grfathername', 
                        'dob', 'sex', 'home_address', 'lpw', 'job', 
                        'contact_name', 'address', 'telephone', 'emergency', 
                        'languages', 'health', 'qualification', 'experience', 
                        'name', 'image', 'start_year'))
                ->create();
            
            $image = Helper_Folders::set_image($user, $post, 'teachers');
            if($image)
                $teacher->set('image', $image)->update();
            Helper_Folders::clean_user_folders();
            
            return true;
        }
        catch (ORM_Validation_Exception $e) {
            $this->errors = Helper_Main::errors($e->errors('validation'));
            return false;
        }
    }
    
    public function edit_teacher($post)
    {
        try 
        {
            $post = Arr::map('strip_tags', $post);
            $teacher = ORM::factory('teacher')->where('teacher_id', '=', $post['teacher_id'])
                ->find();
            $teacher->values(Helper_Main::serializeData(Helper_Main::clean($post)), 
                array('fathername', 'grfathername', 'dob', 'sex', 
                    'home_address', 'lpw', 'job', 'contact_name', 
                    'address', 'telephone', 'emergency', 'languages', 
                    'health', 'qualification', 'experience', 
                    'name', 'image'))
                ->update();
            $values = array();
            if(Valid::not_empty($post['password']))
            {
                $extra_validation = Model_User::get_password_validation($post);
                $values[] = 'password';
                $teacher->user->values($post, $values)->update($extra_validation);
            }
            $teacher->user->values($post, array('email'))->update();
            $image = Helper_Folders::set_image($teacher->user, $post, 'teachers');
            if($image)
                $teacher->set('image', $image)->update();
            Helper_Folders::clean_user_folders();
            
            return true;
        } 
        catch (ORM_Validation_Exception $e) 
        {
            return false;
        }
    }


    /*
     * Delete teacher 
     */
    public function delete_teacher($user_id)
    {
        return Model::factory('auth_user')->delete_user($user_id);
    }
    
    public function get_all_teachers()
    {
        $all_teachers = ORM::factory('teacher')->find_all();
        return $all_teachers;
    }

    public function get_teachers()
    {
        $teachers = ORM::factory('user')
            ->select('dg_tchrs.name', 'dg_tchrs.fathername', 'dg_tchrs.grfathername',
                    'dg_tchrs.teacher_id', 'dg_tchrs.image',
                    array('dg_lvls.name' , 'level_name'),
                    array('dg_tmpl_clsss.name' , 'class_name')
            )
            ->join('dg_tchrs')
            ->on('user.id', '=', 'dg_tchrs.teacher_id')
            ->join('dg_tmpl_clsss', 'LEFT')->on('dg_tmpl_clsss.teacher_id', '=', 'dg_tchrs.teacher_id')
            ->join('dg_lvls', 'LEFT')->on('dg_lvls.id', '=', 'dg_tmpl_clsss.level_id')
            ->order_by('user.id', 'desc')->find_all();
        return $teachers;
    }
    
    public function get_teachers_slider()
    {
        $teachers = ORM::factory('user')
            ->select('dg_tchrs.name', 'dg_tchrs.fathername', 'dg_tchrs.grfathername',
                    'dg_tchrs.teacher_id', 'dg_tchrs.image',
                    array('dg_lvls.name' , 'level_name'),
                    array('dg_tmpl_clsss.name' , 'class_name'),
                    array('dg_tmpl_clsss.id' , 'class_id')
            )
            ->join('dg_tchrs')
            ->on('user.id', '=', 'dg_tchrs.teacher_id')
            ->join('dg_tmpl_clsss', 'LEFT')->on('dg_tmpl_clsss.teacher_id', '=', 'dg_tchrs.teacher_id')
            ->join('dg_lvls', 'LEFT')->on('dg_lvls.id', '=', 'dg_tmpl_clsss.level_id')
            ->order_by('dg_tchrs.name', 'asc')->find_all();
//        var_dump($teachers);
//        exit('in get teacher slider');
        return $teachers;
    }
    
    /*
     * Get teacher by id
     */
    public function get_teacher_by_id($id)
    {
       if(is_numeric($id))
       {
           $teacher = ORM::factory('teacher', $id);
           if($teacher->loaded())
               return $teacher;
       }
       else
           return false;
    }
    
    public function approve_teacher($user_id)
    {
        $user = ORM::factory('user', $user_id);
        $user->status = 1;
        $user->save();
        return true;
    }

    public function get_errors()
    {
        return $this->errors;
    }
}