<?php
class Helper_User
{
    public static function loginUser($username, $password)
    {
        $user = ORM::factory('user')->where('username', '=', $username)->where('password', '=', Auth::instance()->hash_password($password))->find();
        if(empty($user->status) || (!empty($user->status) && $user->status == 0)) {
            return FALSE;
        }
        return Auth::instance()->force_login($username);
    }
    
    public static function getUserData($user)
    {
        $role = self::getUserRole($user);
        $id = $user->id;
        switch ($role):
            case 'sadmin':
                $table = array('dg_admns', 'sadmin');
                $on = 'sadmin.admin_id';
                break;
            case 'admin':
                $table = array('dg_admns', 'admin');
                $on = 'admin.admin_id';
                break;
            case 'teacher':
                $table = array('dg_tchrs', 'teacher');
                $on = 'teacher.teacher_id';
                break;
            case 'student':
                $table = array('dg_stdnts', 'student');
                $on = 'student.student_id';
                break;
        endswitch;
        $query = DB::select($role.'.*','users.email')
           ->from($table)
           ->join(array('dg_usrs', 'users'))->on('users.id', '=', $on)
           ->where($on, '=', $id)
           ->limit(1)
           ->execute()
           ->as_array();
        return $query[0];
    }
    
    public static function getUserRole($user)
    {
        return $user->roles->order_by('role_id', 'desc')->find()->name;
    }
    
    public static function get_db_user_role($id)
    {
        $query = DB::select(array('role.name', 'name'))
            ->from(array('dg_rls', 'role'))
            ->join('dg_rls_usrs')->on('dg_rls_usrs.role_id', '=', 'role.id')
            ->where('dg_rls_usrs.user_id', '=', $id)
                ->limit(1)
            ->execute()
            ->as_array();
        return $query[0]['name'];
    }

    public static function deleteUsersFromClass($class)
    {
        $students = $class->students->find_all();
        if(count($students) > 0){
            foreach ($students as $student){
                $student->class_id = NULL;
                $student->save();
            }
        }
    }

    public static function autoAssignedClass($students_m, $students_w, $classes)
    {
        $students = array();
        if(count($students_m) > count($students_w)){
            foreach ($students_m as $key => $value) {
                $students[] = $value;
                if(!empty($students_w[$key])) $students[] = $students_w[$key];
            }
        }else{
            foreach ($students_w as $key => $value) {
                $students[] = $value;
                if(!empty($students_m[$key])) $students[] = $students_m[$key];
            }            
        }
        $i = 0;
        foreach ($students as $student){
            if(empty($classes[$i])) $i = 0;
            $student->class_id = $classes[$i]->id;
            $student->save();
            $i++;
        }
        return $students;
    }
    
    public static function get_user_age($date)
    {
        $result;
        $date_parse = date_parse($date);

        $day = date('j'); 
        $month = date('n'); 
        $year = date('Y'); 

        if(($month > $date_parse['month']) || 
                ($month == $date_parse['month'] && $day >= $date_parse['day'])) { 
            return ($year - $date_parse['year']); 
        } else { 
            return ($year - $date_parse['year'] - 1); 
        } 
    }
    
    public static function is_can_modify_subject_result($user, $subjects, $student,
            $subject, $current_class)
    {
        $role = Helper_User::getUserRole($user);
        if($role == 'sadmin')
            return true;
        if($role == 'admin')
            return true;
        if($role == 'teacher')
        {
            if(! is_null($current_class)  AND 
                    $user->id == Model::factory('class_template')
                    ->get_class_by_id($current_class)->teacher_id)
            {
                return true;
            }
        }
        if($role == 'teacher')
        {
            if(Valid::not_empty($subjects) AND 
                ($user->teachers->find()->teacher_id == 
                    Model::factory('class_subject')
                        ->get_subjects_by_subject_name_class_id($student, $subject)
                    ->teacher_id))
            {
                return true;
            }
        }
        return false;
    }
}