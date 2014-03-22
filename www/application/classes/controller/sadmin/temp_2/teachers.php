<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Teachers extends Controller_Sadmin_Users {
    
    public function before()
    {
        parent::before();
        $this->set_user_role('teacher');
        $this->set_user_sidebar();
        $this->data['teachers'] = Model::factory('teacher')->get_teachers();
        $this->data['all_subjects'] = Model::factory('subject')
            ->get_all_subjects_order_by_pid();
    }
    
    public function action_tab() 
    {
        Helper_Output::factory()
            ->link_css('laguadmin/lib/harvesthq-chosen/chosen')
            ->link_js('js/laguadmin/teachers');    
        parent::action_tab();
    }
    
    public function action_create() 
    {
        Helper_Output::factory()
            ->link_js('/js/user/teachers')
            ->link_js('/js/ajaximage/ajaximage');
        parent::action_create();
    }
    
    /*
     * Associate with the Subject
     */
    public function action_associatesubject()
    {
        if($_POST)
        {
            if(Model::factory('subject')->associate_subjects($_POST))
            {
                Helper_Message::add('success', 'New subjects associated with teacher');
                $this->request->redirect('sadmin/teachers/tab');
            }
        }
        else
            throw new HTTP_Exception_404;
    }
}