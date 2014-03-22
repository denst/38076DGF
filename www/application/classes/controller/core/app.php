    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_App extends Controller_Layout {
    
    public function before()
    {
        parent::before();
        $this->logget_user = Auth::instance()->get_user();
        $this->user_data = Helper_User::getUserData($this->logget_user);
        $this->data['user']= $this->logget_user;
        $this->data['role']= Helper_User::getUserRole($this->logget_user);
        $this->data['id']= $this->logget_user->id;
        $this->set_layout_data(
            array(
                'user' => $this->logget_user,
                'user_info' => $this->user_data,
                'top_menu' => View::factory('layouts/partials/top_menu', $this->data),
                'main_menu' => View::factory('layouts/main_menu/'.$this->data['role'], $this->data)
            )
        );
    }
    
    public function set_sidebar_path($sidebar_path)
    {
        $this->data['sidebar'] = View::factory($sidebar_path, $this->data);
    }
    
    public function unset_sidebar_path()
    {
        if(isset($this->data['sidebar']))
            unset($this->data['sidebar']);
    }
    
    public function set_sidebar_index($index)
    {
        $this->data['sidebar']->set('sidebar_index', $index);
    }
    
    public function set_custom_view($view)
    {
        $this->data['custom_view'] = $view;
    }

    public function set_fullscreen()
    {
        $this->data['fullscreen'] = true;
    }
    
    public function safe_id()
    {
        $this->data['safe_id'] = true;
    }
    
    public function check_approved_users()
    {
        $this->data['approved_students'] = Model::factory('auth_user')
            ->get_approved_users('students');
        $this->data['approved_teachers'] = Model::factory('auth_user')
            ->get_approved_users('teachers');
        $this->data['approved_admins'] = Model::factory('auth_user')
            ->get_approved_users('admins');
        $this->set_layout_data(array('top_menu' => 
            View::factory('layouts/partials/top_menu', $this->data)));
    }
    
    protected function check_safe_id($id)
    {
        if($id != $this->logget_user->id)
            return true;
        else
            return false;
    }
    
    //======================================== Breadcrumb ========================    
    public function set_breadcrumb()
    {
        $this->data['breadcrumb_value']= $this->set_breadcrumb_value();
        $this->data['breadcrumb'] = View::factory('layouts/breadcrumb/index', $this->data);
    }

    public function set_breadcrumb_parent($path, $id = false)
    {
        if($id)
            $this->data['breadcrumb_id'] = $id;
        $this->data['breadcrumb_parents'][] = 
                View::factory('layouts/breadcrumb/'.$this->data['role'].'/'.$path, $this->data);
    }
    
    public function set_breadcrumb_current($name, $id = false)
    {
        if($id)
            $this->data['breadcrumb_id'] = $id; 
        $this->data['breadcrumb_current'] =  $name;
    }

    
    private function set_breadcrumb_value()
    {
        $this->data['breadcrumb_main_menu'] = 
                View::factory('layouts/breadcrumb/'.$this->data['role'].'/main_menu', $this->data);
        $breadcrumb_value = array();
        $breadcrumb_value['controller'] = $this->request->controller();
        $breadcrumb_value['action'] = $this->request->action();
        return $breadcrumb_value;
    }
    
    public function set_settings_breadcrumb($controller, $slider_names)
    {
        if(Valid::not_empty($this->request->param('id')))
            $this->set_breadcrumb_current(Arr::get($slider_names, 
                $this->request->action()), $this->request->param('id'));
        else
            $this->set_breadcrumb_current(
                Arr::get($slider_names, $this->request->action()));
        $this->set_breadcrumb_parent('settings');
        $this->set_breadcrumb();
    }
    
    public function set_records_breadcrumb($controller, $parent_role, $сurrent_name = false)
    {
        $clear_controller = Text::ucfirst(str_replace($parent_role, '', $controller));
        $slider_names = array('list' => $clear_controller.' Records', 
            'create' => 'Create '.$clear_controller.' Record', 
            'edit' => 'Edit '.$clear_controller.' Record');
        if($сurrent_name)
            $this->set_breadcrumb_current($сurrent_name, $this->request->param('id'));
        else 
            $this->set_breadcrumb_current(Arr::get($slider_names, 
                    $this->request->action()), $this->request->param('id'));
        $this->set_breadcrumb_parent($parent_role);
        $this->set_breadcrumb();
    }
    
    public function set_users_breadcrumb($controller)
    {
        $clear_controller = Text::ucfirst($controller);
        $single_clear_controller = Text::ucfirst(Inflector::singular($controller));
        $slider_names = array(
            'slider' => 'Slider '.$clear_controller, 
            'tab' => 'Tab '.$clear_controller, 
            'dropout' => 'Dropout '.$clear_controller, 
            'create' => 'Create '.$single_clear_controller.' Profile', 
            'view' => 'View '.$single_clear_controller.' Profile' , 
            'edit' => 'Edit '.$single_clear_controller.' Profile');
        $this->set_breadcrumb_current(Arr::get($slider_names, 
                $this->request->action()));
        if(Valid::not_empty($this->request->param('id')))
            $this->set_breadcrumb_parent($controller, $this->request->param('id'));
        else
            $this->set_breadcrumb_parent($controller);
        $this->set_breadcrumb();
    }
    //======================================== Breadcrumb ========================    
    
    public function set_financial_debtors()
    {
        $model_debtors_financial = Model::factory('debtors_financial');
        $this->data['financial_debtors_classes'] = $model_debtors_financial
                ->get_debtors_classes($this->data['financial_debtors_classes']);
        $this->data['financial_debtors_count'] = $model_debtors_financial
                ->get_debtors_count();
        $this->data['financial_debtors'] = 
                View::factory('main/sadmin/debtors/financial', $this->data);
    }
    
    public function set_academic_debtors()
    {
        $model_debtors_academic = Model::factory('debtors_academic');
        $this->data['debtors'] = $model_debtors_academic
            ->get_academic_debtors();
        $this->data['academic_debtors_count'] = $model_debtors_academic
                ->get_count_academic_debtors();
        $this->data['academic_debtors'] = 
                View::factory('main/sadmin/debtors/academic', $this->data);
    }
}