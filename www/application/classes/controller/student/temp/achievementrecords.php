<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_AchievementRecords extends Controller_Student_Records {

    public function before() {
        parent::before();
        $this->set_user_role('student', 'achievement');
        $this->set_user_sidebar();
    }
}
  