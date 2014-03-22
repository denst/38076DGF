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
        switch (self::getUserRole($user)):
            case 'sadmin':
                $data = $user->admins->find();
                break;
            case 'admin':
                $data = $user->admins->find();
                break;
            case 'teacher':
                $data = $user->teachers->find();
                break;
            case 'student':
                $data = $user->students->find();
                break;
        endswitch;

        return $data;
    }
    
    public static function getUserRole($user)
    {
        return $user->roles->order_by('role_id', 'desc')->find()->name;
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
}