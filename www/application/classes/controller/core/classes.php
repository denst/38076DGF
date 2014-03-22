<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Core_Classes extends Controller_Core_App {
    
    public function action_view()
    {
        if(($this->data = $this->check_class($this->request->param('id'))))
        {
            $this->data['level'] = Model::factory('level')
                ->get_level_by_id($this->data['class']->level_id);
            $this->data['subjects'] = Model::factory('class_subject')
                ->get_subjects_by_class_id($this->data['class']->id);
            $this->data['students'] = $this->data['class']->students->find_all();
            $this->data['all_subject'] = Model::factory('subject')->get_all_subjects();
            $this->data['all_class'] = Model::factory('class_template')
                ->get_all_classes($this->data['level']->template_classes, $this->data['class']->year_id);
            $this->data['all_teachers'] = Model::factory('teacher')->get_all_teachers();
            $this->data['table_subjects'] = View::factory('classes/subjects', $this->data);
            $this->data['table_students'] = View::factory('classes/students', $this->data);
            if(isset($this->data['fullscreen']))
                $this->set_template_content(array("fullscreen" => true));
            $this->setTitle('Class ' . $this->data['level']->name . $this->data['class']->name)
                ->view('classes/view', $this->data)
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
            $this->request->redirect($this->data['role'].'/classes/view/' . $this->request->post('class'));
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_addsubjects()
    {
        if(Valid::not_empty($_POST))
        {
            Model::factory('class')->add_subjects($_POST);
            $this->request->redirect($this->data['role'].'/classes/view/' . $this->request->post('class'));
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_deletesubject()
    {
        if(Valid::not_empty($_POST))
        {
            list($this->data['subject_id'], $this->data['class_id']) = 
                    explode('&', $_POST['class_subject']);
            if(Model::factory('class_subject')->delete_subject($this->data))
            {
                Model::factory('year_subject')->delete_subject_year($this->data);
                Helper_Message::add('success', 'Subject deleted successfully');
            }
            $this->request->redirect($this->data['role'].'/classes/view/' . $this->data['class_id']);
        }
        else
            throw new HTTP_Exception_404;
    }
    
    public function action_deleteallsubjects()
    {
        if(Valid::not_empty($_POST))
        {
            $subjects = explode('&&', $_POST['class_subjects']);
            foreach ($subjects as $subject) 
            {
                list($this->data['subject_id'], $this->data['class_id']) = 
                        explode('&', $subject);
                if(Model::factory('class_subject')->delete_subject($this->data))
                {
                    Model::factory('year_subject')->delete_subject_year($this->data);
                }
            }
            Helper_Message::add('success', 'Subject deleted successfully');
            $this->request->redirect($this->data['role'].'/classes/view/' . $_POST['class_id']);
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
            $this->request->redirect($this->data['role'].'/classes/view/' . $this->request->post('class'));
        }
        else
            throw new HTTP_Exception_404;
    }

    public function action_deletestudent()
    {
        if(Valid::not_empty($_POST))
        {
            list($this->data['student_id'], $this->data['class_id']) = 
                    explode('&', $_POST['class_student']);
            if(Model::factory('class_template')->delete_student($this->data))
                Helper_Message::add('success', 'Student deleted successfully');
            $this->request->redirect($this->data['role'].'/classes/view/' . $this->data['class_id']);
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
        $post['class_id'] = $param;
        if(Valid::numeric($post['class_id']))
        {
            $this->data['class'] = Model::factory('class_template')
                    ->get_class_by_id($post['class_id']);
            return $this->data;
        }
        return false;
    }
}