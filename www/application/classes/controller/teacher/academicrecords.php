<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Teacher_AcademicRecords extends Controller_Teacher_App {
    
    public function before() 
    {
        parent::before();
        $this->objects['academicrecords']->set_breadcrumb_parent(
                'students');
        $this->objects['academicrecords']->set_breadcrumb_current('Academic Records', $this->request->param('id'));
        $this->objects['academicrecords']->set_breadcrumb();
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
        $this->objects['academicrecords']->set_breadcrumb_parent('academic', $this->request->param('id'));
        $this->objects['academicrecords']->set_breadcrumb_current('Create Academic Records',
                $this->request->param('id'));
        $this->objects['academicrecords']->set_breadcrumb();
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
    
    public function action_transcriptdownload()
    {
        $this->objects['academicrecords']->action_transcriptdownload();
    }
    
    public function action_transcriptview()
    {
        $this->objects['academicrecords']->action_transcriptview();
    }
}