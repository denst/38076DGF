<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_AchievementTeachers extends Controller_Sadmin_Records {

    public function before() {
        parent::before();
        $this->set_user_role('teacher', 'achievement');
        $this->set_user_sidebar();
    }
}
  