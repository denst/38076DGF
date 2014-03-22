<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_DisciplinaryStudents extends Controller_Core_Records {

    public function before() {
        parent::before();
        $this->set_user_role('student', 'disciplinary');
        $this->set_user_sidebar();
    }
}
  