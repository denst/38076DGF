<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_DisciplinaryTeachers extends Controller_Sadmin_Records {

    public function before() {
        parent::before();
        $this->set_user_role('teacher', 'disciplinary');
        $this->set_user_sidebar();
    }
}
  