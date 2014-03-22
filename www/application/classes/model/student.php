<?php

class Model_Student extends ORM {
    
    private $errors = array();
    
    protected $_table_name  = 'dg_stdnts';
    protected $_primary_key = 'student_id';
    protected $_belongs_to  = array(
        'class' => array('model' => 'class_template', 'foreign_key' => 'class_id'),
        'level' => array('model' => 'level', 'foreign_key' => 'academic_year'),
        'user'  => array('model' => 'auth_user', 'foreign_key' => 'student_id')
        );
    
    /*
     * Create new student 
     */
    public function create_student($post, $is_register = false)
    {
        if(isset($post['dropout_student']) OR $this->check_is_dropout_student($post))
        {
            try 
            {
                $post = Arr::map('strip_tags', $post);
                $post['username']         = mt_rand(100, 900) . 'user';
                $post['change_password']  = 1;
                if($is_register)
                {
                    $password  = str_replace('/', '', $post['dob']['gc']);
                    $post['password']         = $password;
                    $post['password_confirm'] = $password;
                }
                $user = ORM::factory('user')->create_user($post, array('username', 'password', 'change_password', 'email'));
                $user->add('roles', ORM::factory('Role')->where('name', '=', 'student')->find());
                $user->username = Helper_Main::academicYear($post['academic_year']) . date('y') . Helper_Main::roundString($user->id);
                if($is_register)
                    Session::instance()->set('login', $user->username);
                else
                    $user->status   = 1;
                $user->save();
                $post['student_id'] = $user->id;

                $year = ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id;
                $post['start_year'] = $post['end_year'] = $year;
                $student = ORM::factory('student')->values(Helper_Main::serializeData(Helper_Main::clean($post)), 
                  array('student_id', 'academic_year', 'dob', 'sex', 'address', 
                      'father', 'mother', 'guardian', 'tels_em', 'languages', 
                      'health', 'siblings', 'name', 'fathername', 'grfathername', 
                      'image', 'start_year', 'end_year'))
                        ->create();

                $image = Helper_Folders::set_image($user, $post, 'students');
                if($image)
                    $student->set('image', $image)->update();
                Helper_Folders::clean_user_folders();

                return true;
            }
            catch (ORM_Validation_Exception $e) 
            {
                $this->errors = Helper_Main::errors($e->errors('validation'));
                return false;
            }
        }
        else
        {
            $message = 'This student dropped learning, please contact the administrator';
            if($is_register)
            {
                Session::instance()->set('dropout_student', $message);
                return true;
            }
            else
            {
                $this->errors[] = 'dropout_student';
                return false;
            }
        }
    }
    
    /*
     * edit student 
     */
    public function edit_student($post)
    {
        try
        {
            $post = Arr::map('strip_tags', $post);
            $student = ORM::factory('student')->where('student_id', '=', $post['student_id'])->find();
            $student
                    ->values(Helper_Main::serializeData(Helper_Main::clean($post)), 
                            array('academic_year', 'dob', 'sex', 'address', 
                                'father', 'mother', 'quardian', 'tels_em', 
                                'languages', 'health', 'siblings', 'name', 
                                'fathername', 'grfathername', 'image'))
                    ->update();
            $values = array();
            if(Valid::not_empty($post['password']))
            {
                $extra_validation = Model_User::get_password_validation($post);
                $values[] = 'password';
                $student->user->values($post, $values)->update($extra_validation);
            }
//            if(Valid::not_empty($extra_validation))
//                Model_User::get_email_validation($post, $extra_validation);
//            else
//                $extra_validation = Model_User::get_email_validation($post);
//            $values[] = 'email';
            $student->user->values($post, array('email'))->update();
            $image = Helper_Folders::set_image($student->user, $post, 'students');
            if($image)
                $student->set('image', $image)->update();
            Helper_Folders::clean_user_folders();
            
            return true;
        }
        catch (ORM_Validation_Exception $e)
        {
            $errors = $e->errors('validation');
            return false;
        }
    }

    /*
     * Delete student 
     */
    public function delete_student($user_id)
    {
        return Model::factory('auth_user')->delete_user($user_id);
    }

    /*
     * Get all students 
     */
    public function get_students($dropout = false)
    {
        if($dropout)
            $dropout = 1;
        else
            $dropout = 0;
        $students = ORM::factory('user')
            ->select('dg_stdnts.name', 'fathername', 'grfathername', 'class_id',
                    'image', 'student_id', 'end_year', 'academic_year',
                    array('dg_lvls.name', 'level_name'),
                    array('dg_tmpl_clsss.name', 'class_name'))
            ->join('dg_stdnts')
            ->on('user.id', '=', 'dg_stdnts.student_id')
            ->join('dg_lvls')
            ->on('dg_stdnts.academic_year', '=', 'dg_lvls.id')
            ->join('dg_tmpl_clsss', 'LEFT')->on('dg_stdnts.class_id', '=', 'dg_tmpl_clsss.id')
                ->where('dg_stdnts.dropout', '=', $dropout)
                ->order_by('user.id', 'desc')
                ->find_all();
        return $students;
    }
    
    public function get_approved_students()
    {
        $students = ORM::factory('user')
                ->select('dg_stdnts.name', 'fathername', 'grfathername', 'class_id',
                        'image', 'student_id', 
                        array('dg_lvls.name', 'level_name'),
                        array('dg_tmpl_clsss.name', 'class_name'))
                ->join('dg_stdnts')
                ->on('user.id', '=', 'dg_stdnts.student_id')
                ->join('dg_lvls')
                ->on('dg_stdnts.academic_year', '=', 'dg_lvls.id')
                ->join('dg_tmpl_clsss', 'LEFT')->on('dg_stdnts.class_id', '=', 'dg_tmpl_clsss.id')
                ->where('user.status', '=', 1)
                ->order_by('dg_lvls.id', 'asc')->find_all();
        return $students;
    }
    
    /*
     * Get student by id
     */
    public function get_student_by_id($id)
    {
        if(is_numeric($id))
        {
            $student =  ORM::factory('student', $id);
            if($student->loaded())
                return $student;
        }
        else
            return false;
    }
    
    public function approve_student($user_id)
    {
        $user = ORM::factory('user', $user_id);
        $user->status = 1;
        $user->save();
        $student = $user->students->find();
        $year = ORM::factory('academicyear')->where('name', '=', 
            Helper_Main::getCurrentYear())->find()->id;
        $student->start_year = $student->end_year = $year;
        $student->save();
        return true;
    }
    
    public function promoting_detaining($student, $type)
    {
        $student->class_id = NULL;
        if($type == 'prom')
        {
            if(!Helper_Main::getStatusForPromotion($student->student_id)) 
                return false;
            $old_level = ORM::factory('level', $student->academic_year);
            $levels = ORM::factory('level')->order_by('order')->find_all();
            $new_level = NULL;
            foreach($levels as $key => $level){
                if($level->order == $old_level->order) {
                    $lvl   = $levels[$key+1];
                    $new_level = $lvl->id;
                    break;
                }
            }
            $student->academic_year = $new_level;
        }
        $student->end_year = $student->end_year + 1;
        $student->save();
        return true;
    }
    
    public function get_students_of_class($class)
    {
        if(is_object($class))
            $class_id = $class->id;
        else
            $class_id = $class;
        return ORM::factory('student')
                ->where('class_id', '=', $class_id)->find_all();
    }
    
    public function set_dropout_student($post)
    {
        $student = ORM::factory('student')
            ->where('student_id', '=', $post['student_id'])
            ->find();
        if($student->loaded())
        {
            if(isset($post['dropout']))
                $student->dropout = 1;
            else
                $student->dropout = 0;
            $student->update();
            return true;
        }
        else
            return false;
    }
    
    public function check_is_dropout_student($data)
    {
        $student = ORM::factory('student')
                ->where('name', '=', $data['name'])
                ->where('fathername', '=', $data['fathername'])
                ->where('grfathername', '=', $data['grfathername'])
                ->find();
        if($student->loaded())
            return false;
        else
            return true;
    }
    
    public function get_errors()
    {
        return $this->errors;
    }
}