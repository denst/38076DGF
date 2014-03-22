<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Student_AcademicRecords extends Controller_Student_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['academicrecords']->set_breadcrumb_parent(
                'profile', $this->request->param('id'));
        $this->objects['academicrecords']->set_breadcrumb_current('Academic Records', 
            $this->request->param('id'));
        $this->objects['academicrecords']->set_breadcrumb();
    }
    
    public function action_list()
    {
        $this->objects['academicrecords']->action_list();
    }
    
    public function action_transcriptdownload()
    {
        $this->objects['academicrecords']->action_transcriptdownload();
    }
    
    public function action_transcriptview()
    {
        $this->objects['academicrecords']->action_transcriptview();
    }
}