<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_AcademicPeriod extends Controller_Sadmin_App {
    
    public function action_index()
    {
        $data['period'] = ORM::factory('setting', 'academic_period');
        if($this->request->post()){
            $data['period']->value = $this->request->post('value');
            $data['period']->save();
            Helper_Message::add('success', 'Period ​​changed successfully');
        }
        $data['sidebar'] = View::factory('levels/sidebar')
            ->set('sidebar_index', 'academic-period');
        $this->setTitle('Academic Period')
            ->set_template_content(array("fullscreen" => false))
            ->view('main/academicPeriod', $data)
            ->render();
    }
}