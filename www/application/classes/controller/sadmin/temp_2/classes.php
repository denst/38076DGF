<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sadmin_Classes extends Controller_Sadmin_App {
    
private $data  = array();
    
    public function before()
    {
        parent::before();
        Helper_Output::factory()
            ->link_js('js/laguadmin/settings');
        $this->data['user']   = $this->logget_user;
    }

    public function action_view()
    {
        if(($data = $this->check_class($this->request->param('id'))))
        {
            $data['level'] = Model::factory('level')
                ->get_level_by_id($data['class']->level_id);
            $data['subjects'] = Model::factory('class_subject')
                ->get_subjects_by_class_id($data['class']->id);
            $data['students'] = $data['class']->students->find_all();
            $data['all_subject'] = Model::factory('subject')->get_all_subjects();
            $data['all_class'] = Model::factory('class_template')
                ->get_all_classes($data['level']->template_classes, $data['class']->year_id);
            $data['all_teachers'] = Model::factory('teacher')->get_all_teachers();
            $data['table_subjects'] = View::factory('classes/subjects', $data);
            $data['table_students'] = View::factory('classes/students', $data);
            $this->setTitle('Class ' . $data['level']->name . $data['class']->name)
                ->set_template_content(array("fullscreen" => true))
                ->view('classes/view', $data)
                ->render();
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_addsubject()
    {
        if(Valid::not_empty($_POST))
        {
            Model::factory('class')->add_subject($_POST);
            $this->request->redirect('sadmin/classes/view/' . $this->request->post('class'));
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_deletesubject()
    {
        if(Valid::not_empty($_POST))
        {
            list($data['subject_id'], $data['class_id']) = 
                    explode('&', $_POST['class_subject']);
            if(Model::factory('class_subject')->delete_subject($data))
                Helper_Message::add('success', 'Subject deleted successfully');
            $this->request->redirect('sadmin/classes/view/' . $data['class_id']);
        }
        else
            throw new HTTP_Exception_404;
    }


    public function action_changeteacher()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('class')->change_teacher($_POST))
                Helper_Message::add('success', 'Teacher ​​changed successfully');
            $this->request->redirect('sadmin/classes/view/' . $this->request->post('class'));
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_deletestudent()
    {
        if(Valid::not_empty($_POST))
        {
            list($data['student_id'], $data['class_id']) = 
                    explode('&', $_POST['class_student']);
            if(Model::factory('class_template')->delete_student($data))
                Helper_Message::add('success', 'Student deleted successfully');
            $this->request->redirect('sadmin/classes/view/' . $data['class_id']);
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_movestudent()
    {
        if(Valid::not_empty($_POST))
        {
            if(Model::factory('class')->move_student($_POST))
            {
                Helper_Message::add('success', 'Student ​​moved successfully');
                $this->request->redirect($this->request->referrer());
            }
        }
        else
            throw new HTTP_Exception_404;
    }
    
    private function check_class($param)
    {
//        if(strstr($param, '&'))
//        {
//            $exp = explode('&', $param);
//            switch (count($exp)) {
//                case 2:
//                    list($post['level_id'], $post['year']) = $exp;
//                    break;
//                case 3:
//                    list($post['student_id'], $post['year'], $post['record_id']) = $exp;
//                    break;
//            }
//        }
//        else
            $post['class_id'] = $param;
        if(Valid::numeric($post['class_id']))
        {
            $data = $this->data;
            $data['class'] = Model::factory('class_template')
                    ->get_class_by_id($post['class_id']);
            return $data;
        }
        return false;
    }
}