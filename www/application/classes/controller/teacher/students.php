    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Students extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['students']->set_users_breadcrumb('students');
    }
    
    public function action_slider()
    {
        $this->objects['students']->action_slider();
    }
    
    public function action_tab()
    {
        $this->objects['students']->set_custom_view('students/teacher_students');
        $this->objects['students']->action_tab();
    }
    
    public function action_currentclass()
    {
        $this->objects['students']->set_breadcrumb_current('Current Class');
        $this->objects['students']->set_breadcrumb();
        $this->objects['students']->action_currentclass();
    }
    
    public function action_view()
    {
        $this->objects['students']->action_view();
    }
}