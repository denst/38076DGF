    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Students extends Controller_Core_Users {
    
    public function set_object($layout_data)
    {
        $this->set_layout_data = $layout_data; 
    }
    
    public function before()
    {
        parent::before();
        $this->set_user_role('student');
        $this->set_user_sidebar();
        if($this->request->action() == 'dropout')
            $this->data['students'] = Model::factory('student')->get_students(true);
        else
            $this->data['students'] = Model::factory('student')->get_students();
        $this->data['levels']   = Model::factory('level')->get_levels();
    }
    
    public function action_dropout() 
    {
        $this->data['students'] = Model::factory('student')->get_students(true);
        parent::action_dropout();
    }
    
    public function action_create() 
    {
        parent::action_create();
    }
    
    public function action_edit() 
    {
        parent::action_edit();
    }
}