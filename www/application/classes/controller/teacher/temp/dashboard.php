<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_Dashboard extends Controller_Teacher_App {

    /*
     * Main page
     */
    public function action_index()
    {
        Helper_Output::factory()
                ->link_js('js/laguadmin/dashboard');
        $this->setTitle('Main')
                ->view('teachers/dashboard')
                ->render();
    }
}