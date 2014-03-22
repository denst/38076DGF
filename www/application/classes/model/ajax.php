<?php defined('SYSPATH') OR die('No direct access allowed.');

class Model_Ajax {
    
    private $errors = array();
    
    public function set_profile_image($txt, $ext, $files)
    {
        $public = "/assets"; 
        $path = "/files/users/";
        
        $actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
        ProfilerToolbar::add_log('image name', $actual_image_name, true);
        try 
        {
            $temp = Upload::save($files, $actual_image_name, APPPATH.$public.$path.'temp/', 0777);
            Image::factory($temp)
                ->resize(null, 110)
                ->save(APPPATH.$public.$path.'temp/110x110/'.$actual_image_name);
            Image::factory($temp)
                ->resize(null, 46)
                ->save(APPPATH.$public.$path.'temp/46x46/'.$actual_image_name);
            Image::factory($temp)
                ->resize(null, 26)
                ->save(APPPATH.$public.$path.'temp/26x26/'.$actual_image_name);
            unlink($temp);
                echo $path.'temp/110x110/'.$actual_image_name;
        }
        catch (Exception $exc) 
        {
            echo false;
        }
    }

    public function remove_old_profile_image($id)
    {
        $user = Model::factory("user")->get_user_by_id($id);
        if($user)
        {
            $profile_image = $user->profile_image;
            if(! is_null($profile_image))
            {
                try
                {
                    unlink(APPPATH.'assets'.$profile_image);
                    return true;
                }
                catch (Exception $ex)
                {
                }
            }
        }
        return false;
    }
    
    public function check_image($files, $form_name, $logo = false)
    {
        $valid_formats = array("jpg", "jpeg", "png", "gif", "bmp", "ico");
        $name = $files[$form_name]['name'];
        $size = $files[$form_name]['size'];
        $ext = strtolower(pathinfo($files[$form_name]['name'], PATHINFO_EXTENSION));
        if(strlen($name))
        {
            if(in_array($ext,$valid_formats))
            {
                if($size<(2*1024*1024))
                    return true;
                else
                    $this->errors =  "Image file size max 2 MB";
            }
            else
                $this->errors = "Invalid file format..";	
        }
        else
            $this->errors = "Please select image..!";
        return false;
    }
    
    public function get_errors()
    {
        return $this->errors;
    }
}