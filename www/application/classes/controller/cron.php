<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cron extends Controller {
    
    public function action_index() 
    {
        ProfilerToolbar::add_log('begin work cron');
        Model::factory('debtors_financial')->check_users();
        Model::factory('debtors_academic')->check_users();
        ProfilerToolbar::add_log('end work cron');
    }
}