<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_DisciplinaryRecords extends Controller_Sadmin_App {

  /*
     * Show list disciplinary student records
     */
    public function action_list()
    {
        $data['student']  = Model::factory('student')->get_student_by_id($this->request->param('id1'));
        $data['end_year'] = Model::factory('academicyear')->get_end_year();
        $data['year']     = $this->request->param('id2') ? $this->request->param('id2') : $data['end_year'];
        $data['records']  = Model::factory('record_disciplinary')
                ->get_student_disciplinary($data['year'], $data['student']);
        $data['user']     = $this->logget_user;
        $data['table']     = View::factory('disciplinaryrecords/students/table', $data);
        $data['list']     = View::factory('disciplinaryrecords/students/list', $data);
        $data['create']     = View::factory('disciplinaryrecords/students/create_edit', $data);
        $this->setTitle('Achievement Records')
                ->view('disciplinaryrecords/students/index', $data)
                ->render();
    }

    /*
     * Create new disciplinary student record
     */
    public function action_new()
    {
        $data['student'] = ORM::factory('student', $this->request->param('id1'));
        if ($this->request->post()) {
            if(($data['year_id'] = Model::factory('record_disciplinary')
                    ->create_disciplinary($this->request->post(), $data)))
            {
                Helper_Message::add('success', 'Records was ​​addeed successfully');
                $this->request->redirect('sadmin/disciplinaryrecords/list/' . 
                        $data['student']->student_id.'/'.$data['year_id']);
            }
        }
        $this->setTitle('New Records')
            ->view('disciplinaryrecords/students/create_edit', $data)
            ->render();
    }

    /*
     * Edit disciplinary student record
     */
    public function action_edit()
    {
        $data['student']  = Model::factory('student')->get_student_by_id($this->request->param('id2'));
        $data['year']    = $this->request->param('id3');
        $data['record']  = Model::factory('record_disciplinary')
            ->get_student_disciplinary_by_id($this->request->param('id1'));
        if ($this->request->post()) 
        {
            if(($data['year'] = Model::factory('record_disciplinary')
                    ->edit_disciplinary($_POST, $data)))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/disciplinaryrecords/list/'.
                    $data['student']->student_id . '/' . $data['year']);
            }
        }
        $data['user']    = $this->logget_user;
        $data['edit']    = true;
        $this->setTitle('Edit Records')
            ->view('disciplinaryrecords/students/create_edit', $data)
            ->render();
    }
    
    /*
     * Delete disciplinary student record
     */
    public function action_delete()
    {
        $id = $this->request->param('id1');
        if(Valid::numeric($id))
        {
            if(Model::factory('record_disciplinary')->delete_disciplinary($id))
            {
                Helper_Message::add('success', 'Records was ​​deleted successfully');
                $this->request
                ->redirect('sadmin/disciplinaryrecords/list/'.$this->request->param('id2') . '/' . $this->request->param('id3'));
            }
        }
        throw new HTTP_Exception_404;
    }
}