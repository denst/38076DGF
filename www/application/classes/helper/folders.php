<?php
defined('SYSPATH') or die('No direct access allowed.');

class Helper_Folders {
    
    private static $dir_path;
    private static $role;

    public static function clean_folder($dir)
    {
        if(($objs = glob($dir."/*")))
        {
           foreach($objs as $obj) {
             is_dir($obj) ? self::remove_folder($obj) : unlink($obj);
           }
        }
    }
    
    public static function remove_folder($dir)
    {
        if(is_dir($dir))
        {
            self::clean_folder($dir);
            rmdir($dir);
        }
    }

    public static function set_image($user, $post, $role)
    {
        self::$dir_path =  APPPATH.'assets/files/users/';
        self::$role =  $role;
        if(Valid::not_empty($post['image_path']))
        {
            try 
            {
                if(self::make_folders($user))
                {
                    $image_name = explode('/110x110/', $post['image_path']);
                    if(self::moving_images($image_name[1], $user))
                    {
                        return $image_name[1];
                    }
                }
            }
            catch (Exception $exc) 
            {
                return false;
            }
        }
    }
    
    private static function make_folders($user)
    {
        $dir_path = self::$dir_path;
        if(! is_dir($dir_path.$user->id))
        {
            try 
            {
                $images_path = $dir_path.$user->id;
                mkdir($images_path);
                mkdir($images_path.'/110x110');
                mkdir($images_path.'/26x26');
                mkdir($images_path.'/46x46');
                return true;
            }
            catch (Exception $exc) 
            {
                return false;
            }
        }
        else
        {
            self::delete_old_images($user);
            return true;
        }
    }
    
    private static function delete_old_images($user)
    {
        try
        {
            $dir_path = self::$dir_path;
            $images_path = $dir_path.$user->id;
            $role = self::$role;
            $image_name = $user->$role->find()->image;
            unlink($images_path.'/110x110/'.$image_name);
            unlink($images_path.'/26x26/'.$image_name);
            unlink($images_path.'/46x46/'.$image_name);
            return true;
        }
        catch(Exception $ex)
        {
            return false;
        }
    }

    private static function moving_images($image_name, $user)
    {
        try 
        {
            $dir_path = self::$dir_path;
            $res = rename($dir_path.'temp/110x110/'.$image_name, 
                    $dir_path.$user->id.'/110x110/'.$image_name);
            rename($dir_path.'temp/26x26/'.$image_name, 
                    $dir_path.$user->id.'/26x26/'.$image_name);
            rename($dir_path.'temp/46x46/'.$image_name, 
                    $dir_path.$user->id.'/46x46/'.$image_name);
            return true;
        } 
        catch (Exception $exc) 
        {
            return false;
        }
    }

    public static function clean_user_folders()
    {
        $dir_path = self::$dir_path.'temp/';
        $user_folders = array('', '110x110/', '26x26/', '46x46/');
        foreach ($user_folders as $folder) 
        {
            self::clean_current_folder($dir_path.$folder);
        }
    }
    
    private static function clean_current_folder($dir_path)
    {
        $files = scandir($dir_path);
        unset($files[0]); unset($files[1]);
        foreach ($files as $file)   
        {
            $current_file = $dir_path.$file;
            if(is_file($current_file))
            {
                $res = unlink($current_file);
            }
        }
    }
}