<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_DisciplinaryTeacherRecords extends Controller_Sadmin_App {

    /*
     * Show list Disciplinary teacher records
     */
    public function action_list()
    {
        $data['teacher']  = Model::factory('teacher')->get_teacher_by_id($this->request->param('id1'));
        $data['end_year'] = Model::factory('academicyear')->get_end_year();
        $data['year']     = $this->request->param('id2') ? $this->request->param('id2') : $data['end_year'];
        $data['records']  = Model::factory('record_teacher_disciplinary')
                ->get_teacher_disciplinary($data['year'], $data['teacher']);
        $data['user']     = $this->logget_user;
        $data['admin']     = true;
        $data['table']     = View::factory('disciplinaryrecords/teachers/table', $data);
        $data['list']     = View::factory('disciplinaryrecords/teachers/list', $data);
        $data['create']     = View::factory('disciplinaryrecords/teachers/create_edit', $data);
        $this->setTitle('Disciplinary Records')
                ->view('disciplinaryrecords/teachers/index', $data)
                ->render();
    }
    
    /*
     * Create new Disciplinaryt teacher record
     */
    public function action_new()
    {
        $data['teacher'] = ORM::factory('teacher', $this->request->param('id1'));
        if ($this->request->post()) {
            if(($data['year_id'] = Model::factory('record_teacher_disciplinary')
                    ->create_disciplinary($this->request->post(), $data)))
            {
                Helper_Message::add('success', 'Records was ​​addeed successfully');
                $this->request->redirect('sadmin/disciplinaryteacherrecords/list/' . 
                        $data['teacher']->teacher_id.'/'.$data['year_id']);
            }
                
        }
        $this->setTitle('New Records')
            ->view('disciplinaryrecords/teachers/new', $data)
            ->render();
    }

    /*
     * Edit Disciplinary teacher record
     */
    public function action_edit()
    {
        $data['teacher']  = Model::factory('teacher')->get_teacher_by_id($this->request->param('id2'));
        $data['year']    = $this->request->param('id3');
        $data['record']  = Model::factory('record_teacher_disciplinary')
            ->get_teacher_disciplinary_by_id($this->request->param('id1'));
        if ($this->request->post()) 
        {
            if(Model::factory('record_teacher_disciplinary')
                    ->edit_disciplinary($_POST, $data))
            {
                Helper_Message::add('success', 'Values ​​changed successfully');
                $this->request->redirect('sadmin/disciplinaryteacherrecords/list/'.
                    $data['teacher']->teacher_id . '/' . $data['year']);
            }
        }
        $data['user']    = $this->logget_user;
        $data['edit']    = true;
        $this->setTitle('Edit Records')
            ->view('disciplinaryrecords/teachers/create_edit', $data)
            ->render();
    }
    
    /*
     * Delete Disciplinary teacher record
     */
    public function action_delete()
    {
        $id = $this->request->param('id1');
        if(Valid::numeric($id))
        {
            if(Model::factory('record_teacher_disciplinary')->delete_disciplinary($id))
            {
                Helper_Message::add('success', 'Records was ​​deleted successfully');
                $this->request
                    ->redirect('sadmin/disciplinaryteacherrecords/list/'.$this->request->param('id2') . '/' . $this->request->param('id3'));
            }
        }
        throw new HTTP_Exception_404;
    }
}