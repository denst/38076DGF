<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_AcademicRecords extends Controller_Admin_App {
        
    public function before() 
    {
        parent::before();
        $this->objects['academicrecords']->set_records_breadcrumb('academicrecords', 'students', 
                'Academic Records');
    }

    public function action_list()
    {
        $this->objects['academicrecords']->action_list();
    }

    /*
     * Create new Academic student record
     */
    public function action_create()
    {
        $this->objects['academicrecords']->action_create();
    }
    
    /*
     * Delete Academic student record
     */
    public function action_delete()
    {
        $this->objects['academicrecords']->action_delete();
    }
    
    public function action_changetotal()
    {
        $this->objects['academicrecords']->action_changetotal();
    }
    
    public function action_pdfdownload()
    {
        $this->objects['academicrecords']->action_pdfdownload();
    }
    
    public function action_pdfview()
    {
        $this->objects['academicrecords']->action_pdfview();
    }
}