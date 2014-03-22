<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Levels extends My_LoggedUserController {

    /*
     * Show list grade levels
     */
    public function action_list()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student' || Helper_User::getUserRole($this->logget_user) == 'teacher') return $this->request->redirect('');
        $years          = Model_Level::get_min_max_student_year();
        $data['years']  = $years[0];
        $data['year']   = $this->request->param('year') ? $this->request->param('year') : (!empty($data['years']->min_year) ? $data['years']->min_year : ORM::factory('academicyear')->where('name', '=', Helper_Main::getCurrentYear())->find()->id);
        $data['levels'] = ORM::factory('level')->order_by('order')->find_all();
        $data['user']   = $this->logget_user;
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'grade_levels')
                ->render();
        $data['create_level'] = View::factory('levels/create')
                ->set('year', $data['year'])
                ->render();
        $data['grade_levels'] = View::factory('levels/levels')
                ->set('levels', $data['levels'])
                ->set('year', $data['year'])
                ->set('user', $data['user'])
                ->set('years', $data['years'])
                ->render();
//        $data['sidebar_index'] = 'grade_levels';
        Helper_Output::factory()
//                ->link_css('bootstrap')
                ->link_css('laguadmin/lib/datatables/css/table_jui')
                ->link_js('js/level/index')
                ->link_js('js/class/templates')
                ->link_js('js/laguadmin/students');
        $this->setTitle('Grade Levels')
                ->set_template_content(array("fullscreen" => false))
                ->view('levels/index', $data)
                ->render();
    }
    
    /*
     * Create new level
     */
    public function action_new()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $data = array();
        if ($this->request->post()) {
            try {
                $_POST['order'] = ORM::factory('level')->count_all() + 1;
                $level = ORM::factory('level')->values($_POST, array('name', 'order'))->create();
                if($this->request->post('classes')){
                    foreach ($this->request->post('classes') as $value) {
                        $class           = ORM::factory('class_template');
                        $class->name     = $value;
                        $class->level_id = $level->id;
                        $class->save();
                    }
                }
                $this->request->redirect('levels/list');
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['year']  = $this->request->param('year');
        Helper_Output::factory()->link_js('class/templates');
        $this->setTitle('New Level')
            ->view('levels/newLevel', $data)
            ->render();
    }

    /*
     * Edit level
     */
    public function action_edit()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'teacher' || Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['year']  = $this->request->param('year');
        if ($this->request->post()) {
            try {
                $level = ORM::factory('level', $this->request->param('id'));
                if(Helper_User::getUserRole($this->logget_user) == 'sadmin'){
                    $levels = ORM::factory('level')->where('id', '!=', $level->id)->find_all();
                    if(count($levels) > 0){
                        foreach($levels as $lvl){
                            if($this->request->post('order') >= $lvl->order && $level->order < $lvl->order){
                                $lvl->order = $lvl->order + 1;
                                $lvl->save();
                            }
                        }
                    }
                    $level->values($this->request->post(), array('name', 'order', 'annual', 'early_repayment'))->update();
                }
                if($this->request->post('classes')){
                    foreach ($this->request->post('classes') as $value){
                        $class           = ORM::factory('class_template');
                        $class->name     = $value;
                        $class->level_id = $level->id;
                        $class->year_id  = $data['year'];
                        try{
                            $class->save();
                        }
                        catch (Kohana_Database_Exception $e){}
                    }
                }
                if($this->request->post('old_classes')){
                    foreach ($this->request->post('old_classes') as $key => $value) {
                        $class  = ORM::factory('class_template', $key);
                        $class->name = $value;
                        $class->save();
                    }
                }
                if($this->request->post('delete_classes')){
                    foreach ($this->request->post('delete_classes') as $key => $value) {
                        $class  = ORM::factory('class_template', $key);
                        Helper_User::deleteUsersFromClass($class);
                        $class->delete();
                    }
                }
                $data['success'] = 'Level successful edit';
            }
            catch (ORM_Validation_Exception $e) {
                $data['errors'] = Helper_Main::errors($e->errors('validation'));
            }
        }
        $data['user']  = $this->logget_user;
        $data['level'] = ORM::factory('level', $this->request->param('id'));
        if(empty($data['level']->id)) $this->request->redirect('');
        $data['classes'] = $data['level']->template_classes->where('year_id', '=', $data['year'])->order_by('name')->find_all();
        $data['top_menu'] = View::factory('layouts/partials/top_menu')->render();
        $data['main_menu'] = View::factory('layouts/partials/sadmin_main_menu')->render();
        $data['sidebar'] = View::factory('levels/sidebar')
                ->set('sidebar_index', 'levels')
                ->render();
        Helper_Output::factory()
                ->link_js('js/class/templates')
                ->link_js('js/laguadmin/students');
        $this->setTitle('Edit Level')
            ->set_template_content(array("fullscreen" => false))
            ->view('levels/edit', $data)
            ->render();
    }
   
    /*
     * Unassigned students
     */
    public function action_unassigned_students()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'teacher' || Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['level']     = ORM::factory('level', $this->request->param('id'));
        $data['all_class'] = $data['level']->template_classes->where('year_id', '=', $this->request->param('year'))->find_all();
        $data['students']  = $data['level']->students->where('end_year', '=', $this->request->param('year'))->where('class_id', '=', NULL)->find_all();
        $data['year']      = $this->request->param('year');
        Helper_Output::factory()->link_js('user/index');
        $this->setTitle('Unassigned students')
            ->view('levels/unassignedStudents', $data)
            ->render();
    }
   
    /*
     * Unassigned students
     */
    public function action_auto_assigned()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'teacher' || Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $data['level']   = ORM::factory('level', $this->request->param('id'));
        $students_ids    = explode(',', $this->request->post('students'));
        $students_mens   = ORM::factory('student')->where('sex', '=', '0')->where('student_id', 'IN', $students_ids)->find_all();
        $students_womens = ORM::factory('student')->where('sex', '=', '1')->where('student_id', 'IN', $students_ids)->find_all();
        $classes         = $data['level']->template_classes->where('year_id', '=', $this->request->param('year'))->find_all()->as_array();
        Helper_User::autoAssignedClass($students_mens, $students_womens, $classes);
        $this->request->redirect('levels/list');
    }    

    public function action_promoting_detaining()
    {
        if(Helper_User::getUserRole($this->logget_user) == 'student') return $this->request->redirect('');
        $student = ORM::factory('student')->where('student_id', '=', $this->request->param('student'))->find();
        if(Helper_User::getUserRole($this->logget_user) == 'teacher' && $this->logget_user->id != $student->class->teacher_id) return $this->request->redirect('');
        $student->class_id = NULL;
        if($this->request->param('type') == 'prom'){
            if(!Helper_Main::getStatusForPromotion($student->student_id)) return $this->request->redirect('');
            $old_level = ORM::factory('level', $student->academic_year);
            $levels = ORM::factory('level')->order_by('order')->find_all();
            $new_level = NULL;
            foreach($levels as $key => $level){
                if($level->order == $old_level->order) {
                    $lvl   = $levels[$key+1];
                    $new_level = $lvl->id;
                    break;
                }
            }
            $student->academic_year = $new_level;
        }
        $student->end_year = $student->end_year + 1;
        $student->save();
        $this->request->redirect($this->request->referrer());
    }


    /*
     * Delete level
     */
    public function action_delete()
    {
        if(Helper_User::getUserRole($this->logget_user) != 'sadmin') return $this->request->redirect('');
        $level   = ORM::factory('level', $this->request->param('id'));
        $classes = $level->template_classes->find_all();
        if(count($classes) > 0){
            foreach ($classes as $class){
                Helper_User::deleteUsersFromClass($class);
            }
        }
        if($level->id){
            $level->delete();
        }
        $this->request->redirect('levels/list');
    }
    
}