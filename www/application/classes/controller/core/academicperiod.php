    <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_AcademicPeriod extends Controller_Core_App {
    
    public function action_index()
    {
        $this->data['period'] = ORM::factory('setting', 'academic_period');
        if(Valid::not_empty($_POST))
        {
            Model::factory('period_dates')->set_pariod_dates($_POST);
            $this->data['period']->value = $this->request->post('period');
            $this->data['period']->save();
            Helper_Message::add('success', 'Period ​​changed successfully');
        }
        $this->data['periods'] = Model::factory('period_academics')->get_periods();
        $this->data['period_dates'] = Model::factory('period_dates')
                ->get_period_dates($this->data);
        $this->data['sidebar'] = View::factory('levels/sidebar')
            ->set('sidebar_index', 'academic-period');
        $this->data['periods'] = View::factory('main/periods', $this->data);
        $this->setTitle('Academic Period')
            ->set_template_content(array("fullscreen" => false))
            ->view('main/academicPeriod', $this->data)
            ->render();
    }
}