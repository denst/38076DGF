<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_DisciplinaryRecords extends Controller_Student_Records {

    public function before() {
        parent::before();
        $this->set_user_role('student', 'disciplinary');
        $this->set_user_sidebar();
    }
}
  